<head>
    <style>
        .sidebar-container{
            font-family: "Poppins", sans-serif;
            background: #fff;
            width: 300px;
            height: 100vh;
            padding: 20px;
            box-shadow: 0px 6px 18px #818984;
            position: fixed;
            top: 0;
            left: 0;
        }
        .icon{
            margin-bottom: 35px;
            display: flex;
        }
        .icon span{
            align-items: center;
            font-size: 20px;
            margin-top: 30px;
        }
        .menu a{
            display: block;
            text-decoration: none;
            color: black;
            margin: 10px;
            font-size: 20px;
            background: white;
            padding: 12px;
            border-radius: 8px;
        }
        .menu a:hover{
            background: #545DB0;
            color: white;
            transition: 0.3s;
        }
    </style>
</head>
<body>
    <div class="sidebar-container">
        <div class="icon"><img src="{{ asset('images/logo.png') }}" alt="" style="width: 7rem; height: 7rem; margin-right: 10px;"><span>SMK TI Pembangunan</span></div>
        <div class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="">Data Petugas</a>
            <a href="{{ route('siswa.index') }}" class="{{ request()->is('siswa*') ? 'active' : ''}}">Data Siswa</a>
            <a href="">Data Kelas</a>
            <a href="">Data SPP</a>
            <a href="">Transaksi</a>
            <a href="">Riwayat Pembayaran</a>
            <a href="">Laporan</a>
        </div>
    </div>
</body>