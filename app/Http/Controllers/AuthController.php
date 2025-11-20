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
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $petugas = Petugas::where('username', $request->username)->first();
        if($petugas && Hash::check($request->password, $petugas->password)){
            session([
                'id' => $petugas->id,
                'nama' => $petugas->nama_petugas,
                'level' => $petugas->level,
                'role' => $petugas->level = 'admin' ? 'admin' : 'petugas',
                'is_logged_in' => true
            ]); 
            return redirect()->route('dashboard');
        }else{
            return back()->with('error', 'Username atau Password salah!');
        }

        $siswa = Siswa::where('nis', $request->username)->first();

        if($siswa && Hash::check($request->password, $siswa->password)){
            session([
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'role' => 'siswa',
                'is_logged_in' => true
            ]);
            return redirect()->route('siswadashboard');
        }
        return back()->with('error', 'Username/NIS atau Password salah!');
    }

    public function logout(){
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

}
