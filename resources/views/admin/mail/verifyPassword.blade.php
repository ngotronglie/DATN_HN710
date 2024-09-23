<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 20px; text-align: center;">
    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin: auto; padding: 20px; max-width: 600px;">
        <h2 style="color: #4CAF50;">Xin chào {{ $userName }}</h2>
        <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Để tiếp tục, vui lòng xác thực email của bạn bằng cách nhấp vào liên kết bên dưới. Sau khi xác thực, bạn sẽ có thể đặt lại mật khẩu của mình.</p>
        <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">Nếu bạn không yêu cầu thay đổi mật khẩu, vui lòng bỏ qua email này. Liên kết xác thực sẽ hết hạn sau 24 giờ để đảm bảo an toàn cho tài khoản của bạn.</p>
        <a href="{{ route('admin.password.reset', $token) }}" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Xác thực Email và Đặt lại Mật khẩu</a>
        <p style="font-size: 14px; color: #888; margin-top: 20px;">Nếu bạn gặp bất kỳ vấn đề nào hoặc cần hỗ trợ thêm, vui lòng liên hệ với chúng tôi qua địa chỉ email <a href="mailto:support@example.com" style="color: #4CAF50;">support@example.com</a> hoặc truy cập vào trang web của chúng tôi để biết thêm thông tin.</p>
        <p style="font-size: 14px; color: #888;">Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    </div>
</body>
</html>
