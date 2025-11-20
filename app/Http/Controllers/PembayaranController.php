<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Pembayaran, Petugas, Siswa, Kelas, Spp};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function index(Request $request){
        $kelas = Kelas::all();
        $siswa = $request->kelas 
            ? Siswa::where('kelas_id', $request->kelas)->with('kelas')->get()
            : Siswa::with('kelas')->get();

        $siswaQuery = Siswa::with('kelas');

        if ($request->kelas) {
            $siswaQuery->where('kelas_id', $request->kelas);
        }

        if ($request->search) {
            $siswaQuery->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $siswas = $siswaQuery->get();
        $pembayaran = Pembayaran::with('siswa', 'spp')->get();
        return view('pembayaran.index', compact('pembayaran', 'siswa', 'kelas', 'siswas'));
    }

    public function create(){
        $kelas = Kelas::all();
        $siswa = Siswa::with('kelas')->get();
        return view('pembayaran.create', compact('siswa', 'kelas'));
    }

    public function store(Request $r){
        $r->validate([
            'nisn' => 'required|exists:siswa,nisn',
            'tgl_bayar' => 'required|date',
            'bulan_dibayar' => 'required|array',
            'spp_id' => 'required|exists:spp,id',
        ]);

        $siswa = Siswa::with('spp')->where('nisn', $r->nisn)->firstOrFail();
        $petugasId = session('id') ?? null;
        if(!$petugasId) return back()->with('error', 'Petugas belum login.');
        $tahun = date('Y');
        foreach ($r->bulan_dibayar as $bulan) {
            Pembayaran::firstOrCreate([
                'nisn' => $siswa->nisn,
                'bulan_dibayar' => $bulan,
                'tahun_dibayar' => $tahun,
            ], [
                'petugas_id' => $petugasId,
                'tgl_bayar' => $r->tgl_bayar,
                'spp_id' => $siswa->spp->id,
                'jumlah_bayar' => $siswa->spp->nominal,
            ]);
        }

        return redirect()->route('pembayaran.preview', ['nisn' => $siswa->nisn, 'tahun' => $tahun]);
    }

    public function getSiswa($nisn){
        $siswa = Siswa::with(['kelas','spp'])->where('nisn', $nisn)->first();
        return $siswa
            ? response()->json([
                'nisn'=>$siswa->nisn,
                'nama'=>$siswa->nama,
                'kelas'=>$siswa->kelas,
                'spp'=>$siswa->spp,
                'spp_id'=>$siswa->spp->id,
                'tahun'=>$siswa->spp->tahun,
                'tgl_bayar'=>now()->format('Y-m-d')
                ])
            : response()->json(['error'=>'Data tidak ditemukan'],404);
    }

    public function getStatusBulan($nisn) {
        $yearNow = date('Y');
        $siswa = Siswa::with('spp')->where('nisn', $nisn)->firstOrFail();

        $bulanSudahBayar = Pembayaran::where('nisn', $nisn)
                            ->where('tahun_dibayar', $yearNow)
                            ->pluck('bulan_dibayar')->toArray();

        $namaBulan = ["","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];

        $status = [];
        for ($i=1;$i<=12;$i++) {
            $status[] = [
                'bulan' => $i,
                'nama' => $namaBulan[$i],
                'sudah' => in_array($i,$bulanSudahBayar)
            ];
        }

        return response()->json($status);
    }

    public function cetakDetail($nisn){
        $siswa = Siswa::with(['kelas', 'spp'])->where('nisn', $nisn)->firstOrFail();
        $pembayaran = Pembayaran::with('petugas')
                        ->where('nisn', $nisn)
                        ->orderBy('tahun_dibayar')
                        ->orderBy('bulan_dibayar')
                        ->get();

        $bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $pdf = PDF::loadView('pembayaran.cetak', compact('siswa', 'pembayaran', 'bulan')) ->setPaper('a4', 'portrait');

        return $pdf->stream("Detail_Pembayaran_{$siswa->nama}.pdf");
    }

    public function cetakStruk($nisn, $tahun)
    {
        $siswa = Siswa::with(['kelas', 'spp'])->where('nisn', $nisn)->firstOrFail();
        $tanggalHariIni = Carbon::now()->format('Y-m-d');
        $pembayaran = Pembayaran::with('petugas')
            ->where('nisn', $nisn)
            ->where('tahun_dibayar', $tahun)
            ->whereDate('tgl_bayar', $tanggalHariIni)
            ->orderBy('bulan_dibayar')
            ->get();

        if ($pembayaran->isEmpty()) {
            return back()->with('error', 'Tidak ada pembayaran pada hari ini.');
        }

        $bulanAll = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $totalHariIni = $pembayaran->sum('jumlah_bayar');
        $petugas = $pembayaran->first()->petugas->nama_petugas ?? '-';
        $bulanDibayarHariIni = $pembayaran->pluck('bulan_dibayar')->toArray();

        $pdf = Pdf::loadView('pembayaran.struk', compact(
            'siswa', 'pembayaran', 'bulanAll', 'totalHariIni', 'petugas', 'tahun', 'tanggalHariIni'
        ))->setPaper('A5', 'portrait');

        return $pdf->stream('Struk_Pembayaran_'.$siswa->nama.'.pdf');
    }


    public function getSiswaByKelas($kelasId)
    {
        $siswas = Siswa::where('kelas_id', $kelasId)->select('nisn', 'nama')->get();
        return response()->json($siswas);
    }

    public function previewStruk($nisn, $tahun)
    {
        $tanggalHariIni = Carbon::now()->format('Y-m-d');
        $siswa = Siswa::with(['kelas', 'spp'])->where('nisn', $nisn)->firstOrFail();

        $pembayaran = Pembayaran::with('petugas')
            ->where('nisn', $nisn)
            ->where('tahun_dibayar', $tahun)
            ->whereDate('tgl_bayar', $tanggalHariIni)
            ->orderBy('bulan_dibayar')
            ->get();

        if ($pembayaran->isEmpty()) {
            return redirect()->route('pembayaran.index')->with('error', 'Tidak ada pembayaran hari ini.');
        }

        $bulanAll = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei',
            6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober',
            11 => 'November', 12 => 'Desember'
        ];

        $totalHariIni = $pembayaran->sum('jumlah_bayar');
        $bulanDibayarHariIni = $pembayaran->pluck('bulan_dibayar')->toArray();
        $petugas = $pembayaran->first()->petugas->nama_petugas ?? '-';

        return view('pembayaran.preview-struk', compact(
            'siswa', 'pembayaran', 'bulanAll', 'bulanDibayarHariIni',
            'totalHariIni', 'petugas', 'tahun', 'tanggalHariIni'
        ));
    }


}
