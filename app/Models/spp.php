<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class spp extends Model
{
    protected $table = 'spp';

    protected $fillable = [
        'tahun',
        'nominal'
    ];

    public function Siswa(){
        return $this->hasMany(Siswa::class, 'spp_id'); 
    }
}
