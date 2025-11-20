@extends('layouts.app')
@section('title', 'Aplikasi SPP - Edit Data Petugas')
@section('content')
<div class="section-container">
    <h2>Edit Data Petugas</h2>
    <form action="{{ route('petugas.update', $petugas->id ) }}" method="POST" class="create-form">
        @csrf
        @method('put')
        <div class="sec-body">
            <label for="">Username</label>
            <input type="text" name="username" value="{{ $petugas->username }}" required>
        </div>
        <div class="sec-body">
            <label for="">Nama Petugas</label>
            <input type="text" name="nama_petugas" value="{{ $petugas->nama_petugas }}" required>
        </div>
        <div class="sec-body">
            <label for="">Level/Role</label>
            <select name="level" required>
                <option value="petugas" {{ $petugas->level == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="admin" {{ $petugas->level == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('petugas.index') }}">Kembali</a>
        </div>
    </form>
</div>
@endsection