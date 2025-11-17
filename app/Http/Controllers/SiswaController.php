<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index(){
        $siswa = Siswa::all();
        return view('siswa.index', compact('siswa'));
    }

    public function store(Request $request){
        $request->validate([
            'nisn' => 'required',
            'nis' => 'required',
            'nama' => 'required',
            'password' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'required|string',
            'no_telp' => 'required'
        ]);

        Siswa::create($request);

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    public function edit($id){
        $siswa = Siswa::findOrFail($id);
        return redirect()->route('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id){
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nisn' => 'required',
            'nis' => 'required',
            'nama' => 'required',
            'password' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'required|string',
            'no_telp' => 'required'
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data berhasil diperbaharui.');
    }

    public function destroy($id){
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data berhasil dihapus.');
    }
}
