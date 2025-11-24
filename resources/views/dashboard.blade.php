@extends('layouts.app')
@section('title', 'Dashboard Admin - E-SPP')
@section('content')
<style>
    .dashboard-container {
        font-family: "Poppins", sans-serif;
    }
    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        padding: 18px;
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-3px);
    }
    .card h4 {
        color: #4a56a3;
        font-size: 15px;
        margin-bottom: 8px;
    }
    .card p {
        font-size: 22px;
        font-weight: 700;
        color: #2c3e50;
    }

    .chart-container {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .recent-payments {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    th, td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }
    th {
        background: #4a56a3;
        color: #fff;
    }
</style>

<div class="dashboard-container">
    <h2 style="margin-bottom:15px;">Selamat datang, {{ session('nama') }} 👋</h2>

    <div class="cards">
        <div class="card">
            <h4>Total Siswa</h4>
            <p>{{ $totalSiswa }}</p>
        </div>
        <div class="card">
            <h4>Total Kelas</h4>
            <p>{{ $totalKelas }}</p>
        </div>
        <div class="card">
            <h4>Total Petugas</h4>
            <p>{{ $totalPetugas }}</p>
        </div>
        <div class="card">
            <h4>Total Pembayaran Masuk</h4>
            <p>Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- <div class="chart-container">
        <h3>Grafik Pembayaran per Bulan</h3>
        <canvas id="chartPembayaran"></canvas>
    </div> -->

    <div class="recent-payments">
        <h3>Pembayaran Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Bulan Dibayar</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayaranTerbaru as $p)
                <tr>
                    <td>{{ $p->siswa->nama }}</td>
                    <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                    <td>{{ $bulan[$p->bulan_dibayar] }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_bayar)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartPembayaran');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            label: 'Total Pembayaran (Rp)',
            data: {!! json_encode($totals) !!},
            backgroundColor: '#4a56a3',
            borderRadius: 6
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endsection
