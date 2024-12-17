<?php
return [
    'tmn_code' => env('VNP_TMNCODE', '2T9UE2DJ'), // Mã TMN, có giá trị mặc định
    'hash_secret' => env('VNP_HASHSECRET', 'O784PFF5TJIP111QHSFZ96VDL6CKN5DG'), // Mật khẩu bí mật
    'return_url' => env('VNP_RETURNURL', 'http://datn_hn710.test/payment-return'), // URL trả về
    'url' => env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'), // URL thanh toán
];
