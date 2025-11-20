    @extends('layouts.app')
    @section('title', 'Aplikasi SPP - Tambah Data Petugas')
    @section('content')
    <div class="section-container">
        <h2>Tambah Data Petugas</h2>
        <form action="{{ route('petugas.store') }}" method="POST" class="create-form">
            @csrf
            <div class="sec-body">
                <label for="">Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="sec-body">
                <label for="">Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="sec-body">
                <label for="">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <div class="sec-body">
                <label for="">Nama Petugas</label>
                <input type="text" name="nama_petugas" required>
            </div>
            <div class="sec-body">
                <label for="">Level/Role</label>
                <select name="level" id="" required>
                    <option value="">-- Pilih Level/Role --</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="{{ route('petugas.index') }}">Kembali</a>
            </div>
        </form>
    </div>
    @endsection