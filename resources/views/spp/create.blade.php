@extends('layouts.app')
@section('title', 'Aplikasi SPP - Tambah Data SPP')
@section('content')
<div class="section-container">
    <h2>Tambah Data SPP</h2>
    @error('tahun')
    <small style="color: #b30000;
    background: #fddcdc;
    display: block;
    width: 100%;
    padding: 8px 12px;
    border-radius: 6px;
    margin-top: 6px;">{{ $message }}</small>
    @enderror

    <form action="{{ route('spp.store') }}" method="POST" class="create-form">
        @csrf
        <div class="sec-body">
            <label for="">Tahun Angkatan</label>
            <input type="number" min="2000" max="2100" name="tahun" required>
        </div>
        <div class="sec-body">
            <label for="">Nominal SPP/bulan</label>
            <input type="number" name="nominal" id="" required>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('spp.index') }}">Kembali</a>
        </div>
    </form>
</div>
@endsection