@extends('layouts.app')

@section('title', 'Aplikasi SPP - Data SPP')

@section('content')
<style>
    
</style>

<div class="container">
    <h2>Data SPP</h2>
    <a href="{{ route('spp.create') }}" class="btn-add">Tambah Data</a>

    @if(session('success'))
    <div class="success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Angkatan</th>
                <th>Nominal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($spp as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->tahun }}</td>
                <td>Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('spp.edit', $s->id) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('spp.destroy', $s->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-hps" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data SPP.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
