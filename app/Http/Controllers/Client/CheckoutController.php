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

    // public function placeOrder(Request $request)
    // {
    //     $user = auth()->user();
    //     $shippingFee = 30000;
    //     $voucherId = session('voucher_id');
    //     $totalAmount = $request->input('total_amount');
    //     $totalAmountWithDiscount = session('totalAmountWithDiscount', 0);

    //     if (!$totalAmountWithDiscount) {
    //         $totalAmountWithDiscount = $totalAmount + $shippingFee;
    //     }

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'phone' => 'required|string|regex:/^0[0-9]{9}$/',
    //         'address' => 'required|string|max:255',
    //         'voucher_id' => 'nullable|integer|exists:vouchers,id',
    //         'payment_method' => 'required|in:cod,online',
    //         'note' => 'nullable|string|max:500',
    //     ], [
    //         'name.required' => 'Tên không được bỏ trống.',
    //         'email.required' => 'Email không được bỏ trống.',
    //         'email.email' => 'Email không đúng định dạng.',
    //         'phone.required' => 'Số điện thoại không được bỏ trống.',
    //         'phone.regex' => 'Số điện thoại không hợp lệ.',
    //         'address.required' => 'Địa chỉ không được bỏ trống.',
    //         'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
    //         'payment_method.in' => 'Phương thức thanh toán không hợp lệ.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()->all()
    //         ]);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $discount = null;
    //         if ($voucherId) {
    //             $voucher = Voucher::lockForUpdate()->find($voucherId);
    //             if (!$voucher || $voucher->quantity < 1) {
    //                 throw new \Exception('Voucher này đã hết số lượng sử dụng.');
    //             }

    //             if ($user) {
    //                 $usedVoucher = DB::table('user_vouchers')
    //                     ->where('user_id', $user->id)
    //                     ->where('voucher_id', $voucher->id)
    //                     ->where('status', 'used')
    //                     ->first();

    //                 if ($usedVoucher) {
    //                     throw new \Exception('Bạn đã sử dụng voucher này trước đây.');
    //                 }

    //                 DB::table('user_vouchers')
    //                     ->where('user_id', $user->id)
    //                     ->where('voucher_id', $voucher->id)
    //                     ->update(['status' => 'used']);
    //             }

    //             $discount = $voucher->discount;
    //             $voucher->decrement('quantity', 1);
    //         }

    //         $order = Order::create([
    //             'user_id' => $user ? $user->id : null,
    //             'user_name' => $request->input('name'),
    //             'user_email' => $request->input('email'),
    //             'user_phone' => $request->input('phone'),
    //             'user_address' => $request->input('address'),
    //             'voucher_id' => $voucherId,
    //             'discount' => $discount,
    //             'total_amount' => $totalAmountWithDiscount,
    //             'payment_method' => $request->input('payment_method'),
    //             'payment_status' => $request->input('payment_method') === 'cod' ? 'unpaid' : 'paid',
    //             'order_code' => $this->generateUniqueOrderCode(),
    //             'note' => $request->input('note', ''),
    //         ]);

    //         // Xử lý các sản phẩm trong đơn hàng
    //         foreach ($request->input('product_name') as $index => $productName) {
    //             $sizeName = $request->input('size_name')[$index];
    //             $colorName = $request->input('color_name')[$index];
    //             $quantity = $request->input('quantity')[$index];
    //             $price = $request->input('price')[$index];

    //             $productVariant = ProductVariant::whereHas('product', function ($query) use ($productName) {
    //                 $query->where('name', $productName);
    //             })->whereHas('size', function ($query) use ($sizeName) {
    //                 $query->where('name', $sizeName);
    //             })->whereHas('color', function ($query) use ($colorName) {
    //                 $query->where('name', $colorName);
    //             })->first();

    //             if ($productVariant) {
    //                 if ($productVariant->quantity < $quantity) {
    //                     throw new \Exception("Sản phẩm không đủ số lượng trong kho.");
    //                 }

    //                 $order->orderDetails()->create([
    //                     'product_variant_id' => $productVariant->id,
    //                     'quantity' => $quantity,
    //                     'price' => $price,
    //                     'product_name' => $productName,
    //                     'size_name' => $sizeName,
    //                     'color_name' => $colorName,
    //                 ]);

    //                 $productVariant->decrement('quantity', $quantity);
    //             }
    //         }

    //         // Xóa sản phẩm đã đặt khỏi giỏ hàng
    //         $productVariantIds = $request->input('product_variant_ids', []);
    //         if (!empty($productVariantIds)) {
    //             if ($user) {
    //                 $cart = Cart::where('user_id', $user->id)->first();
    //                 if ($cart) {
    //                     foreach ($productVariantIds as $productVariantId) {
    //                         $cartItem = $cart->items()->where('product_variant_id', $productVariantId)->first();
    //                         if ($cartItem) {
    //                             $cartItem->delete();
    //                         }
    //                     }
    //                 }

    //                 $count = CartItem::whereHas('cart', function ($query) use ($user) {
    //                     $query->where('user_id', $user->id);
    //                 })
    //                     ->distinct('product_variant_id')
    //                     ->count('product_variant_id');
    //             } else {
    //                 $cart = Session::get('cart', []);
    //                 $updatedItems = collect($cart['items'])->filter(function ($item) use ($productVariantIds) {
    //                     return !in_array($item['product_variant_id'], $productVariantIds);
    //                 })->values()->toArray();
    //                 $cart['items'] = $updatedItems;
    //                 session()->put('cart', $cart);

    //                 $count = count($updatedItems);
    //             }
    //         }

    //         // Gửi email
    //         Mail::to($order->user_email)->send(new InvoiceMail($order));

    //         session()->forget('voucher_id');

    //         $admin = User::whereIn('role', ['1', '2'])->get();
    //         if ($admin) {
    //             Notification::send($admin, new OrderPlacedNotification($order));
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'order' => $order,
    //             'count' => $count,
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //         ]);
    //     }
    // }

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
            if ($request->payment_method == "cod") {
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

                    $discount = $voucher->discount;
                    $voucher->decrement('quantity', 1);
                }

                $order = Order::create([
                    'user_id' => $user ? $user->id : null,
                    'user_name' => $request->input('name'),
                    'user_email' => $request->input('email'),
                    'user_phone' => $request->input('phone'),
                    'user_address' => $request->input('address'),
                    'voucher_id' => $voucherId,
                    'discount' => $discount,
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
                if ($admin) {
                    Notification::send($admin, new OrderPlacedNotification($order));
                }

            } elseif ($request->payment_method == "online") {
                $order_code = $this->generateUniqueOrderCode();
                return $this->vnpay($totalAmountWithDiscount, $order_code);
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

    public function vnpay($total_amount, $order_code)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL để gửi yêu cầu thanh toán đến VNPAY
        $vnp_Returnurl = "http://datn_hn710.test/payment-return"; // Đường dẫn trả về sau khi thanh toán thành công (người dùng sẽ được chuyển tới trang này)
        $vnp_TmnCode = "2T9UE2DJ"; //Mã website tại VNPAY
        $vnp_HashSecret = "O784PFF5TJIP111QHSFZ96VDL6CKN5DG"; //Chuỗi bí mật

        $vnp_TxnRef = $order_code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toan don hang qua VNPAY'; // Mô tả ngắn về đơn hàng, gửi cho VNPAY
        $vnp_OrderType = 'billpayment'; // Loại giao dịch, ở đây là thanh toán hóa đơn
        $vnp_Amount = $total_amount * 100; // Số tiền thanh toán
        $vnp_Locale = 'vn'; // Ngôn ngữ giao dịch, 'vn' cho tiếng Việt
        // $vnp_BankCode = 'NCB'; // Mã ngân hàng
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP của người gửi yêu cầu thanh toán, thông tin này sẽ được ghi nhận khi thực hiện thanh toán
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = now()->addMinutes(15)->format('YmdHis'); // Thời gian hết hạn của giao dịch (thời gian cho phép thanh toán, thường là 15 phút)
        //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Address = $_POST['txt_inv_addr1'];
        // $vnp_Bill_City = $_POST['txt_bill_city'];
        // $vnp_Bill_Country = $_POST['txt_bill_country'];
        // $vnp_Bill_State = $_POST['txt_bill_state'];
        // Invoice
        // $vnp_Inv_Phone = $_POST['txt_inv_mobile'];
        // $vnp_Inv_Email = $_POST['txt_inv_email'];
        // $vnp_Inv_Customer = $_POST['txt_inv_customer'];
        // $vnp_Inv_Address = $_POST['txt_inv_addr1'];
        // $vnp_Inv_Company = $_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode = $_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type = $_POST['cbo_inv_type'];
        $inputData = array(
            "vnp_Version" => "2.1.0", // Phiên bản của API VNPAY
            "vnp_TmnCode" => $vnp_TmnCode, // Mã website của Merchant
            "vnp_Amount" => $vnp_Amount, // Số tiền thanh toán (đã nhân với 100)
            "vnp_Command" => "pay", // Lệnh thanh toán
            "vnp_CreateDate" => date('YmdHis'), // Thời gian tạo yêu cầu thanh toán
            "vnp_CurrCode" => "VND", // Mã đơn vị tiền tệ, ở đây là VND
            "vnp_IpAddr" => $vnp_IpAddr, // Địa chỉ IP của người yêu cầu thanh toán
            "vnp_Locale" => $vnp_Locale, // Ngôn ngữ giao dịch
            "vnp_OrderInfo" => $vnp_OrderInfo, // Thông tin đơn hàng
            "vnp_OrderType" => $vnp_OrderType, // Loại giao dịch
            "vnp_ReturnUrl" => $vnp_Returnurl, // URL trả về sau khi thanh toán xong
            "vnp_TxnRef" => $vnp_TxnRef, // Mã đơn hàng (để xác định giao dịch trong hệ thống)
            "vnp_ExpireDate" => $vnp_ExpireDate, // Thời gian hết hạn giao dịch

            // "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            // "vnp_Bill_Email" => $vnp_Bill_Email,
            // "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            // "vnp_Bill_LastName" => $vnp_Bill_LastName,
            // "vnp_Bill_Address" => $vnp_Bill_Address,
            // "vnp_Bill_City" => $vnp_Bill_City,
            // "vnp_Bill_Country" => $vnp_Bill_Country,
            // "vnp_Inv_Phone" => $vnp_Inv_Phone,
            // "vnp_Inv_Email" => $vnp_Inv_Email,
            // "vnp_Inv_Customer" => $vnp_Inv_Customer,
            // "vnp_Inv_Address" => $vnp_Inv_Address,
            // "vnp_Inv_Company" => $vnp_Inv_Company,
            // "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
            // "vnp_Inv_Type" => $vnp_Inv_Type
        );

        // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        //     $inputData['vnp_BankCode'] = $vnp_BankCode;
        // }
        // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        // }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // $returnData = array(
        //     'code' => '00',
        //     'message' => 'success',
        //     'data' => $vnp_Url
        // );
        // if (isset($_POST['redirect'])) {
        //     header('Location: ' . $vnp_Url);
        //     die();
        // } else {
        //     echo json_encode($returnData);
        // }

        // Trả về URL đã mã hóa (chuyển hướng người dùng đến VNPAY để thực hiện thanh toán)
        return redirect()->to($vnp_Url);
    }

    public function paymentReturn(Request $request)
    {
        // Lấy các tham số trả về từ VNPAY
        $vnp_TxnRef = $request->input('vnp_TxnRef'); // Mã đơn hàng
        $vnp_SecureHash = $request->input('vnp_SecureHash'); // Mã bảo mật
        $vnp_ResponseCode = $request->input('vnp_ResponseCode'); // Mã phản hồi từ VNPAY
        $vnp_Amount = $request->input('vnp_Amount'); // Số tiền thanh toán
        $vnp_OrderInfo = $request->input('vnp_OrderInfo'); // Thông tin đơn hàng
        $vnp_TransactionNo = $request->input('vnp_TransactionNo'); // Mã giao dịch
        $vnp_CurrCode = $request->input('vnp_CurrCode'); // Mã tiền tệ

        // Chuỗi thông tin dùng để tạo mã bảo mật
        $hashdata = '';
        foreach ($request->all() as $key => $value) {
            if ($key != 'vnp_SecureHash' && $key != 'vnp_SecureHashType') {
                $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
            }
        }

        // Mã bí mật của VNPAY
        $vnp_HashSecret = "O784PFF5TJIP111QHSFZ96VDL6CKN5DG"; // Cần thay đổi thành mã bí mật của bạn

        // Tính toán mã bảo mật (hash) từ các tham số đã gửi
        $vnpSecureHashCheck = hash_hmac('sha512', rtrim($hashdata, '&'), $vnp_HashSecret);

        // Kiểm tra xem mã bảo mật có khớp không
        if ($vnpSecureHashCheck == $vnp_SecureHash) {
            // Nếu mã bảo mật hợp lệ, kiểm tra mã phản hồi
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công
                // Cập nhật trạng thái đơn hàng trong cơ sở dữ liệu (đã thanh toán thành công)
                // $order = Order::where('order_code', $vnp_TxnRef)->first();
                // if ($order) {
                //     $order->status = 'paid'; // Cập nhật trạng thái đơn hàng thành "Đã thanh toán"
                //     $order->transaction_no = $vnp_TransactionNo;
                //     $order->save();
                // }

                // Thông báo thanh toán thành công và chuyển hướng người dùng
                return view('client.pages.checkouts.success'); // Điều hướng tới trang thành công
            } else {
                // Thanh toán không thành công
                // Thực hiện hành động khi thanh toán không thành công (cập nhật trạng thái, thông báo lỗi, v.v.)
                return view('client.pages.checkouts.fail'); // Điều hướng tới trang thất bại
            }
        } else {
            // Nếu mã bảo mật không hợp lệ
            return view('client.pages.checkouts.fail'); // Điều hướng tới trang lỗi
        }
    }
}
