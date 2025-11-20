    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                background: #e1fffbff;
                align-items: center;
                display: flex;
                justify-content: center;
                font-family: "Poppins", sans-serif; 
                height: 100dvh;
            }
            .card{
                padding: 10px 20px 10px 20px;
                background-color: #fefeffff;
                border-radius: 8px;
                width: 360px;
            }
            h2{
                text-align: center;
            }
            form label{
                font-size: 18px;
                text-align:left;
                margin: 5px, 5px, 10px, 0px;
            }
            input{
                border: 1px solid #040539ff;
                font-size: large;
                padding: 10px;
                width: 94%;
                border-radius: 8px;
                margin: 5px 0px;
            }
            button{
                padding: 10px;
                font-size: 15px;
                text-align: center;
                margin: 8px 0px;
                width: 100%;
                background: #68ff6dff;
                border: 1px solid black;
                border-radius: 8px
            }
        </style>
    </head>
    <body>

        <div class="card">
            <h2>Login</h2>
            <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
                @csrf
                <label for="">Username</label><br>
                <input type="text" name="username" id="" required autocomplete="off" display="none"><br>
                <label for="">Password</label><br>
                <input type="password" name="password" id="" required autocomplete="off"><br>
                @if (session('error'))
                    <div style="color:red; margin-bottom:10px;">
                        {{ session('error') }}
                    </div>
                @endif
                <button type="submit">Masuk</button>
            </form>
        </div>
    </body>
    </html>