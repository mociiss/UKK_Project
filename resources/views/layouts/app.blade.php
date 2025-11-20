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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        table thead{
            background: #545DB0;
            color: white;
        }
        table th, table td{
            padding: 13px;
            text-align: left;
        }
        table body tr:nth-child(even){
            background: #ebe4e4ff;
        }
        .btn-edit{
            padding: 5px 16px;
            background: #ffc107;
            text-align: center;
            color: white;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 3px;
        }
        .btn-edit:hover{
            background: #e6ad03ff;
        }
        a{
            text-decoration: none;
        }
        .btn-hps{
            background: rgba(146, 15, 1, 1);
            color: white;
            border: 0px;
            font-size: 14px;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-hps:hover{
            background: rgba(128, 21, 9, 1);
        }
        .btn-add{
            background: #28a745;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }
        .btn-add:hover{
            background: rgba(80, 208, 71, 1)
        }
        .section-container{
            width: 80%;
            margin: 30px auto;
            padding: 25px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.08);
        }

        .section-container h2{
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }

        .create-form{
            width: 100%;
            margin-top: 20px;
        }

        .sec-body{
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
        }

        .sec-body label{
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
        }

        .sec-body input,
        .sec-body select{
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        .sec-body input:focus,
        .sec-body select:focus{
            border-color: #4c7cff;
            box-shadow: 0 0 5px rgba(76,124,255,0.3);
        }

        .btn-container{
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-simpan{
            padding: 10px 18px;
            border: none;
            background: #4c7cff;
            color: white;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-simpan:hover{
            background: #3b68e6;
        }

        .btn-container a{
            padding: 10px 18px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.2s;
        }

        .btn-container a:hover{
            background: rgba(84, 225, 117, 1)
        }
        .success{
            width: 100%;
            background: #70fc9171;
            text-align: left;
            margin-top: 20px;
            padding: 12px;
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