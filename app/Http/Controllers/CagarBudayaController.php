<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use Illuminate\Http\Request;

class CagarBudayaController extends Controller
{
    /**
     * Menampilkan seluruh data cagar budaya.
     */
    public function index()
    {
        $data = CagarBudaya::all();
        return response()->json($data);
    }

    /**
     * Menyimpan data cagar budaya baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_cagar_budaya' => 'required|string',
            'kategori' => 'required|in:benda,bangunan,struktur,situs,kawasan',
            'lokasi' => 'required|string',
            'tanggal_pertama_pencatatan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'status_kepemilikan' => 'required|in:pemerintah,pribadi',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'foto' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumen_kajian' => 'required|string',
        ]);

        $cagar = CagarBudaya::create($validated);

        return response()->json([
            'message' => 'Data berhasil ditambahkan.',
            'data' => $cagar
        ], 201);
    }

    /**
     * Menampilkan data berdasarkan id_cagar_budaya.
     */
    public function show($id)
    {
        $data = CagarBudaya::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Memperbarui data cagar budaya.
     */
    public function update(Request $request, $id)
    {
        $data = CagarBudaya::findOrFail($id);

        $validated = $request->validate([
            'nama_cagar_budaya' => 'sometimes|string',
            'kategori' => 'sometimes|in:benda,bangunan,struktur,situs,kawasan',
            'lokasi' => 'sometimes|string',
            'tanggal_pertama_pencatatan' => 'sometimes|date',
            'nilai_perolehan' => 'sometimes|numeric',
            'status_kepemilikan' => 'sometimes|in:pemerintah,pribadi',
            'kondisi' => 'sometimes|in:baik,rusak ringan,rusak berat',
            'foto' => 'sometimes|string',
            'deskripsi' => 'sometimes|string',
            'dokumen_kajian' => 'sometimes|string',
        ]);

        $data->update($validated);

        return response()->json([
            'message' => 'Data berhasil diperbarui.',
            'data' => $data
        ]);
    }

    /**
     * Menghapus data cagar budaya.
     */
    public function destroy($id)
    {
        $data = CagarBudaya::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}