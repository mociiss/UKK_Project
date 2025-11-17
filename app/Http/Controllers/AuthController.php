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
        $siswa = Siswa::where('nis', $request->username)->first();

        if($siswa && Hash::check($request->password, $siswa->password)){
            Auth::login($siswa);
            return redirect('dashboard');
        }

        $petugas = Petugas::where('username', $request->username)->first();

        if($petugas && Hash::check($request->password, $petugas->password)){
            Auth::login($petugas);
            return redirect('dashboard');
        }

        return back()->with('error', 'Username/NIS atau Password salah!');
    }

}
