    @extends('layouts.app')
    @section('title','Laporan SPP')
    @section('content')

    <style>
        table.pembayaran { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: center; }
        .sudah { color: green; font-weight: bold; }
        .belum { color: red; font-weight: bold; }
    </style>

    <h2>Laporan SPP</h2>

    <form method="GET" action="{{ route('laporan.index') }}">
        <label>Kelas:</label>
        <select name="kelas">
            <option value="">-- Semua Kelas --</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ request('kelas')==$k->id ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>

        <label>Tahun Angkatan:</label>
        <select name="tahun">
            <option value="">-- Semua Tahun --</option>
            @foreach(\App\Models\Spp::select('tahun')->distinct()->orderBy('tahun','desc')->get() as $t)
                <option value="{{ $t->tahun }}" {{ request('tahun')==$t->tahun ? 'selected' : '' }}>
                    {{ $t->tahun }}
                </option>
            @endforeach
        </select>

        <label>Filter:</label>
        <select name="filter">
            <option value="semua" {{ request('filter')=='semua'?'selected':'' }}>Semua</option>
            <option value="belum" {{ request('filter')=='belum'?'selected':'' }}>Belum Bayar</option>
        </select>

        <button type="submit">Tampilkan</button>
        <a href="{{ route('laporan.cetak', request()->all()) }}" target="_blank">
            Cetak PDF
        </a>
    </form>

    <table class="pembayaran">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NISN</th>
                <th rowspan="2">Nama Siswa</th>
                <th rowspan="2">Kelas</th>
                <th colspan="12">Status Pembayaran per Bulan ({{ request('tahun') ?? date('Y') }})</th>
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
                                <span class="sudah">✔</span>
                            @else
                                <span class="belum">✖</span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    @endsection
