<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - Quan Ly Lich Hoc</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { background-color: #007bff; color: white; padding: 10px; text-align: center; }
        .content { padding: 20px; }
        .button { display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Quản Lý Lịch Học</h2>
        </div>
        <div class="content">
            <p>Xin chào {{ isset($notifiable->name) ? $notifiable->name : 'Người dùng' }},</p>
            <p>Bạn đã yêu cầu đặt lại mật khẩu. Vui lòng nhấp vào nút bên dưới để tiếp tục:</p>
            <a href="{{ $url }}" class="button">Đặt Lại Mật Khẩu</a>
            <p>Lưu ý: Link này sẽ hết hạn sau {{ config('auth.passwords.users.expire') }} phút.</p>
            <p>Nếu bạn không yêu cầu điều này, hãy bỏ qua email này.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Quan Ly Lich Hoc. All rights reserved.</p>
        </div>
    </div>
</body>
</html>