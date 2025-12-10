@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('user.index') }}" class="flex items-center text-gray-700 mb-4 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    {{-- Card Form --}}
    <div class="bg-white py-4 px-6 rounded-xl shadow-sm">

        <form action="{{ route('user.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            {{-- Grid 2 Kolom --}}
            <div class="grid grid-cols-2 gap-6">

                {{-- NIP --}}
                <div>
                    <label class="block text-gray-700 mb-1">NIP</label>
                    <input type="number" name="id"
                           class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan NIP">
                        @error('id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-gray-700 mb-1">Username</label>
                    <input type="text" name="username"
                           class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan username">
                           @error('username')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama"
                           class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan nama lengkap">
                           @error('nama')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan password">
                           @error('password')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-gray-700 mb-1">Role</label>
                    <select name="role"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg bg-white focus:ring focus:ring-blue-300">
                        <option value="">Pilih role</option>
                        <option value="admin">Admin</option>
                        <option value="staf">Staf</option>
                    </select>
                    @error('role')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-gray-700 mb-1">Status</label>
                    <select name="status_aktif"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg bg-white focus:ring focus:ring-blue-300">
                        <option value="">Pilih status</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                    @error('status_aktif')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

            </div>

            {{-- Tombol Tambah --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Tambah Data
                </button>
            </div>

        </form>

    </div>
</div>
@endsection