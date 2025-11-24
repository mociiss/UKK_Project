<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\CausesActivity;

class Petugas extends Authenticatable
{
    use CausesActivity;
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
