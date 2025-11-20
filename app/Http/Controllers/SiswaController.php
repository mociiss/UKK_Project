<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Spp;

class SiswaController extends Controller
{
    public function index(){
        $siswa = Siswa::all();
        return view('siswa.index', compact('siswa'));
    }

    public function create(){
        $siswa = Siswa::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $spp = Spp::orderBy('tahun')->get();
        return view('siswa.create', compact('siswa', 'kelas', 'spp'));
    }

    public function store(Request $request){
        $request->validate([
            'nisn' => 'required',
            'nis' => 'required',
            'nama' => 'required',
            'password' => 'required|confirmed',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'required|string',
            'no_telp' => 'required',
            'spp_id' => 'required|exists:spp,id'
        ]);

        Siswa::create([
        'nisn' => $request->nisn,
        'nis' => $request->nis,
        'nama' => $request->nama,
        'password' => Hash::make($request->password),
        'kelas_id' => $request->kelas_id,
        'alamat' => $request->alamat,
        'no_telp' => $request->no_telp,
        'spp_id' => $request->spp_id,
    ]);

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    public function edit($nisn){
        $siswa = Siswa::findOrFail($nisn);
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $spp = Spp::orderBy('tahun')->get();
        return view('siswa.edit', compact('siswa', 'kelas', 'spp'));
    }

    public function update(Request $request, $nisn){
        $siswa = Siswa::findOrFail($nisn);

        $request->validate([
            'nisn' => 'required',
            'nis' => 'required',
            'nama' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'required|string',
            'no_telp' => 'required',
            'spp_id' => 'required|exists:spp,id'
        ]);

        $siswa->update([
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'spp_id' => $request->spp_id
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data berhasil diperbaharui.');
    }

    public function destroy($nisn){
        $siswa = Siswa::findOrFail($nisn);

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data berhasil dihapus.');
    }
}
