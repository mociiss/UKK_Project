<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran SPP - {{ $siswa->nama }}</title>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 25px 35px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4a56a3;
            padding-bottom: 6px;
        }
        .header h2 {
            margin: 0;
            font-size: 19px;
            color: #4a56a3;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        .info-container {
            padding: 10px 0;
            border-bottom: 2px solid #4a56a3;
            margin-bottom: 15px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 0;
            border: none;
        }
        .info-table td, .info-table th{
            text-align: left;
        }
        .info-table .label {
            width: 130px;
            font-weight: bold;
            color: #222;
        }
        .info-table .colon {
            width: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th {
            background: #4a56a3;
            color: #fff;
            font-size: 12px;
            padding: 6px 0;
        }
        th, td {
            border: none;
            text-align: left;
            padding: 5px 0;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .totals {
            margin-top: 15px;
            text-align: right;
            font-size: 13px;
            border-bottom: 2px solid #4a56a3;
            padding-bottom: 10px;
        }

        .totals strong {
            font-size: 14px;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
            font-size: 11px;
            color: #555;
            border-top: 2px solid #4a56a3;
            padding-top: 10px;
        }

        .thanks {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>SMK TI PEMBANGUNAN CIMAHI</h2>
        <p>JL. H. BAKAR NO. 18 B / JL. CISEUPAN, KOTA CIMAHI</p>
        <p>Telp. +62 852-9393-9191 | Email : smktip_cimahi@yahoo.co.id</p>
    </div>

    <div class="info-container">
        <table class="info-table">
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="colon">:</td>
                <td>{{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td class="label">NIS</td>
                <td class="colon">:</td>
                <td>{{ $siswa->nis }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="colon">:</td>
                <td>{{ $siswa->kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td class="label">Tahun Angkatan</td>
                <td class="colon">:</td>
                <td>{{ $siswa->spp->tahun }}</td>
            </tr>
            <tr>
                <td class="label">Nominal SPP</td>
                <td class="colon">:</td>
                <td>Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</td>
            </tr>
        </table>
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
        
    @php
        $totalDibayar = $pembayaran->sum('jumlah_bayar');
        $bulanSudahDibayar = $pembayaran->count();
        $bulanTunggakan = 12 - $bulanSudahDibayar;
        $totalTunggakan = $bulanTunggakan * $siswa->spp->nominal;
    @endphp

<!-- <table style="margin-top: 15px;">
    <tr>
        <td><strong>Total Dibayar</strong></td>
        <td>:</td>
        <td>Rp {{ number_format($totalDibayar, 0, ',', '.') }}</td>
    </tr> -->
    <!-- <tr>
        <td><strong>Bulan Tunggakan</strong></td>
        <td>:</td>
        <td>{{ $bulanTunggakan }} Bulan</td>
    </tr> -->

    <!-- <tr>
        <td><strong>Total Tunggakan</strong></td>
        <td>:</td>
        <td>Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</td>
    </tr> -->
</table>

    <div class="totals">
        <strong>Total Dibayar :</strong> Rp {{ number_format($totalDibayar, 0, ',', '.') }}<br>
    </div>

    <div class="thanks">
        Terima kasih telah melakukan pembayaran SPP secara rutin.
    </div>

    <div class="footer">
        Dicetak oleh: <strong>{{ session('nama') }}</strong><br>
        Dicetak pada: {{ now()->format('d F Y, H:i') }}
    </div>
</body>
</html>
