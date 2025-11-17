<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    protected $table = 'petugas';

    protected $fillable = [
        'username',
        'password',
        'nama_petugas',
        'level'
    ];

    public function pembayaran(){
        return $this->hasMany(Pembayaran::class, 'petugas_id');
    }
}
