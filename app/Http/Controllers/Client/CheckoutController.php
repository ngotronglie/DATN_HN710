<?php

namespace App\Http\Controllers\Client;


use App\Models\CartItem;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\InvoiceMail;
use App\Models\OrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

    public function index(Request $request)
    {

        $user = auth()->user();
        $validVouchers = collect();
        session()->forget(['discount', 'totalAmountWithDiscount', 'voucher_id']);
        $items = json_decode($request->input('item'), true);

        if (empty($items)) {
            return redirect()->back()->with('error', 'Không có sản phẩm nào được chọn.');
        }

        $total = $request->input('totalMyprd');  // Tổng tiền từ frontend
        $ids = array_column($items, 'id');  // Lấy mảng các id từ items
        $productVariants = ProductVariant::whereIn('id', $ids)->get();

        if ($productVariants->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm nào.');
        }

        $products = $productVariants->map(function ($variant) use ($items) {

            foreach ($items as $item) {
                if ($variant->id == $item['id']) {
                    $variant->name = $variant->product->name;
                    $variant->price = $variant->price_sale;
                    $variant->quantity = $item['quantity'];
                    $variant->sumtotal = $variant->quantity * $variant->price_sale;
                    break;
                }
            }
            return $variant;
        });

        if ($user) {
            $validVouchers = Voucher::where('end_date', '>=', Carbon::now()->startOfDay())
                ->where('is_active', 1)
                ->where('quantity', '>', 0)
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('status', 'not_used');
                })
                ->where(function ($query) use ($total) {
                    $query->where('min_money', '<=', $total)
                        ->where('max_money', '>=', $total);
                })
                ->get();
            session(['totalAmount' => $total]);
        }

        return view('client.pages.checkouts.show_checkout', ['products' => $products, 'total' => $total, 'validVouchers' => $validVouchers]);
    }

    function generateUniqueOrderCode()
    {
        do {
            $orderCode = 'DT' . Str::random(8);
            $exists = Order::where('order_code', $orderCode)->exists();
        } while ($exists);

        return $orderCode;
    }

    public function placeOrder(Request $request)
    {
        $user = auth()->user();
        $shippingFee = 30000;
        $voucherId = session('voucher_id');
        $totalAmount = $request->input('total_amount');
        $totalAmountWithDiscount = session('totalAmountWithDiscount', 0);

        if (!$totalAmountWithDiscount) {
            $totalAmountWithDiscount = $totalAmount + $shippingFee;
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|regex:/^0[0-9]{9}$/',
            'address' => 'required|string|max:255',
            'voucher_id' => 'nullable|integer|exists:vouchers,id',
            'payment_method' => 'required|in:cod,online',
            'note' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Tên không được bỏ trống.',
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.required' => 'Số điện thoại không được bỏ trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'address.required' => 'Địa chỉ không được bỏ trống.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ]);
        }

        try {
            DB::beginTransaction();

            $discount = null;
            if ($voucherId) {
                $voucher = Voucher::lockForUpdate()->find($voucherId);
                if (!$voucher || $voucher->quantity < 1) {
                    throw new \Exception('Voucher này đã hết số lượng sử dụng.');
                }

                if ($user) {
                    $usedVoucher = DB::table('user_vouchers')
                        ->where('user_id', $user->id)
                        ->where('voucher_id', $voucher->id)
                        ->where('status', 'used')
                        ->first();

                    if ($usedVoucher) {
                        throw new \Exception('Bạn đã sử dụng voucher này trước đây.');
                    }

                    DB::table('user_vouchers')
                        ->where('user_id', $user->id)
                        ->where('voucher_id', $voucher->id)
                        ->update(['status' => 'used']);
                }

                $discount=$voucher->discount;
                if ($voucher->points_required == null) {
                    $voucher->decrement('quantity', 1);
                } else {
                }

            }

            $order = Order::create([
                'user_id' => $user ? $user->id : null,
                'user_name' => $request->input('name'),
                'user_email' => $request->input('email'),
                'user_phone' => $request->input('phone'),
                'user_address' => $request->input('address'),
                'voucher_id' => $voucherId,
                'discount'=>$discount,
                'total_amount' => $totalAmountWithDiscount,
                'payment_method' => $request->input('payment_method'),
                'payment_status' => $request->input('payment_method') === 'cod' ? 'unpaid' : 'paid',
                'order_code' => $this->generateUniqueOrderCode(),
                'note' => $request->input('note', ''),
            ]);

            // Xử lý các sản phẩm trong đơn hàng
            foreach ($request->input('product_name') as $index => $productName) {
                $sizeName = $request->input('size_name')[$index];
                $colorName = $request->input('color_name')[$index];
                $quantity = $request->input('quantity')[$index];
                $price = $request->input('price')[$index];

                $productVariant = ProductVariant::whereHas('product', function ($query) use ($productName) {
                    $query->where('name', $productName);
                })->whereHas('size', function ($query) use ($sizeName) {
                    $query->where('name', $sizeName);
                })->whereHas('color', function ($query) use ($colorName) {
                    $query->where('name', $colorName);
                })->first();

                if ($productVariant) {
                    if ($productVariant->quantity < $quantity) {
                        throw new \Exception("Sản phẩm không đủ số lượng trong kho.");
                    }

                    $order->orderDetails()->create([
                        'product_variant_id' => $productVariant->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'product_name' => $productName,
                        'size_name' => $sizeName,
                        'color_name' => $colorName,
                    ]);

                    $productVariant->decrement('quantity', $quantity);
                }
            }

            // Xóa sản phẩm đã đặt khỏi giỏ hàng
            $productVariantIds = $request->input('product_variant_ids', []);
            if (!empty($productVariantIds)) {
                if ($user) {
                    $cart = Cart::where('user_id', $user->id)->first();
                    if ($cart) {
                        foreach ($productVariantIds as $productVariantId) {
                            $cartItem = $cart->items()->where('product_variant_id', $productVariantId)->first();
                            if ($cartItem) {
                                $cartItem->delete();
                            }
                        }
                    }

                    $count = CartItem::whereHas('cart', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                        ->distinct('product_variant_id')
                        ->count('product_variant_id');
                } else {
                    $cart = Session::get('cart', []);
                    $updatedItems = collect($cart['items'])->filter(function ($item) use ($productVariantIds) {
                        return !in_array($item['product_variant_id'], $productVariantIds);
                    })->values()->toArray();
                    $cart['items'] = $updatedItems;
                    session()->put('cart', $cart);

                    $count = count($updatedItems);
                }
            }

            // Gửi email
            Mail::to($order->user_email)->send(new InvoiceMail($order));

            session()->forget('voucher_id');

            $admin = User::whereIn('role', ['1', '2'])->get();
            if($admin){
                Notification::send($admin, new OrderPlacedNotification($order));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order,
                'count' => $count,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }



    public function applyVoucher(Request $request)
    {
        $user = auth()->user();
        $discount = 0;
        $totalAmount = session('totalAmount', 0);
        $shippingFee = 30000;

        if ($request->has('voucher_code')) {
            $voucher = Voucher::where('code', $request->voucher_code)->first();



            if ($voucher && $voucher->is_active && $voucher->quantity > 0 && $voucher->end_date >= Carbon::parse($voucher->end_date)->gte(Carbon::today())) {




                $cartTotal = $totalAmount;

                if ($cartTotal >= $voucher->min_money && $cartTotal <= $voucher->max_money) {
                    $discount = ($voucher->discount / 100) * $totalAmount;
                    session()->put('voucher_id', $voucher->id);
                } else {
                    return response()->json(['success' => false, 'message' => 'Đơn hàng chưa nằm trong khoảng giá trị để áp dụng mã giảm giá']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ, đã hết hạn hoặc đã hết số lượng']);
            }
        }

        $totalAmountWithDiscount = $totalAmount + $shippingFee - $discount;

        session()->put('discount', $discount);
        session()->put('totalAmountWithDiscount', $totalAmountWithDiscount);

        return response()->json([
            'success' => true,
            'message' => 'Mã giảm giá đã được áp dụng thành công',
            'discount' => $discount,
            'totalAmountWithDiscount' => $totalAmountWithDiscount
        ]);
    }

    //tra cuu

    public function billSearch(Request $request)
    {
        $orderCode = $request->input('order_code');

        if (!$orderCode) {
            return view('client.pages.checkouts.order_tracking');
        }

        $bills = Order::with('voucher')
            ->where('order_code', $orderCode)
            ->get();

        if ($bills->isEmpty()) {
            return view('client.pages.checkouts.order_tracking', [
                'message' => 'Không tìm thấy đơn hàng nào với mã đơn hàng này.'
            ]);
        }

        $billIds = $bills->pluck('id');

        $billDetails = OrderDetail::whereIn('order_id', $billIds)
            ->with('productVariant')
            ->get();

        return view('client.pages.checkouts.order_tracking', compact('bills', 'billDetails'));
    }
}
