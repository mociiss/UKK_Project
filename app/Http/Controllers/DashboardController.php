<?php

namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, Petugas, Pembayaran};
use Carbon\Carbon;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }

    public function siswa()
    {
        $nisn = session('nis');
        $siswa = Siswa::with(['kelas','spp'])->where('nisn', $nisn)->firstOrFail();

        $bulan = [1=>'Jul','Agu','Sep','Okt','Nov','Des','Jan','Feb','Mar','Apr','Mei','Jun'];
        $pembayaran = Pembayaran::where('nisn', $nisn)->pluck('bulan_dibayar')->toArray();

        $dataStatus = [];
        foreach(range(1,12) as $i){
            $dataStatus[] = in_array($i, $pembayaran) ? 1 : 0;
        }

        $sudahBayar = count($pembayaran);
        $tunggakan = max(0, (12 - $sudahBayar) * ($siswa->spp->nominal ?? 0));

        $periode = Carbon::now()->month >= 7
            ? Carbon::now()->year . '/' . (Carbon::now()->year + 1)
            : (Carbon::now()->year - 1) . '/' . Carbon::now()->year;

            $labels = array_values($bulan);
        return view('siswaDashboard', compact(
            'siswa', 'periode', 'sudahBayar', 'tunggakan', 'bulan', 'dataStatus', 'labels'
        ));
    }

    public function admin()
    {
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalPetugas = Petugas::count();
        $totalPembayaran = Pembayaran::sum('jumlah_bayar');

        $bulan = [1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $pembayaranTerbaru = Pembayaran::with('siswa.kelas')
            ->latest()
            ->take(5)
            ->get();

        $labels = array_values($bulan);
        $totals = [];
        foreach(range(1,12) as $b){
            $totals[] = Pembayaran::whereMonth('tgl_bayar', $b)->sum('jumlah_bayar');
        }

        return view('dashboard.admin', compact(
            'totalSiswa', 'totalKelas', 'totalPetugas', 'totalPembayaran',
            'pembayaranTerbaru', 'labels', 'totals', 'bulan'
        ));
    }

}
