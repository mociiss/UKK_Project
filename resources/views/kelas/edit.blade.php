@extends('layouts.app')
@section('title', 'Aplikasi SPP - Edit Data Kelas')
@section('content')
<div class="section-container">
    <h2>Edit Data Kelas</h2>
    <form action="{{ route('kelas.update', $kelas->id ) }}" method="POST" class="create-form">
        @csrf
        @method('put')
        <div class="sec-body">
            <label for="">Nama Kelas</label>
            <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}" required>
        </div>
        <div class="sec-body">
            <label for="">Kompetensi Keahlian</label>
            <select name="kompetensi_keahlian" id="" required>
                <option value="{{ $kelas->kompetensi_keahlian }}">{{ $kelas->kompetensi_keahlian }}</option>
                <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                <option value="Teknik Elektronika Industri">Teknik Elektronika Industri</option>
                <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                <option value="Teknik Pendingin dan Tata Udara">Teknik Pendingin dan Tata Udara</option>
            </select>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('kelas.index') }}">Kembali</a>
        </div>
    </form>
</div>
@endsection