<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Menampilkan seluruh data pengguna.
     */
    public function index()
    {
        $data = Pengguna::all();
        return response()->json($data);
    }

    /**
     * Menyimpan data pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'username'     => 'required|string|unique:pengguna,username',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:admin,staf',
            'status_aktif' => 'required|in:aktif,tidak aktif'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $pengguna = Pengguna::create($validated);

        return response()->json([
            'message' => 'Pengguna berhasil ditambahkan.',
            'data' => $pengguna
        ], 201);
    }

    /**
     * Menampilkan data pengguna berdasarkan ID.
     */
    public function show($id)
    {
        $data = Pengguna::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $validated = $request->validate([
            'nama'      => 'sometimes|string|max:255',
            'username'     => 'sometimes|string|unique:pengguna,username,' . $id . ',id_pengguna',
            'role'      => 'sometimes|in:admin,staf',
            'status_aktif' => 'sometimes|in:aktif,tidak aktif'
        ]);

        $pengguna->update($validated);

        return response()->json([
            'message' => 'Data pengguna berhasil diperbarui.',
            'data' => $pengguna
        ]);
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return response()->json([
            'message' => 'Data pengguna berhasil dihapus.'
        ]);
    }
}