@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('user.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    {{-- Card Form --}}
    <div class="bg-white py-4 px-6 rounded-xl shadow-sm">

        <form action="{{ route('user.update', $user->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Grid 2 Kolom --}}
            <div class="grid grid-cols-2 gap-6">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $user->nama }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan nama lengkap">
                           @error('nama')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan username">
                           @error('username')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Role</label>
                    <select name="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring focus:ring-blue-300">
                        <option value="{{ $user->role }}">{{ $user->role }}</option>
                        <option value="admin">Admin</option>
                        <option value="staf">Staf</option>
                    </select>
                    @error('role')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Status --}}
                @if(auth()->user()->id !== $user->id)
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Status</label>
                    <select name="status_aktif"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring focus:ring-blue-300">
                        <option value="{{ $user->status_aktif }}">{{ $user->status_aktif }}</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                    @error('status_aktif')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>
                @endif

            </div>

            {{-- Tombol Tambah --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                        class="btn px-6 py-2 bg-amber-500 hover:bg-amber-600 shadow shadow-amber-400 text-white font-semibold rounded-lg">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection