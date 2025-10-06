<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guest</title>
    <style>
        body {
            background: linear-gradient(135deg, #ffe6f0, #ffc6d9);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.25);
            width: 330px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .login-box:hover {
            transform: translateY(-5px);
        }

        h2 {
            color: #ff3c8d;
            margin-bottom: 25px;
            font-weight: 700;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 14px;
            border: 1.5px solid #ff80b0;
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #ff3c8d;
            box-shadow: 0 0 8px rgba(255, 60, 141, 0.3);
        }

        button {
            background: linear-gradient(90deg, #ff66a3, #ff3c8d);
            color: white;
            border: 1.5px solid #ff80b0;
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }

        button:hover {
            background: linear-gradient(90deg, #ff3c8d, #ff66a3);
            transform: scale(1.03);
            box-shadow: 0 0 10px rgba(255, 60, 141, 0.35);
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #ff3c8d;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        a:hover {
            text-decoration: underline;
            color: #ff007f;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 12px;
            animation: shake 0.3s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            50% { transform: translateX(4px); }
            75% { transform: translateX(-4px); }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login Guest</h2>

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <form action="{{ url('/auth/login') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <a href="#">Lupa Password?</a>
    </div>
</body>
</html>
