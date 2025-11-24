@extends('layouts.app')
@section('title', 'Aplikasi SPP - Data Siswa')
@section('content')
<head>
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

    </style>
</head>

<div class="container">

    <h2>Data Siswa</h2>
    <a href="{{ route('siswa.create') }}" class="btn-add">Tambah Data</a>

    <div class="filter-box">
        <form method="GET" class="filter-form">

            <div class="filter-group">
                <label>Pilih Kelas:</label>
                <select name="kelas" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
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
                        <option value="">Semua Angkatan</option>
                        @foreach(\App\Models\Spp::select('tahun')->distinct()->orderBy('tahun','desc')->get() as $t)
                            <option value="{{ $t->tahun }}" {{ request('tahun')==$t->tahun ? 'selected' : '' }}>
                                {{ $t->tahun }}
                            </option>
                        @endforeach
                    </select>
            </div>

            <div class="filter-group">
                <label for="search">Cari Siswa:</label>
                <input type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Ketik nama atau NISN..."
                        onchange="this.form.submit()">
            </div>

            <button type="submit" class="btn-search">Cari</button>
        </form>
    </div>

        @if(session('success'))
        <div class="success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>NISN</td>
                    <td>NIS</td>
                    <td>Nama Lengkap</td>
                    <td>Kelas</td>
                    <td>Alamat</td>
                    <td>No Telp</td>
                    <td>Tahun Angkatan</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>

            @forelse($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->nisn }}</td>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->kelas->nama_kelas }}</td>
                    <td>{{ $s->alamat }}</td>
                    <td>{{ $s->no_telp }}</td>
                    <td>{{ $s->spp->tahun }}</td>
                    <td>
                        <a href="{{ route('siswa.edit', $s->nisn) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('siswa.destroy', $s->nisn) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hps" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">Tidak ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection