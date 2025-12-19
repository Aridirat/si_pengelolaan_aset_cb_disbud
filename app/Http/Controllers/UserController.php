<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('status_aktif', 'like', '%' . $search . '%');
            });
        }

        $allResults = $query->get();
        $users = $query->orderBy('id', 'desc')->paginate(5);

        return view('pages.user.index', [
            "users" => $users,
            "allResults" => $allResults,
            "search" => $request->input('search', '')
        ]);
    }

    public function create() {
        return view('pages.user.create');
    }

    /**
     * Menyimpan data user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'        => 'required|numeric|unique:users,id',
            'nama'      => 'required|string|max:255',
            'username'     => 'required|string|unique:users,username',
            'password'  => 'required|string|',
            'role'      => 'required|in:admin,staf',
            'status_aktif' => 'required|in:aktif,tidak aktif'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Menampilkan data user berdasarkan ID.
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        return response()->json($data);
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }
    /**
     * Memperbarui data user.
     */
    public function update(Request $request, $id)
    {
        
        $validated = $request->validate([
            'nama'      => 'sometimes|string|max:255',
            'username'     => 'sometimes|string|unique:users,username,' . $id . ',id',
            'role'      => 'sometimes|in:admin,staf',
            'status_aktif' => 'sometimes|in:aktif,tidak aktif'
        ]);
        
        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect('/user')->with('success', 'Berhasil Mengubah Data Pengguna');
    }

    /**
     * Menghapus user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Data user berhasil dihapus.');

    }
}