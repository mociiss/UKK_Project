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

        .profile-wrapper {
            position: relative; /* agar dropdown bisa absolute terhadap wrapper */
        }

        .profile-card {
            background: #f8f9fb;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            cursor: pointer;
            transition: background 0.2s;
        }
        .profile-card:hover {
            background: #eef3ff;
        }

        /* Dropdown menu */
        .profile-dropdown {
            position: absolute;
            top: 70px;
            left: 0;
            width: 100%;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 10px;
            overflow: hidden;
            display: none; /* default hidden */
            z-index: 10;
            animation: fadeIn 0.2s ease-in-out;
        }

        /* Dropdown links */
        .profile-dropdown a {
            display: block;
            padding: 10px 14px;
            text-decoration: none;
            color: #2c3e50;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            transition: 0.2s;
        }
        .profile-dropdown a:last-child {
            border-bottom: none;
        }
        .profile-dropdown a:hover {
            background: #545DB0;
            color: white;
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

            <div class="profile-wrapper" style="position: relative;">
                <div class="profile-card" id="profileToggle">
                    <img src="{{ asset('images/user_spp.png') }}" alt="User">
                    <div class="profile-info">
                        <strong>{{ session('nama') ?? 'User' }}</strong>
                        <small>{{ ucfirst(session('role') ?? '-') }}</small>
                    </div>
                </div>

                <div class="profile-dropdown" id="profileMenu" style="display: none; position: absolute; top: 70px; left: 0; width: 100%; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.08); border-radius: 10px; overflow: hidden; z-index: 10;">
                    <a href="{{ route('ganti.password') }}">🔑 Ganti Password</a>
                    <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    🚪 Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="menu">
                <div class="menu-section">
                    <div class="menu-title">Dashboard</div>
                    @if(session('role') === 'admin' || session('role') === 'petugas')
                        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @endif
                    @if(session('role') === 'siswa')
                        <a href="{{ route('siswadashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @endif
                </div>

                @if(session('role') === 'siswa')
                <div class="menu-section">
                    <div class="menu-title">Transaksi</div>
                    <a href="{{ route('pembayaran.index') }}" class="{{ request()->is('pembayaran') ? 'active' : '' }}">Histori Pembayaran</a>
                </div>
                @endif

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
                    <a href="{{ route('pembayaran.index') }}" class="{{ request()->is('pembayaran') ? 'active' : '' }}">Riwayat Pembayaran</a>
                    <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">Laporan Pembayaran</a>
                </div>
                <div class="menu-section">
                    <div class="menu-title">Aktivitas Pengguna</div>
                    <a href="{{ route('activity.log') }}" class="{{ request()->is('activity-log') ? 'active' : '' }}">Activity Log</a>
                </div>
                @endif
            </div>
        </div>

    </div>
</body>

<script>
    const toggle = document.getElementById('profileToggle');
    const menu = document.getElementById('profileMenu');

    toggle.addEventListener('click', () => {
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });
</script>