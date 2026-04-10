<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        return Obat::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $obat = Obat::create($request->all());

        return response()->json([
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat,
        ]);
    }

    public function show($id)
    {
        return Obat::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $obat->update($request->all());

        return response()->json([
            'message' => 'Obat berhasil diupdate',
            'data' => $obat,
        ]);
    }

    public function destroy($id)
    {
        Obat::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Obat berhasil dihapus',
        ]);
    }
}
