@extends('layouts.app')
@section('title', 'Aplikasi SPP - Edit Data Siswa')
@section('content')
<div class="section-container">
    <h2>Edit Data Siswa</h2>
    <form action="{{ route('siswa.update', $siswa->nisn) }}" method="POST" class="create-form">
        @csrf
        @method('put')
        <div class="sec-body">
            <label for="">NISN</label>
            <input type="number" name="nisn" value="{{ $siswa->nisn }}" required>
        </div>
        <div class="sec-body">
            <label for="">NIS</label>
            <input type="number" name="nis" value="{{ $siswa->nis }}" required>
        </div>
        <div class="sec-body">
            <label for="">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ $siswa->nama }}" required>
        </div>
        <div class="sec-body">
            <label for="">Kelas</label>
            <select name="kelas_id" id="">
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="sec-body">
            <label for="">Alamat</label>
            <input type="text" name="alamat" value="{{ $siswa->alamat }}" required>
        </div>
        <div class="sec-body">
            <label for="">Nomor Telepon</label>
            <input type="number" name="no_telp" value="{{ $siswa->no_telp }}" required>
        </div>
        <div class="sec-body">
            <label for="">Tahun Angkatan</label>
            <select name="spp_id" id="">
                @foreach($spp as $s)
                <option value="{{ $s->id }}" {{ $siswa->spp_id == $s->id ? 'selected' : '' }}>{{ $s->tahun }}</option>
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