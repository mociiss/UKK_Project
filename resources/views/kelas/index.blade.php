@extends('layouts.app')

@section('title', 'Aplikasi SPP - Data Kelas')

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
</style>

<div class="container">
    <h2>Data Kelas</h2>
    <a href="{{ route('kelas.create') }}" class="btn-add">Tambah Data</a>

    <div class="filter-box">
        <form method="GET" class="filter-form"> 
        <div class="filter-group">
            <label>Kompetensi Keahlian :</label>
            <select name="kompetensi_keahlian" onchange="this.form.submit()">
                <option value="">Semua Kompetensi</option>
                @foreach(\App\Models\Kelas::select('kompetensi_keahlian')->distinct()->orderBy('kompetensi_keahlian','desc')->get() as $k)
                    <option value="{{ $k->kompetensi_keahlian }}" {{ request('kompetensi_keahlian') == $k->kompetensi_keahlian ? 'selected' : '' }}>
                        {{ $k->kompetensi_keahlian }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="search">Cari Kelas:</label>
            <input type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                placeholder="Ketik nama kelas..."
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
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Kompetensi Keahlian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelas as $index => $k)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $k->nama_kelas }}</td>
                <td>{{ $k->kompetensi_keahlian }}</td>
                <td>
                    <a href="{{ route('kelas.edit', $k->id) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('kelas.destroy', $k->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-hps" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data kelas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
