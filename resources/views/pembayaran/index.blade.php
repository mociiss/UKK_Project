@extends('layouts.app')
@section('title', 'Data Pembayaran SPP')

@section('content')
<style>
    .btn-tambah {
        background: #4CAF50; 
        color: white; 
        padding: 8px 15px;
        border-radius: 6px; 
        text-decoration: none;
    }
    table.pembayaran { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 15px; 
    }
    th, td { padding: 8px; border: 1px solid #ddd; text-align: center; }
    .sudah { color: green; font-weight: bold; }
    .belum { color: red; font-weight: bold; }
    table.pembayaran thead tr {
        display: table-row !important;
    }
    table.pembayaran table thead th {
        display: table-cell !important;
    }
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
</style>

<h2>Riwayat Pembayaran SPP</h2>
    @php
    $periode = \Carbon\Carbon::now()->month >= 7 
    ? \Carbon\Carbon::now()->year . '/' . (\Carbon\Carbon::now()->year + 1)
    : (\Carbon\Carbon::now()->year - 1) . '/' . \Carbon\Carbon::now()->year;
    @endphp
<h3>Periode Tahun Ajaran {{ $periode }}</h3>

@if(session('role') !== 'siswa')
<div class="filter-box"> 
<form method="GET" action="{{ route('pembayaran.index') }}" style="margin-top: 10px;" class="filter-form">
    <div class="filter-group">
    <label>Pilih Kelas:</label><br>
    <select name="kelas" onchange="this.form.submit()">
        <option value="">-- Semua Kelas --</option>
        @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
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
        <label for="search">Cari Siswa / NISN:</label><br>
        <input type="text" name="search" id="search" onchange="this.form.submit()"
                value="{{ request('search') }}"
                placeholder="Ketik nama atau NISN..."">
    </div>

    <button type="submit" class="btn-search">Cari</button>
</form>
    </div>
<table class="pembayaran">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">NISN</th>
            <th rowspan="2">Nama Siswa</th>
            <th rowspan="2">Kelas</th>
            <th colspan="12">Status Pembayaran per Bulan</th>
            <th rowspan="2">Cetak</th>
        </tr>
        <tr>
            @php
            $urutanBulan = [7,8,9,10,11,12,1,2,3,4,5,6];
            @endphp

            @foreach ($urutanBulan as $b)
                <th>{{ DateTime::createFromFormat('!m', $b)->format('M') }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($siswa as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->nisn }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->kelas->nama_kelas }}</td>

                @foreach ($urutanBulan as $b)
                    @php
                        $status = $pembayaran->where('nisn', $s->nisn)->where('bulan_dibayar', $b)->first();
                    @endphp
                    <td>
                        @if ($status)
                            <span class="sudah">✔</span>
                        @else
                            <span class="belum">✖</span>
                        @endif
                    </td>
                @endforeach

                <td>
                    <a href="{{ route('pembayaran.cetak', $s->nisn) }}" target="_blank" title="Cetak Detail">
                        <img src="{{ asset('images/print.png') }}" style="width: 25px; height: 25px;">
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
@if(session('role') === 'siswa')
<div style="padding: 20px 0px; font-family: ""Poppins", sans-serif";">

    <div style="
        background:#fff;
        padding:20px;
        border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.08);
        padding-top: 1px;
    ">
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#545DB0; color:white; text-align:left;">
                    <th style="padding:10px;">No</th>
                    <th style="padding:10px;">Bulan Dibayar</th>
                    <th style="padding:10px;">Tanggal Bayar</th>
                    <th style="padding:10px;">Jumlah</th>
                    <th style="padding:10px;">Petugas</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $bulanFull = [
                        1=>"Januari", 2=>"Februari", 3=>"Maret", 4=>"April",
                        5=>"Mei", 6=>"Juni", 7=>"Juli", 8=>"Agustus",
                        9=>"September", 10=>"Oktober", 11=>"November", 12=>"Desember"
                    ];
                @endphp

                @forelse($pembayaran->sortBy(['tahun_dibayar', 'bulan_dibayar']) as $i => $p)
                    <tr style="background: {{ $i % 2 == 0 ? '#f8f9fc' : '#ffffff' }};">
                        <td style="padding:10px;">{{ $i+1 }}</td>
                        <td style="padding:10px;">{{ $bulanFull[$p->bulan_dibayar] ?? '-' }}</td>
                        <td style="padding:10px;">
                            {{ \Carbon\Carbon::parse($p->tgl_bayar)->format('d-m-Y') }}
                        </td>
                        <td style="padding:10px;">Rp {{ number_format($p->jumlah_bayar,0,',','.') }}</td>
                        <td style="padding:10px;">
                            {{ $p->petugas->nama_petugas ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:20px; color:#888;">
                            Belum ada riwayat pembayaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

@if(session('role') === 'siswa')
@if ($pembayaran->count() === 12)
<div class="alert success">
    🎉 Selamat! Kamu sudah melunasi semua pembayaran SPP tahun ini.
</div>
@else
<div class="alert warning">
    ⚠️ Masih ada tunggakan. Yuk selesaikan pembayaran bulan berikutnya.
</div>
@endif
@endif

@if(session('pdf_url'))
<script>
    window.open("{{ session('pdf_url') }}", "_blank");
</script>
@endif

@endsection
