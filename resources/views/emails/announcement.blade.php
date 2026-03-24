<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $announcement->title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding: 20px;">
    <div style="max-width:600px; margin:auto; background:#fff; border-radius:8px; padding:30px;">
        <h2 style="color:#333;">Hello, {{ $recipientName }}!</h2>
        <hr>
        <h3 style="color:#4a90e2;">{{ $announcement->title }}</h3>
        <p style="color:#555; line-height:1.7;">{{ $announcement->body }}</p>
        <hr>
        <p style="font-size:12px; color:#aaa;">
            This announcement was sent by your teacher via the School Management System.
        </p>
    </div>
</body>
</html>