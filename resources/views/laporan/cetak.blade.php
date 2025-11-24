<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran SPP</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 25px 35px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4a56a3;
            padding-bottom: 6px;
            margin-bottom: 20px;
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

        h3 {
            color: #4a56a3;
            border-bottom: 2px solid #4a56a3;
            display: inline-block;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }

        .info {
            margin-bottom: 15px;
            font-size: 13px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #4a56a3;
            color: #fff;
            padding: 6px;
            font-size: 11.5px;
            text-align: center;
        }

        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
            font-size: 11.5px;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        .sudah {
            color: #2e7d32;
            font-weight: bold;
        }

        .belum {
            color: #c62828;
            font-weight: bold;
        }

        .totals {
            margin-top: 15px;
            text-align: right;
            font-size: 13px;
            border-top: 2px solid #4a56a3;
            padding-top: 8px;
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
    </style>
</head>
<body>
    <div class="header">
        <h2>SMK TI PEMBANGUNAN CIMAHI</h2>
        <p>JL. H. BAKAR NO. 18 B / JL. CISEUPAN, KOTA CIMAHI</p>
        <p><strong>LAPORAN PEMBAYARAN SPP PER KELAS</strong></p>
    </div>

    @php 
        $bulanNama = ["","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]; 
        $kelasGrouped = $siswa->groupBy('kelas.nama_kelas'); 
    @endphp

    @foreach($kelasGrouped as $kelasNama => $dataKelas)
        @php
            $jumlahSiswa = $dataKelas->count();
            $totalDibayar = 0;
            $totalTunggakan = 0;
        @endphp

        <div class="info">
            <h3>Kelas {{ $kelasNama }}</h3>
            <p><strong>Jumlah Siswa :</strong> {{ $jumlahSiswa }}</p>
            <p><strong>Tahun Angkatan :</strong> {{ $dataKelas->first()->spp->tahun ?? '-' }}</p>
            <p><strong>Nominal SPP :</strong> Rp {{ number_format($dataKelas->first()->spp->nominal ?? 0, 0, ',', '.') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">NISN</th>
                    <th rowspan="2">Nama Siswa</th>
                    <th colspan="12">Status Pembayaran per Bulan</th>
                </tr>
                <tr>
                    @for ($i = 1; $i <= 12; $i++)
                        <th>{{ $bulanNama[$i] }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach($dataKelas as $index => $s)
                    @php 
                        $dibayarSiswa = 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->nisn }}</td>
                        <td style="text-align:left;">{{ $s->nama }}</td>

                        @for ($i = 1; $i <= 12; $i++)
                            @php
                                $status = $pembayaran
                                    ->where('nisn', $s->nisn)
                                    ->where('spp_id', $s->spp->id)
                                    ->where('bulan_dibayar', $i)
                                    ->first();

                                if ($status) $dibayarSiswa++;
                            @endphp
                            <td>
                                @if ($status)
                                    <span class="sudah">Lunas</span>
                                @else
                                    <span class="belum">×</span>
                                @endif
                            </td>
                        @endfor 
                    </tr>
                    @php
                        $totalDibayar += $dibayarSiswa * ($s->spp->nominal ?? 0);
                        $totalTunggakan += (12 - $dibayarSiswa) * ($s->spp->nominal ?? 0);
                    @endphp
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <strong>Total Sudah Dibayar :</strong> Rp {{ number_format($totalDibayar, 0, ',', '.') }}<br>
            <strong>Total Tunggakan :</strong> Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
        </div>

        <hr style="margin: 30px 0; border: 1px dashed #bbb;">
    @endforeach

    <div class="footer">
        <!-- Dicetak oleh : <strong>{{ session('nama') }}</strong><br> -->
        Dicetak pada : {{ now()->format('d F Y, H:i') }}
    </div>
</body>
</html>
