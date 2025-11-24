@extends('layouts.app')
@section('title', 'Aplikasi SPP - Tambah Data Siswa')
@section('content')
<div class="section-container">
    <h2>Tambah Data Siswa</h2>
    <form action="{{ route('siswa.store') }}" method="POST" class="create-form">
        @csrf
        <div class="sec-body">
            <label for="">NISN</label>
            <input type="number" name="nisn" required>
        </div>
        <div class="sec-body">
            <label for="">NIS</label>
            <input type="number" name="nis" required>
        </div>
        <div class="sec-body">
            <label for="">Nama</label>
            <input type="text" name="nama" autocomplete="off" required>
        </div>
        <div class="sec-body">
            <label for="">Kata Sandi</label>
            <input type="password" name="password" required>
        </div>
        <!-- <div class="sec-body">
            <label for="">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required>
        </div> -->
        <div class="sec-body">
            <label for="">Kelas</label>
            <select name="kelas_id" id="" required>
                <option value="" disabled selected>-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="sec-body">
            <label for="">Alamat</label>
            <input type="text" name="alamat" id="" required>
        </div>
        <div class="sec-body">
            <label for="">Nomor Telepon</label>
            <input type="text" name="no_telp" id="" required>
        </div>
        <div class="sec-body">
            <label for="">Angkatan</label>
            <select name="spp_id" id="" required>
                <option value="" disabled selected>-- Cari Tahun Angkatan --</option>
                @foreach($spp as $s)
                <option value="{{ $s->id }}">{{ $s->tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('siswa.index') }}">Kembali</a>
        </div>
    </form>
</div>
@endsection