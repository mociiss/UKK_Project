@extends('layouts.app')
@section('title', 'Aplikasi SPP - Edit Data SPP')
@section('content')
<div class="section-container">
    <h2>Edit Data SPP</h2>
    <form action="{{ route('spp.update', $spp->id) }}" method="POST" class="create-form">
        @csrf
        @method('put')
        <div class="sec-body">
            <label for="">Tahun Angkatan</label>
            <input type="number" name="tahun" min="2000" max="2100" value="{{ $spp->tahun }}" required>
        </div>
        <div class="sec-body">
            <label for="">Nominal</label>
            <input type="text" name="nominal" value="{{ $spp->nominal }}" id="">
        </div>
        <div class="btn-container">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('kelas.index') }}">Kembali</a>
        </div>
    </form>
</div>
@endsection