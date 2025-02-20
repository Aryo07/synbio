<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Atur Ulang Kata Sandi Anda</h2>
        </div>
        <p>Halo,</p>
        <p>Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun Anda.</p>
        <p>Silakan klik tombol di bawah ini untuk mengatur ulang kata sandi Anda:</p>
        <div style="text-align: center;">
            <a href="{{ $url }}" class="button">Atur Ulang Kata Sandi</a>
        </div>
        <p>Tautan pengaturan ulang kata sandi ini akan expired dalam {{ $expiresAt }} menit.</p>
        <p>Jika Anda tidak meminta pengaturan ulang kata sandi, tidak ada tindakan lebih lanjut yang diperlukan.</p>
        <div class="footer">
            <p>Jika Anda mengalami kesulitan mengklik tombol "Atur Ulang Kata Sandi", salin dan tempel URL di bawah ini ke browser web Anda: <a href="{{ $url }}" target="_blank">{{ $url }}</a></p>

            <p>&copy; 2023 Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
