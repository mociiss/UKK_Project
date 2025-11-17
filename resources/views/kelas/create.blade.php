@extends('layout.app')
@section('title', 'Aplikasi SPP - Tambah Data Kelas')
@section('content')
<style>

</style>
<div class="section-container">
    <h2>Tambah Data Kelas</h2>
    <form action="{{ route('kelas.route') }}" class="create-form">
        @csrf
        
    </form>
</div>