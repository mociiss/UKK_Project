<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Petugas;


class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $petugas = Petugas::where('username', $request->username)->first();

        if ($petugas && Hash::check($request->password, $petugas->password)) {
            session([
                'id' => $petugas->id,
                'nama' => $petugas->nama_petugas,
                'level' => $petugas->level,
                'role' => $petugas->level == 'admin' ? 'admin' : 'petugas',
                'is_logged_in' => true
            ]);

            return redirect()->route('dashboard');
        }

        $siswa = Siswa::where('nis', $request->username)->orWhere('nisn', $request->username)->first();

        if ($siswa && Hash::check($request->password, $siswa->password)) {
            session([
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'role' => 'siswa',
                'is_logged_in' => true
            ]);

            return redirect()->route('siswadashboard');
        }
        return back()->with('error', 'Username/NISN atau Password salah!');
    }

    public function logout(){
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    public function showChangePassword()
    {
        return view('auth.ganti-password');
    }

    public function changePassword(Request $request)
    {
        
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $role = session('role');
        $updated = false;

        if (in_array($role, ['admin', 'petugas'])) {
            $user = Petugas::find(session('id'));
            if (!$user) {
                return back()->with('error', 'Data petugas tidak ditemukan.');
            }

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                $updated = true;
            } else {
                return back()->with('error', 'Password lama tidak cocok.');
            }
        }

        elseif ($role === 'siswa') {
            // Ambil siswa berdasarkan session NIS atau NISN
            $user = Siswa::where('nis', session('nis'))
                        ->orWhere('nisn', session('nis'))
                        ->first();

            if (!$user) {
                return back()->with('error', 'Data siswa tidak ditemukan.');
            }

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                $updated = true;
            } else {
                return back()->with('error', 'Password lama tidak cocok.');
            }
        }

        if ($updated) {
            session()->flush(); 
            return redirect()->route('login')->with('success', 'Password berhasil diganti. Silakan login ulang.');
        }

        return back()->with('error', 'Terjadi kesalahan, password tidak diperbarui.');
    }
}
