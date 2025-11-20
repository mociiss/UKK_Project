<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;

class PetugasController extends Controller
{
    public function index(){
        $petugas = Petugas::all();
        return view('petugas.index', compact('petugas'));
    }

    public function create(){
        $petugas = Petugas::orderBy('nama_petugas')->get();
        return view('petugas.create', compact('petugas'));
    }

    public function store(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required|confirmed',
            'nama_petugas' => 'required',
            'level' => 'required|in:petugas,admin'
        ]);

        Petugas::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_petugas' => $request->nama_petugas,
            'level' => $request->level
        ]);

        return redirect()->route('petugas.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id){
        $petugas = Petugas::findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id){
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'username' => 'required',
            'nama_petugas' => 'required',
            'level' => 'required|in:petugas,admin'
        ]);

        $petugas->update([
            'username' => $request->username,
            'nama_petugas' => $request->nama_petugas,
            'level' => $request->level
        ]);

        return redirect()->route('petugas.index')->with('success', 'Data berhasil diperbaharui.');
    }

    public function destroy($id){
        $petugas = Petugas::findOrFail($id);

        $petugas->delete();

        return redirect()->route('petugas.index')->with('success', 'Data berhasil dihapus.');
    }
}
