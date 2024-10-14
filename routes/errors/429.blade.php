<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>429 - Quá nhiều yêu cầu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .icon {
            font-size: 48px;
            color: #ff5e5e;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>
    <div class="error-container">
        <div class="icon">⚠️</div>
        <h1>429 - Quá nhiều yêu cầu</h1>
        <p>Bạn đã gửi quá nhiều yêu cầu trong một thời gian ngắn. Vui lòng thử lại sau.</p>
        <a href="{{ url()->previous() }}" class="btn">Quay lại</a>
        <a href="/" class="btn btn-secondary">Trang chủ</a>
    </div>
</body>
</html>
