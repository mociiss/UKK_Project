<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pembayaran extends Model
{
    use LogsActivity;
    protected $table = 'pembayaran';

    protected $fillable = [
        'petugas_id',
        'nisn',
        'tgl_bayar',
        'bulan_dibayar',
        'tahun_dibayar',
        'spp_id',
        'jumlah_bayar',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }

    public function spp()
    {
        return $this->belongsTo(Spp::class, 'spp_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('pembayaran') 
            ->logOnly([
                'petugas_id',
                'nisn',
                'tgl_bayar',
                'bulan_dibayar',
                'tahun_dibayar',
                'spp_id',
                'jumlah_bayar',
            ])
            ->logOnlyDirty()          
            ->dontSubmitEmptyLogs(); 
    }
}
