<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Kelas;
use App\Models\Spp;

class Siswa extends Authenticatable
{
    protected $table = 'siswa';
    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nisn',
        'nis',
        'nama',
        'password',
        'kelas_id',
        'alamat',
        'no_telp',
        'spp_id'
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function spp(){
        return $this->belongsTo(Spp::class, 'spp_id');
    }

    public function pembayaran(){
        return $this->hasMany(Pembayaran::class, 'nisn', 'nisn');
    }
}
