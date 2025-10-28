<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Berhasil</title>
    <meta http-equiv="refresh" content="5;url={{ url('/dashboard-guest') }}">
    <style>
        body {
            background: linear-gradient(135deg, #ffe6f0, #ffc6d9);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        .success-box {
            background: #fff;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(255, 105, 180, 0.25);
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #ff3c8d;
        }

        p {
            color: #555;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .loading {
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h2>Login Berhasil!</h2>
        <p>Selamat datang, <b>{{ $email }}</b> 🎉</p>
        <p class="loading">Mengalihkan ke dashboard...</p>
    </div>
</body>
</html>
