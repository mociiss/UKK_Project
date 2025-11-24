<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran SPP - {{ $siswa->nama }}</title>

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
            font-size: 17px;
            color: #4a56a3;
        }
        .header p {
            margin: 2px 0;
            font-size: 8px;
        }

        .container{
            padding: 10px;
            border-bottom: 2px solid #4a56a3;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 2px 0;
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

        .label{
            font-weight: bold;
            color: #222;
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
        }
        th, td {
            border: none;
            padding: 4px 0;
            text-align: left;
        }

        .totals {
            margin-top: 18px;
            text-align: right;
            font-size: 14px;
            padding-top: 10px;
            border-top: 2px solid #4a56a3;
        }
        .totals strong {
            font-size: 15px;
        }

        .footer {
            margin-top: 28px;
            text-align: right;
            font-size: 11px;
            color: #555;
        }

        .thanks {
            margin-top: 18px;
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

    <div class="container">
    <table class="info-table">
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="colon">:</td>
            <td>{{ $siswa->nama }}</td>
        </tr>
        <tr>
            <td class="label">NISN</td>
            <td class="colon">:</td>
            <td>{{ $siswa->nisn }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="colon">:</td>
            <td>{{ $siswa->kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td class="label">Tahun SPP</td>
            <td class="colon">:</td>
            <td>{{ $tahun }}</td>
        </tr>
        <tr>
            <td class="label">Nominal SPP</td>
            <td class="colon">:</td>
            <td>Rp {{ number_format($siswa->spp->nominal ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Petugas</td>
            <td class="colon">:</td>
            <td>{{ $petugas }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Bayar</td>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($tanggalHariIni)->format('d F Y') }}</td>
        </tr>
    </table>
    </div>

    <p class="label">Pembayaran SPP pada Bulan : </p>
    <table>
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

    <div class="totals">
        <strong>Total Dibayar Hari Ini :</strong>
        Rp {{ number_format($totalHariIni, 0, ',', '.') }}
    </div>

    <div class="thanks">Terima kasih telah melakukan pembayaran SPP.</div>

    <div class="footer">
        Dicetak oleh: <strong>{{ session('nama') }}</strong><br>
        Dicetak pada: {{ now()->format('d F Y, H:i') }}
    </div>
</body>
</html>
