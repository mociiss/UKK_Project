<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\{Kelas, Pembayaran, Siswa};

class LaporanController extends Controller
{
    public function index(Request $req)
    {
        $kelas = Kelas::all();
        $query = Siswa::with(['kelas', 'spp', 'pembayaran']);
        if ($req->kelas) $query->where('kelas_id', $req->kelas);
        if ($req->tahun) $query->whereHas('spp', fn($q) => $q->where('tahun', $req->tahun));
        $siswa = $query->get();
        $nisns = $siswa->pluck('nisn');
        $pembayaran = Pembayaran::whereIn('nisn', $nisns)->get();

        if ($req->filter == 'belum') {
            $siswa = $siswa->filter(function ($s) use ($pembayaran) {
                $bayarBulan = $pembayaran
                    ->where('nisn', $s->nisn)
                    ->where('spp_id', $s->spp->id)
                    ->pluck('bulan_dibayar')
                    ->toArray();
                return count(array_diff(range(1, 12), $bayarBulan)) > 0;
            });
        }

        return view('laporan.index', compact('kelas', 'siswa', 'pembayaran'));
    }

    public function cetak(Request $r)
    {
        $query = Siswa::with(['kelas', 'spp']);

        if ($r->kelas) {
            $query->where('kelas_id', $r->kelas);
        }

        if ($r->tahun) {
            $query->whereHas('spp', function($q) use ($r) {
                $q->where('tahun', $r->tahun);
            });
        }

        $siswa = $query->get();
        $tahun = $r->tahun ?? date('Y');
        $pembayaran = Pembayaran::whereHas('siswa.spp', function($q) use ($r) {
            if ($r->tahun) {
                $q->where('tahun', $r->tahun);
            }
        })->get();

        if ($r->filter === 'belum') {
            $siswa = $siswa->filter(function($s) use ($pembayaran, $tahun) {
                $bulanSudahBayar = $pembayaran->where('nisn', $s->nisn)->pluck('bulan_dibayar')->toArray();
                return count($bulanSudahBayar) < 12;
            });
        }

        $pdf = PDF::loadView('laporan.cetak', compact('siswa', 'pembayaran', 'tahun'))->setPaper('a4', 'landscape');

        return $pdf->stream("laporan_spp_{$tahun}.pdf");
    }
}