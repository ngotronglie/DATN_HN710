<?php

namespace App\Http\Controllers\Client;

use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\InvoiceMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $validVouchers = collect();
        session()->forget(['discount', 'totalAmountWithDiscount', 'voucher_id']);
        if ($user) {
            $cartItems = Cart::where('user_id', $user->id)
                ->with('items.productVariant.product', 'items.productVariant.size', 'items.productVariant.color') // Tải các mối quan hệ cần thiết
                ->get();

            foreach ($cartItems as $cart) {
                foreach ($cart->items as $item) {
                    $productVariant = $item->productVariant;
                    // Tính tổng tiền cho mỗi sản phẩm
                    $item->total_price = $productVariant->price_sale * $item->quantity;
                }
            }

            $totalAmount = $cartItems->flatMap(function ($cart) {
                return $cart->items;
            })->sum(function ($item) {
                return $item->total_price;
            });

            $validVouchers = Voucher::where('end_date', '>=', Carbon::now()->startOfDay())
                ->where('is_active', true)
                ->where('quantity', '>', 0)
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('status', 'not_used');
                })
                ->where(function ($query) use ($totalAmount) {
                    $query->where('min_money', '<=', $totalAmount)
                        ->where('max_money', '>=', $totalAmount);
                })
                ->get();
        } else {
            $cartItems = session('cart.items', []);
            $totalAmount = 0;

            foreach ($cartItems as &$item) {
                $productVariant = ProductVariant::find($item['product_variant_id']);

                if ($productVariant) {
                    $item['name'] = $productVariant->product->name;
                    $item['price_sale'] = $productVariant->price_sale;
                    $item['size'] = $productVariant->size->name;
                    $item['color'] = $productVariant->color->name;
                    $item['total_price'] = $productVariant->price_sale * $item['quantity'];
                    $totalAmount += $item['total_price'];
                }
            }
        }

        if (!$cartItems) {
            return redirect()->back()->with('warning', 'Không tìm thấy sản phẩm nào');
        }

        session(['totalAmount' => $totalAmount]);

        return view('client.pages.checkouts.show_checkout', [
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
            'validVouchers' => $validVouchers
        ]);
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
        $totalAmount = session('totalAmount', 0);
        $voucher = session('voucher_id');
        $voucherId = is_array($voucher) || is_object($voucher) ? $voucher['id'] ?? null : $voucher;
        $totalAmountWithDiscount = session('totalAmountWithDiscount', 0);
        if (!$totalAmountWithDiscount) {
            $totalAmountWithDiscount = $totalAmount + $shippingFee;
        }

        if ($user) {
            $cartItems = Cart::where('user_id', $user->id)
                ->with('items.productVariant.product', 'items.productVariant.size', 'items.productVariant.color') // Tải các mối quan hệ cần thiết
                ->get();
        } else {
            $cartItems = session('cart.items', []);
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
        //kểm tra số lluown trong kho
        foreach ($cartItems as $cart) {
            $items = $user ? $cart->items : $cartItems;
            foreach ($items as $item) {
                $productVariant = $user ? $item->productVariant : ProductVariant::find($item['product_variant_id']);

                if ($productVariant && $productVariant->quantity < ($user ? $item->quantity : $item['quantity'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Xin lỗi sản phẩm đã hết, Vui lòng mua sản phẩm khác'
                    ]);
                }
            }
        }
        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $request->input('name'),
            'user_email' => $request->input('email'),
            'user_phone' => $request->input('phone'),
            'user_address' => $request->input('address'),
            'voucher_id' => $voucherId,
            'total_amount' => $totalAmountWithDiscount,
            'payment_method' => $request->input('payment_method'),
            'payment_status' => 'unpaid',
            'order_code' => $this->generateUniqueOrderCode(),
            'note' => $request->input('note'),
        ]);


        if ($user) {
            foreach ($cartItems as $cart) {
                foreach ($cart->items as $item) {
                    if (isset($item->productVariant)) {
                        $productVariant = $item->productVariant;
                        $order->orderDetails()->create([
                            'product_variant_id' => $productVariant->id,
                            'quantity' => $item->quantity,
                            'price' => $productVariant->price_sale,
                            'product_name' => $productVariant->product->name,
                            'size_name' => $productVariant->size->name,
                            'color_name' => $productVariant->color->name,
                        ]);
                        $productVariant->decrement('quantity', $item->quantity);
                    }
                }
            }
        } else {
            foreach ($cartItems as $item) {
                $productVariant = ProductVariant::find($item['product_variant_id']);
                if ($productVariant) {
                    $order->orderDetails()->create([
                        'product_variant_id' => $productVariant->id,
                        'quantity' => $item['quantity'],
                        'price' => $productVariant->price_sale,
                        'product_name' => $productVariant->product->name,
                        'size_name' => $productVariant->size->name,
                        'color_name' => $productVariant->color->name,
                    ]);
                    $productVariant->decrement('quantity', $item['quantity']);
                }
            }
        }

        if ($voucher) {
            $voucher = Voucher::find($voucher);
            if ($voucher) {
                $voucher->decrement('quantity', 1);
                DB::table('user_vouchers')->where('user_id', $user->id)
                    ->where('voucher_id', $voucher->id)
                    ->update(['status' => 'used']);
            }
        }
        Mail::to($order->user_email)->send(new InvoiceMail($order));

        session()->forget('voucher_id');
        if ($user) {
            Cart::where('user_id', $user->id)->delete();
        } else {
            session()->forget('cart');
        }

        $admin = User::whereIn('role', ['1', '2'])->get();
        if($admin){
        Notification::send($admin, new OrderPlacedNotification($order));
        }

        return response()->json([
            'success' => true,
            'order' => $order,

        ]);
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
    public function billSearch()
    {
        return redirect()->route('home');
    }
}
