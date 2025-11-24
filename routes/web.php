<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Http\Controllers\ActivityLogController;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/ganti-password', [UserController::class, 'gantiPassword'])->name('ganti.password');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/ganti-password', [AuthController::class, 'showChangePassword'])
    ->middleware('checkRole:admin,petugas,siswa')
    ->name('ganti.password');

Route::post('/ganti-password', [AuthController::class, 'changePassword'])
    ->middleware('checkRole:admin,petugas,siswa')
    ->name('ganti.password.post');

Route::resource('pembayaran', PembayaranController::class);
Route::get('/pembayaran/cetak/{nisn}', [PembayaranController::class, 'cetakDetail'])->name('pembayaran.cetak');

    

Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])
    ->middleware('checkRole:siswa')
    ->name('siswadashboard');
Route::middleware('checkRole:petugas,admin')->get('/dashboard', function() {
    return view('dashboard', [
        'totalSiswa' => 120,
        'totalKelas' => 12,
        'totalPetugas' => 5,
        'totalPembayaran' => 25000000,
        'pembayaranTerbaru' => collect(),
        'labels' => [],
        'totals' => [],
        'bulan' => []
    ]);
})->name('dashboard');

Route::middleware('checkRole:admin')->group(function(){
    Route::resource('kelas', KelasController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('spp', SppController::class);
    Route::resource('petugas', PetugasController::class);
    
    Route::get('/pembayaran/struk/{nisn}/{tahun}', [PembayaranController::class, 'cetakStruk'])->name('pembayaran.struk');
    Route::get('/pembayaran/preview/{nisn}/{tahun}', [PembayaranController::class, 'previewStruk'])->name('pembayaran.preview');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/get-siswa/{nisn}', [PembayaranController::class, 'getSiswa']);

    Route::get('/get-siswa-by-kelas/{id}', function ($id) {
        return Siswa::where('kelas_id', $id)->select('nisn','nama')->get();
    });
    Route::get('/get-status-bulan/{nisn}', function ($nisn) {
        $tahun = date('Y');
        $result = [];

        for ($i = 1; $i <= 12; $i++) {
            $paid = Pembayaran::where('nisn', $nisn)->where('bulan_dibayar', $i)
                ->where('tahun_dibayar', $tahun)
                ->exists();

            $result[] = [
                'bulan' => $i,
                'nama' => \DateTime::createFromFormat('!m', $i)->format('F'),   // 🔁 tambahkan prefix \
                'sudah' => $paid
            ];
        }

        return response()->json($result);
    });
    Route::get('/activity-log', [ActivityLogController::class, 'index'])
    ->name('activity.log');

});
