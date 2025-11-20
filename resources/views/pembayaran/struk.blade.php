<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran SPP - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 13px;
            color: #2c3e50;
            margin: 25px 35px;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            color: #2980b9;
            letter-spacing: 1px;
        }

        .header p {
            margin: 3px 0;
            font-size: 12px;
            color: #555;
        }

        .info {
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #ddd;
        }

        th {
            background: #3498db;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px 6px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f8faff;
        }

        tr:hover {
            background-color: #eef5fb;
        }

        .totals {
            margin-top: 25px;
            text-align: right;
            line-height: 1.8;
        }

        .totals strong {
            color: #2c3e50;
        }

        .footer {
            margin-top: 35px;
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .thanks {
            text-align: center;
            margin-top: 25px;
            font-style: italic;
            color: #555;
        }

        .highlight {
            background: #eaf3fc;
            border-radius: 6px;
            padding: 3px 6px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>STRUK PEMBAYARAN SPP</h2>
        <p>SMK TI PEMBANGUNAN CIMAHI</p>
        <P>JL. H. BAKAR NO. 18 B / JL. CISEUPAN kOTA CIMAHI</P>
    </div>

    <div class="info">
        <p><strong>Nama Siswa : </strong> <span class="highlight">{{ $siswa->nama }}</span></p>
        <p><strong>NISN : </strong> {{ $siswa->nisn }}</p>
        <p><strong>Kelas : </strong> {{ $siswa->kelas->nama_kelas }}</p>
        <p><strong>Petugas : </strong> {{ $petugas }}</p>
        <p><strong>Tanggal Bayar :</strong> {{ \Carbon\Carbon::parse($tanggalHariIni)->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:40px;">No</th>
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

    <div class="totals">
        <p><strong>Total Pembayaran SPP :</strong> Rp {{ number_format($totalHariIni, 0, ',', '.') }}</p>
    </div>

    <div class="thanks">
        Terima kasih telah melakukan pembayaran SPP.
    </div>

    <div class="footer">
        Dicetak oleh: <strong>{{ session('nama') }}</strong><br>
        Dicetak pada: {{ now()->format('d F Y, H:i') }}
    </div>
</body>
</html>
