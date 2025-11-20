<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spp;

class SppController extends Controller
{
    public function index(){
        $spp = Spp::all();
        return view('spp.index', compact('spp'));
    }

    public function create(){
        $spp = Spp::orderBy('tahun')->get();
        return view('spp.create', compact('spp'));
    }

    public function store(Request $request){
        $request->validate([
            'tahun' => 'required|unique:spp,tahun',
            'nominal' => 'required|numeric|min:1'
        ], [
            'tahun.unique' => 'Tahun SPP ini sudah ada!',
        ]);

        Spp::create($request->all());

        return redirect()->route('spp.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id){
        $spp = Spp::find($id);
        return view('spp.edit', compact('spp'));
    }

    public function update(Request $request, $id){
        $spp = Spp::find($id);
        $request->validate([
            'tahun' => 'required|unique:spp,tahun' . $id,
            'nominal' => 'required'
        ], [
            'tahun.unique' => 'Tahun SPP ini sudah ada!',
        ]);

        $spp->update($request->all());

        return redirect()->route('spp.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id){
        $spp = Spp::find($id);
        $spp->delete();
        return redirect()->route('spp.index')->with('success', 'Data berhasil dihapus.');
    }
}
