<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;

class pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'petugas_id',
        'nisn',
        'tgl_bayar',
        'bulan_dibayar',
        'tahun_dibayar',
        'spp_id',
        'jumlah_bayar'
    ];

    public function petugas(){
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'nisn');
    }

    // public function spp(){
    //     return $this->belongsTo(Spp::class, 'spp_id');
    // }

    public function siswaspp(){
        return $this->belongsTo(Siswa::class, 'spp_id');
    }
}

