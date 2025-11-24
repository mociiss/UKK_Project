<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Pembayaran, Petugas, Siswa, Kelas, Spp};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;

class PembayaranController extends Controller
{
    use CausesActivity;
    
    public function logActivity()
    {
        $logs = Activity::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.log', compact('logs'));
    }

    public function index(Request $request){
        $role = session('role');
        $kelas = Kelas::all();

        if ($role === 'siswa') {
            $nisn = session('nis');
            $siswa = Siswa::with(['kelas', 'spp'])->where('nisn', $nisn)->get();
            $pembayaran = Pembayaran::where('nisn', $nisn)->get();
        } else {
            $siswaQuery = Siswa::with(['kelas', 'spp', 'pembayaran']);
            if ($request->kelas) {
                $siswaQuery->where('kelas_id', $request->kelas);
            }
            if ($request->tahun) {
                $siswaQuery->whereHas('spp', fn($q) => $q->where('tahun', $request->tahun));
            }
            if ($request->search) {
                $siswaQuery->where(function($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%');
                });
            }

            $siswa = $siswaQuery->get();
            $pembayaran = Pembayaran::whereIn('nisn', $siswa->pluck('nisn'))->get();
        }

        return view('pembayaran.index', compact('siswa', 'kelas', 'pembayaran'));
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
        $bulanIni = (int) date('n');
        $tahun = $bulanIni >= 7 ? date('Y') : date('Y', strtotime('-1 year'));
        if(!$petugasId) return back()->with('error', 'Petugas belum login.');
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
        $siswa = Siswa::with('spp')->where('nisn', $nisn)->firstOrFail();
        $bulanSekarang = (int) date('n');
        $tahunAjaran = $bulanSekarang >= 7 ? date('Y') : date('Y', strtotime('-1 year'));

        $pembayaran = Pembayaran::where('nisn', $nisn)->get();

        $namaBulan = ["", "Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
        $urutanBulan = [7,8,9,10,11,12,1,2,3,4,5,6];

        $status = [];
        foreach ($urutanBulan as $b) {
            $tahunPembayaran = $b >= 7 ? $tahunAjaran : $tahunAjaran + 1;
            $sudahBayar = $pembayaran
                ->where('bulan_dibayar', $b)
                ->where('tahun_dibayar', $tahunPembayaran)
                ->isNotEmpty();

            $status[] = [
                'bulan' => $b,
                'nama' => $namaBulan[$b],
                'sudah' => $sudahBayar,
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

        $bulan = ["", "Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni"];

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
        ))->setPaper([0,0,300,700], 'portrait');

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
