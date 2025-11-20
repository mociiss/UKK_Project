<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index(){
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    public function create(){
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('kelas.create', compact('kelas'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required'
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id){
        $kelas = Kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id){
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required'
        ]);

        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbaharui!');
    }

    public function destroy($id){
        $kelas = Kelas::findOrFail($id);
        
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
