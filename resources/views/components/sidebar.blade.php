<head>
    <style>
        /* Sidebar container */
        .sidebar-container {
            font-family: "Poppins", sans-serif;
            background: #fff;
            width: 280px;
            height: 100vh;
            padding: 20px;
            box-shadow: 2px 0 12px rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .sidebar-header img {
            width: 60px;
            height: 60px;
        }
        .sidebar-header span {
            font-weight: 600;
            font-size: 18px;
            color: #2c3e50;
            line-height: 1.2;
        }

        /* Profile section */
        .profile-card {
            background: #f8f9fb;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .profile-card img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        .profile-info strong {
            font-size: 14px;
            color: #2c3e50;
        }
        .profile-info small {
            color: #6c757d;
            font-size: 12px;
        }

        /* Menu styling */
        .menu-section {
            margin-bottom: 20px;
        }
        .menu-title {
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
            color: #7f8c8d;
            margin: 15px 10px 5px;
        }
        .menu a {
            display: block;
            text-decoration: none;
            color: #2c3e50;
            margin: 4px 10px;
            font-size: 15px;
            padding: 10px 14px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .menu a:hover, 
        .menu a.active {
            background: #545DB0;
            color: #fff;
            box-shadow: 0 2px 6px rgba(84,93,176,0.3);
        }

        .logout {
            margin-top: 10px;
            text-align: center;
        }
        .logout a {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
        }
        .logout a:hover {
            background: #c0392b;
        }
    </style>
</head>

<body>
    <div class="sidebar-container">
        <div>
            <div class="sidebar-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span>E-SPP<br>SMK TI Pembangunan</span>
            </div>

            <div class="profile-card">
                <img src="{{ asset('images/user_spp.png') }}" alt="User">
                <div class="profile-info">
                    <strong>{{ session('nama') ?? 'User' }}</strong>
                    <small>{{ ucfirst(session('role') ?? '-') }}</small>
                </div>
            </div>

            <div class="menu">
                <div class="menu-section">
                    <div class="menu-title">Dashboard</div>
                    @if(session('role') === 'petugas' || session('role') === 'admin')
                        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @endif
                    @if(session('role') === 'siswa')
                    <div class="menu-section">
                        <div class="menu-title">Dashboard</div>
                        <a href="{{ route('siswadashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                    </div>
                    @endif
                </div>

                @if(session('role') === 'admin')
                <div class="menu-section">
                    <div class="menu-title">Kelola Data</div>
                    <a href="{{ route('petugas.index') }}" class="{{ request()->is('petugas*') ? 'active' : '' }}">Data Petugas</a>
                    <a href="{{ route('siswa.index') }}" class="{{ request()->is('siswa*') ? 'active' : '' }}">Data Siswa</a>
                    <a href="{{ route('kelas.index') }}" class="{{ request()->is('kelas*') ? 'active' : '' }}">Data Kelas</a>
                    <a href="{{ route('spp.index') }}" class="{{ request()->is('spp*') ? 'active' : '' }}">Data SPP</a>
                </div>
                <div class="menu-section">
                    <div class="menu-title">Transaksi</div>
                    <a href="{{ route('pembayaran.create') }}" class="{{ request()->is('pembayaran/create') ? 'active' : '' }}">
                    Pembayaran
                    </a>
                    <a href="{{ route('pembayaran.index') }}" class="{{ request()->is('pembayaran') ? 'active' : '' }}">Histori Pembayaran</a>
                    <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">Laporan Pembayaran</a>
                </div>
                @endif
            </div>
        </div>

    </div>
</body>
