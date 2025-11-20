<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran SPP</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #eee; }
        .sudah { color: green; font-weight: bold; }
        .belum { color: red; font-weight: bold; }
    </style>
</head>
<body>
    @php 
        $bulanNama = ["","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]; 
        $kelasGrouped = $siswa->groupBy('kelas.nama_kelas'); 
    @endphp
    
    @foreach($kelasGrouped as $kelasNama => $dataKelas) 
    
    <h2>Laporan Pembayaran SPP Kelas {{ $kelasNama }}</h2>

    @endforeach
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NISN</th>
                <th rowspan="2">Nama Siswa</th>
                <th rowspan="2">Kelas</th>
                <th colspan="12">Status Pembayaran per Bulan</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= 12; $i++)
                    <th>{{ DateTime::createFromFormat('!m', $i)->format('M') }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->nisn }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->kelas->nama_kelas }}</td>

                    @for ($i = 1; $i <= 12; $i++)
                        @php
                            $status = $pembayaran
                                ->where('nisn', $s->nisn)
                                ->where('spp_id', $s->spp->id)
                                ->where('bulan_dibayar', $i)
                                ->first();
                        @endphp
                        <td>
                            @if ($status)
                                <span class="sudah">Dibayar</span>
                            @else
                                <span class="belum">Belum Dibayar</span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
