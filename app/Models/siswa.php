<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Kelas;
use App\Models\Spp;

class Siswa extends Authenticatable
{
    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nis',
        'nama',
        'id_kelas',
        'alamat',
        'no_telp',
        'id_spp'
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function spp(){
        return $this->belongsTo(Spp::class, 'spp_id');
    }

    public function pembayaran(){
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }
}
