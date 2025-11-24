@extends('layouts.app')
@section('title', 'Ganti Password')

@section('content')
<style>
    .form-container {
        max-width: 400px;
        margin: 40px auto;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        font-family: "Poppins", sans-serif;
    }
    h2 {
        text-align: center;
        color: #4a56a3;
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }
    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }
    button {
        width: 100%;
        background: #4a56a3;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }
    button:hover {
        background: #3a4690;
    }
    .alert {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
    }
    .alert-success {
        background: #d4f8d4;
        color: #2ecc71;
    }
    .alert-error {
        background: #fde4e4;
        color: #e74c3c;
    }
</style>

<div class="form-container">
    <h2>Ganti Password</h2>

    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('ganti.password.post') }}">
        @csrf
        <label>Password Lama</label>
        <input type="password" name="old_password" required>

        <label>Password Baru</label>
        <input type="password" name="new_password" required>

        <label>Konfirmasi Password Baru</label>
        <input type="password" name="new_password_confirmation" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
@endsection
