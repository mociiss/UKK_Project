@extends('layout.app')

@section('title', 'Aplikasi SPP - Data Kelas')

@section('content')
<style>
    
</style>

<div class="container">
    <h2>Data Kelas</h2>
    <a href="{{ route('kelas.route') }}" class="btn-add">Tambah Data</a>

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
