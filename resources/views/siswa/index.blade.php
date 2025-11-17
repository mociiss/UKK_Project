@extends('layouts.app')
@section('title', 'Aplikasi SPP - Data Siswa')
@section('content')
<head>
    <style>

    </style>
</head>
    <div class="container">
        <h2>Data Siswa</h2>
        <a href="{{ route('siswa.store') }}">Tambah Data</a>

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
                    <td>
                        <a href="{{ route('siswa.edit', $s->id) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('siswa.destroy'), $s->id }}" method="POST" style="display: inline;">
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