@extends('layouts.app')
@section('title', 'Preview Struk Pembayaran')

@section('content')
<style>
.overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.struk-card {
    background: #fff;
    width: 500px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    padding: 25px;
    position: relative;
    animation: fadeIn 0.4s ease;
}
@keyframes fadeIn { from { opacity: 0; transform: scale(0.95);} to { opacity: 1; transform: scale(1);} }
h3 {
    text-align: center;
    color: #2980b9;
    margin-bottom: 15px;
}
.info p {
    margin: 3px 0;
    font-size: 14px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
th, td {
    border: 1px solid #ddd;
    padding: 6px;
    text-align: center;
    font-size: 13px;
}
th {
    background-color: #3498db;
    color: #fff;
}
.footer {
    text-align: right;
    margin-top: 20px;
}
.btn-print, .btn-close {
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-print {
    background: #3498db;
    color: #fff;
}
.btn-print:hover { background: #2980b9; }
.btn-close {
    background: #bdc3c7;
    color: #fff;
    margin-left: 10px;
}
.btn-close:hover { background: #95a5a6; }
</style>

<div class="overlay">
    <div class="struk-card">
        <h3>STRUK PEMBAYARAN SPP</h3>
        <div class="info">
            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
            <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
            <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas }}</p>
            <p><strong>Petugas:</strong> {{ $petugas }}</p>
            <p><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($tanggalHariIni)->format('d F Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bulan Dibayar</th>
                    <th>Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $bulanAll[$p->bulan_dibayar] }}</td>
                        <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p><strong>Total Hari Ini:</strong> Rp {{ number_format($totalHariIni, 0, ',', '.') }}</p>
        </div>

        <div style="text-align:center; margin-top:20px;">
    <button type="button" class="btn-print" id="btnPrint">Cetak PDF</button>
    <a href="{{ route('pembayaran.index') }}" class="btn-close">Tutup</a>
</div>
    </div>
</div>

<script>
document.getElementById('btnPrint').addEventListener('click', function (e) {
    e.preventDefault(); // cegah perilaku default (submit/redirect)
    window.open("{{ route('pembayaran.struk', [$siswa->nisn, $tahun]) }}", "_blank");
});
</script>
@endsection
