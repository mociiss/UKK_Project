@extends('layouts.app')
@section('title', 'Tambah Pembayaran SPP')

@section('content')
<style>
    body {
        background: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h2 { 
        color: #2c3e50; 
        margin-bottom: 20px; 
        font-weight: 600; 
        border-bottom: 3px solid #3498db; 
        display: inline-block; 
        padding-bottom: 6px; 
    }
    form { 
        background: white; 
        border-radius: 12px; 
        padding: 25px; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
        margin-top: 10px; 
    }
    .container-form { 
        display: flex; 
        gap: 20px; 
        margin-top: 10px; 
        flex-wrap: wrap; 
    }
    .card { 
        flex: 1; 
        background: #fff; 
        border-radius: 14px; 
        box-shadow: 0 3px 8px rgba(0,0,0,0.07); 
        padding: 25px; 
        transition: all 0.2s ease-in-out; 
    }
    .card:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 5px 12px rgba(0,0,0,0.1); 
    }
    .card h4 { 
        margin-bottom: 15px; 
        font-weight: 600; 
        color: #34495e; 
        border-left: 4px solid #3498db; 
        padding-left: 8px; 
    }
    label { 
        font-weight: 500; 
        color: #2c3e50; 
        margin-top: 10px; 
        display: block; 
    }
    .form-control, select, input[type="number"], input[type="text"] {
        width: 100%; 
        padding: 10px; 
        border-radius: 8px; 
        border: 1px solid #ccc; 
        margin-top: 5px; 
        transition: border 0.3s;
    }
    .form-control:focus, select:focus { 
        border-color: #3498db; 
        outline: none; 
    }
    .bulan-box, .checkbox-bulan { 
        display: flex; 
        flex-wrap: wrap; 
        gap: 8px; 
        margin-top: 10px; 
    }
    .bulan { 
        padding: 8px 14px; 
        border-radius: 20px; 
        font-size: 14px; 
        font-weight: 500; 
        transition: 0.2s; 
    }
    .sudah { 
        background: #d1f7d1; 
        color: #2ecc71; 
        border: 1px solid #b3e6b3; 
    }
    .belum { 
        background: #fde0e0; 
        color: #e74c3c; 
        border: 1px solid #f5b7b1; 
    }
    .checkbox-bulan label {
        background: #f7f7f7; 
        border: 1px solid #ddd; 
        border-radius: 12px; 
        padding: 8px 14px;
        cursor: pointer; 
        transition: all 0.2s;
    }
    .checkbox-bulan input[type="checkbox"] { 
        margin-right: 5px; 
    }
    .checkbox-bulan label:hover { 
        background: #ecf6ff; 
        border-color: #3498db; 
        color: #3498db; 
    }
    .btn { 
        display: inline-block; 
        padding: 10px 18px; 
        border-radius: 8px; 
        font-weight: 600; 
        text-decoration: none;
        cursor: pointer; 
        transition: background 0.2s, transform 0.1s; 
        border: none; 
    }
    .btn-primary { 
        background: #3498db; 
        color: white; 
    }
    .btn-primary:hover { 
        background: #2980b9; 
    }
    .btn-secondary { 
        background: #bdc3c7; 
        color: white; 
    }
    .btn-secondary:hover { 
        background: #95a5a6; 
    }
    .total-section { 
        margin-top: 10px; 
        padding-top: 10px; 
        border-top: 1px solid #eee; 
    }
</style>

<h2>Tambah Pembayaran</h2>

<form action="{{ route('pembayaran.store') }}" method="POST">
    @csrf
    <input type="hidden" name="tgl_bayar" value="{{ date('Y-m-d') }}">

    <div class="container-form">
        <div class="card">
            <h4>Data Pembayaran</h4>

            <label>Kelas</label>
            <select id="kelas" class="form-control">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <label>Nama Siswa</label>
            <select id="siswa" class="form-control" disabled>
                <option value="">-- Pilih Siswa --</option>
            </select>

            <label>NISN</label>
            <input type="text" id="nisn_view" class="form-control" readonly>
            <input type="hidden" name="nisn" id="nisn">

            <label>SPP / Bulan</label>
            <input type="text" id="spp_view" class="form-control" readonly>
            <input type="hidden" name="spp_id" id="spp_id">

            <label>Tahun Dibayar</label>
            <input type="number" name="tahun_dibayar" id="tahun" class="form-control" value="{{ date('Y') }}" readonly>
        </div>

        <div class="card">
            <h4>Status Pembayaran Tahun Ini</h4>
            <div id="status_bulan" class="bulan-box"></div>

            <hr>
            <h4>Pilih Bulan yang Dibayar</h4>
            <div id="checkbox_bulan" class="checkbox-bulan"></div>

            <div class="total-section">
                <label>Total Bayar</label>
                <input type="text" id="total_bayar" class="form-control" readonly value="Rp 0">
                <input type="hidden" name="jumlah_bayar" id="jumlah_bayar">
            </div>

            <br>
            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan & Cetak Struk</button>
            <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</form>

<script>
let nominal = 0;
const kelas = document.getElementById('kelas');
const siswa = document.getElementById('siswa');

kelas.onchange = () => {
    if (!kelas.value) return;
    fetch(`/get-siswa-by-kelas/${kelas.value}`)
        .then(r => r.json())
        .then(data => {
            siswa.innerHTML = '<option value="">-- Pilih Siswa --</option>' +
                data.map(s => `<option value="${s.nisn}">${s.nama}</option>`).join('');
            siswa.disabled = false;
        })
        .catch(err => console.error('Gagal ambil siswa:', err));
};

siswa.onchange = () => {
    if (!siswa.value) return;
    fetch(`/get-siswa/${siswa.value}`)
        .then(r => r.json())
        .then(d => {
            document.getElementById('nisn').value = d.nisn;
            document.getElementById('nisn_view').value = d.nisn;
            document.getElementById('spp_view').value = "Rp " + d.spp.nominal.toLocaleString();
            document.getElementById('spp_id').value = d.spp.id;
            document.getElementById('tahun').value = d.tahun;
            nominal = d.spp.nominal;
            loadStatus(d.nisn);
        })
        .catch(err => console.error('Gagal ambil data siswa:', err));
};

function loadStatus(nisn) {
    fetch(`/get-status-bulan/${nisn}`)
        .then(r => r.json())
        .then(data => {
            const sortedData = data.sort((a, b) => {
                const order = [7,8,9,10,11,12,1,2,3,4,5,6];
                return order.indexOf(a.bulan) - order.indexOf(b.bulan);
            });

            const statusBox = document.getElementById('status_bulan');
            const checkBox = document.getElementById('checkbox_bulan');
            statusBox.innerHTML = '';
            checkBox.innerHTML = '';

            sortedData.forEach(i => {
                statusBox.innerHTML += `<div class="bulan ${i.sudah ? 'sudah' : 'belum'}">${i.nama}</div>`;
                if (!i.sudah) {
                    checkBox.innerHTML += `
                        <label>
                            <input type="checkbox" name="bulan_dibayar[]" value="${i.bulan}" onchange="calc()">
                            ${i.nama}
                        </label>`;
                }
            });
        })
        .catch(err => console.error('Gagal ambil status bulan:', err));
}

function calc() {
    const total = nominal * document.querySelectorAll('input[name="bulan_dibayar[]"]:checked').length;
    document.getElementById('total_bayar').value = "Rp " + total.toLocaleString();
    document.getElementById('jumlah_bayar').value = total;
}
</script>
@endsection
