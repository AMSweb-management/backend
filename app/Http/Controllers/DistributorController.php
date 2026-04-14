<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        return response()->json(
            Distributor::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = Distributor::create($request->all());

        return response()->json([
            'message' => 'Distributor berhasil ditambah',
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        return Distributor::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Distributor::findOrFail($id);
        $data->update($request->all());

        return response()->json([
            'message' => 'Distributor berhasil diupdate',
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        Distributor::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Distributor berhasil dihapus',
        ]);
    }
}
