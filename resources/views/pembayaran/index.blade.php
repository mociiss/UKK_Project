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
</style>

<h2>Histori Pembayaran SPP</h2>

<form method="GET" action="{{ route('pembayaran.index') }}" style="margin-top: 10px;">
    <label>Pilih Kelas:</label>
    <select name="kelas" onchange="this.form.submit()">
        <option value="">-- Semua Kelas --</option>
        @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kelas }}
            </option>
        @endforeach
    </select>
    <div>
        <label for="search">Cari Siswa / NISN:</label>
        <input type="text" name="search" id="search"
                value="{{ request('search') }}"
                placeholder="Ketik nama atau NISN..."
                style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 6px;">
    </div>

    <button type="submit" style="padding: 6px 12px; border: none; border-radius: 6px; background: #3498db; color: white; cursor: pointer;">Cari</button>
</form>

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
                        $status = $pembayaran->where('nisn', $s->nisn)->where('bulan_dibayar', $i)->first();
                    @endphp
                    <td>
                        @if ($status)
                            <span class="sudah">✔</span>
                        @else
                            <span class="belum">✖</span>
                        @endif
                    </td>
                @endfor
                <td>
                    <a href="{{ route('pembayaran.cetak', $s->nisn) }}" target="_blank" title="Cetak Detail">
                        <img src="{{ asset('images/print.png') }}" style="width: 25px; height: 25px;">
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(session('pdf_url'))
<script>
    window.open("{{ session('pdf_url') }}", "_blank");
</script>
@endif

@endsection
