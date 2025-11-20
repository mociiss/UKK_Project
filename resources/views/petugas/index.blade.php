@extends('layouts.app')

@section('title', 'Aplikasi SPP - Data Petugas')

@section('content')
<style>
    
</style>

<div class="container">
    <h2>Data Petugas</h2>
    <a href="{{ route('petugas.create') }}" class="btn-add">Tambah Data</a>

    @if(session('success'))
    <div class="success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Petugas</th>
                <th>Username</th>
                <th>Level/Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama_petugas }}</td>
                <td>{{ $p->username }}</td>
                <td>{{ $p->level }}</td>
                <td>
                    <a href="{{ route('petugas.edit', $p->id) }}" class="btn-edit">Edit</a>
                    @if(session('id') == $p->id)
                        <span style="color: #888; font-style: italic;">Tidak dapat menghapus akun Anda sendiri</span>
                    @else
                        <form action="{{ route('petugas.destroy', $p->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hps" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data petugas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
