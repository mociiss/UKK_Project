<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .left {
            width: 36%;
            background: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left img {
            width: 100%;
            height: 100%;
            opacity: 70% ;
        }

        .right {
            width: 64%;
            background: #0d6efd;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .circle1,
        .circle2 {
            position: absolute;
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 50%;
        }

        .circle1 {
            width: 350px;
            height: 350px;
            bottom: -120px;
            right: -60px;
        }

        .circle2 {
            width: 250px;
            height: 250px;
            bottom: -80px;
            right: 80px;
        }

        .card {
            background: white;
            width: 350px;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin: 0 0 10px 0;
            font-size: 26px;
            font-weight: 700;
        }

        .card p {
            color: #555;
            margin-bottom: 25px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: #444;
        }

        input {
            width: 100%;
            margin: 8px 0 18px 0;
            padding: 12px;
            border-radius: 30px;
            border: 1px solid #d8d8d8;
            background: #fafafa;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #0d6efd;
            background: #fff;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #0b5ed7;
        }

        .error-message {
            background: #ffe5e5;
            padding: 8px 12px;
            border-radius: 8px;
            border-left: 4px solid red;
            color: #d90429;
            margin-bottom: 15px;
        }

        .forgot {
            margin-top: 10px;
            color: #444;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
        }

        .forgot:hover {
            text-decoration: underline;
        }
/* 
        @media(max-width: 900px) {
            .left { display: none; }
            .right { width: 100%; border-radius: 0; }
        } */
    </style>
</head>
<body>

    <div class="left">
        <img src="{{ 'images/image.png' }}">
    </div>

    <div class="right">
        <div class="circle1"></div>
        <div class="circle2"></div>

        <div class="card">
            <h2>Selamat Datang!</h2>
            <p>Masuk untuk melanjutkan.</p>

            <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
                @csrf

                <label>Nama Pengguna atau NIS</label>
                <input type="text" name="username" required>

                <label>Kata Sandi</label>
                <input type="password" name="password" required>

                @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
                @endif

                <button type="submit">Masuk</button>
            </form>
        </div>

    </div>

</body>
</html>
