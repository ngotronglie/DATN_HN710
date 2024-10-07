<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác Thực Tài Khoản</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 10px; max-width: 600px; width: 100%; margin: 40px auto; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); text-align: center;">
        <h2 style="color: #333333; margin-bottom: 20px;">Xin chào, {{$userName}}!</h2>
        <p style="color: #555555; margin-bottom: 20px; font-size: 16px; line-height: 1.5;">
            Cảm ơn bạn đã đăng ký tài khoản tại trang web của chúng tôi. Để hoàn tất quá trình đăng ký, vui lòng xác thực tài khoản của bạn bằng cách nhấn vào nút dưới đây:
        </p>
        <div style="margin-top: 30px;">
            <a href="{{ route('verify', $token) }}" style="background-color: #28a745; color: #ffffff; padding: 12px 25px; border: none; border-radius: 5px; font-size: 16px; text-decoration: none; display: inline-block;">Xác Thực Tài Khoản</a>
        </div>
        <p style="color: #555555; margin-top: 30px; font-size: 14px;">
            Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email này.
        </p>
        <p style="color: #555555; margin-top: 30px; font-size: 14px;">
            Trân trọng,<br>Đội ngũ hỗ trợ
        </p>
    </div>
</body>
</html>
