<!DOCTYPE html>
<html>
<head>
    <title>Detail Pembayaran SPP</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 20px; }
        h2, h3 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        .header-info { margin-bottom: 20px; }
        .header-info p { margin: 4px 0; }
    </style>
</head>
<body>
    <h2>Detail Pembayaran SPP</h2>

    <div class="header-info">
        <p><strong>Nama Siswa :</strong> {{ $siswa->nama }}</p>
        <p><strong>NISN :</strong> {{ $siswa->nisn }}</p>
        <p><strong>Kelas :</strong> {{ $siswa->kelas->nama_kelas }}</p>
        <p><strong>Tahun Angkatan :</strong> {{ $siswa->spp->tahun }}</p>
        <p><strong>Nominal SPP :</strong> Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan Dibayar</th>
                <th>Tahun Dibayar</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah Bayar</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembayaran as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $bulan[$p->bulan_dibayar] }}</td>
                    <td>{{ $p->tahun_dibayar }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_bayar)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ $p->petugas->nama_petugas ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada pembayaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="text-align:right; margin-top:30px;">
        Dicetak oleh: <strong>{{ session('nama') }}</strong><br>
        Tanggal: {{ now()->format('d M Y') }}
    </p>
</body>
</html>
