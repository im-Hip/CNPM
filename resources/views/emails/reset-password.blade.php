<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - Hệ Thống Quản Lý Lịch Học</title>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #000000; 
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container { 
            max-width: 600px; 
            margin: 30px auto; 
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header { 
            padding: 25px 20px;
            text-align: center;
        }
        .header h1 {
            color: #808080;
            font-size: 18px;
            font-weight: normal;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .logo-section {
            text-align: center;
            padding: 0 20px;
        }
        .logo-section img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .content { 
            padding: 30px 40px;
        }
        .greeting-bold {
            font-weight: bold;
            color: #000000;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .greeting-text {
            color: #000000;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .request-text {
            color: #000000;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button { 
            display: inline-block; 
            padding: 14px 35px; 
            background-color: #2563eb;
            color: #ffffff !important; 
            text-decoration: none; 
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #1d4ed8;
        }
        .note-text {
            color: #000000;
            font-size: 14px;
            margin-top: 25px;
            line-height: 1.5;
        }
        .note-text strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>HỆ THỐNG QUẢN LÝ</h1>
            <h1>LỊCH HỌC VÀ THÔNG BÁO CHO HỌC SINH</h1>
        </div>
        
        <div class="logo-section">
            <!-- <img src="{{ asset('images/sadas.png') }}" alt="Image" /> -->
             <img src="https://data.designervn.net/2019/10/9935_35ce2ded67902c06278d5f9b13b17580.png" alt="Image" />
        </div>
        
        <div class="content">
            <div class="greeting-bold">
                Bạn đã sắp hoàn thành rồi!
            </div>
            
            <div class="greeting-text">
                Xin chào {{ isset($notifiable->name) ? $notifiable->name : 'Người dùng' }}
            </div>
            
            <div class="request-text">
                Bạn đã yêu cầu đặt lại mật khẩu
            </div>
            
            <div class="request-text">
                Vui lòng nhấn nút bên dưới để tiếp tục:
            </div>
            
            <div class="button-container">
                <a href="{{ $url }}" class="button">Đặt lại mật khẩu</a>
            </div>
            
            <div class="note-text">
                <strong>Lưu ý:</strong> Link này sẽ hết hạn sau 10 phút.<br>
                Nếu bạn không yêu cầu điều này, hãy bỏ qua email này.
            </div>
        </div>
    </div>
</body>
</html>