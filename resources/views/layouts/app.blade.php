<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <style>
        *{
            box-sizing: border-box;
        }
        body{
            margin: 0;
            background: #f8fcffff;
        }
    .main {
        flex: 1;
        padding: 20px;
        padding-left: 350px;
        font-family: "Poppins", sans-serif; 
    }
    </style>
</head>
<body>
    @include('components.sidebar')
    <div class="main">
        @yield('content')
    </div>
</body>
</html>
<body>