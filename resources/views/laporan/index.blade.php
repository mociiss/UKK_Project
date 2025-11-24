    @extends('layouts.app')
    @section('title','Laporan SPP')
    @section('content')

    <style>
        .filter-box {
            margin-top: 20px;
            background: #ffffff;
            padding: 18px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
            border: 1px solid #e6e6e6;
        }
        .filter-form {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 220px;
        }

        .filter-group label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            margin-bottom: 6px;
        }

        .filter-group select,
        .filter-group input {
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #bfc8d5;
            font-size: 15px;
            transition: 0.2s;
            background: #fafafa;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: #3498db;
            background: #f7fbff;
        }
        .btn-search {
            padding: 12px 22px;
            background: #3498db;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 6px;
        }

        .btn-search:hover {
            background: #2279b8;
        }
        .btn-pdf{
            background: #ff1d1dff;
            padding: 12px 15px;
            color: white;
            font-size: 13px;
            font-weight: 600;
            border-radius: 10px;
        }
        .btn-pdf:hover{
            background: #f71515ff;
        }
        table.pembayaran { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; }
        th, td { 
            padding: 8px; 
            border: 1px solid #ddd; 
            text-align: center; }
        .sudah { 
            color: green; 
            font-weight: bold; 
        }
        .belum { 
            color: red; 
            font-weight: bold; 
        }
    </style>

    <h2>Laporan SPP</h2>

    <div class="filter-box">
    <form method="GET" action="{{ route('laporan.index') }}" class="filter-form">

    <div class="filter-group">
        <label>Kelas:</label>
        <select name="kelas" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ request('kelas')==$k->id ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="filter-group">
        <label>Tahun Angkatan:</label>
        <select name="tahun" onchange="this.form.submit()">
            <option value="">-- Semua Tahun --</option>
            @foreach(\App\Models\Spp::select('tahun')->distinct()->orderBy('tahun','desc')->get() as $t)
                <option value="{{ $t->tahun }}" {{ request('tahun')==$t->tahun ? 'selected' : '' }}>
                    {{ $t->tahun }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="filter-group">
        <label>Filter:</label>
        <select name="filter">
            <option value="semua" {{ request('filter')=='semua'?'selected':'' }}>Semua</option>
            <option value="belum" {{ request('filter')=='belum'?'selected':'' }}>Belum Bayar</option>
        </select>
    </div>

        <button type="submit" class="btn-search">Tampilkan</button>
        <a href="{{ route('laporan.cetak', request()->all()) }}" target="_blank" class="btn-pdf">
            Cetak PDF
        </a>
    </form>
    </div>

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
