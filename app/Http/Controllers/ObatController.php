<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        return response()->json(
            Obat::with('distributor')->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'distributor_id' => 'nullable|exists:distributors,id',
        ]);

        $obat = Obat::create($request->all());
        Obat::with('distributor')->get();

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
            'distributor_id' => 'nullable|exists:distributors,id',
        ]);
        
        Obat::with('distributor')->findOrFail($id);
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
