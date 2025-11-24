@extends('layouts.app')
@section('title', 'Dashboard Siswa - E-SPP')

@section('content')
<style>
.dashboard {
    font-family: "Poppins", sans-serif;
}
.profile-box {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}
.profile-box img {
    width: 80px; height: 80px;
    border-radius: 50%;
    margin-right: 20px;
}
.summary {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}
.summary-card {
    flex: 1;
    background: #fff;
    border-radius: 12px;
    padding: 18px;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}
.summary-card h4 {
    font-size: 14px; color: #4a56a3; margin-bottom: 6px;
}
.summary-card p {
    font-size: 20px; font-weight: 700; color: #2c3e50;
}
.chart {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}
</style>

<div class="dashboard">
    <div class="profile-box">
        <img src="{{ asset('images/user_spp.png') }}" alt="User">
        <div>
            <h3>{{ $siswa->nama }}</h3>
            <p>Kelas: {{ $siswa->kelas->nama_kelas }}</p>
            <p>Tahun Ajaran: {{ $periode }}</p>
        </div>
    </div>

    <div class="summary">
        <div class="summary-card">
            <h4>Bulan Sudah Dibayar</h4>
            <p>{{ $sudahBayar }} / 12</p>
        </div>
        <div class="summary-card">
            <h4>Total Tunggakan</h4>
            <p>Rp {{ number_format($tunggakan, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h4>Nominal SPP</h4>
            <p>Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- <div class="chart">
        <h3>Status Pembayaran Bulanan</h3>
        <canvas id="chartSiswa"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartSiswa');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            label: 'Status Pembayaran',
            data: {!! json_encode($dataStatus) !!},
            backgroundColor: '#4a56a3'
        }]
    },
    options: {
        plugins: { legend: { display: false }},
        scales: { y: { beginAtZero: true, max: 1 } }
    }
});
</script> -->
@endsection
