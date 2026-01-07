@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('user.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    {{-- Card Form --}}
    <div class="bg-white py-4 px-6 rounded-xl shadow-sm">

        <form action="{{ route('user.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            {{-- Grid 2 Kolom --}}
            <div class="grid grid-cols-2 gap-6">

                {{-- NIP --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">NIP</label>
                    <input type="number" name="id"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan NIP">
                        @error('id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Username</label>
                    <input type="text" name="username"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan username">
                           @error('username')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Masukkan nama lengkap">
                           @error('nama')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">
                        Password
                    </label>

                    <div class="relative">
                        <input 
                            id="password"
                            type="password" 
                            name="password"
                            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                            placeholder="Masukkan password"
                        >

                        {{-- Icon Toggle --}}
                        <button 
                            type="button"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
                        >
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>

                    {{-- Error Message --}}
                    @error('password')
                        <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>


                {{-- Role --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Role</label>
                    <select name="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring focus:ring-blue-300">
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
                    <label class="block font-bold text-gray-700 mb-1">Status</label>
                    <input type="text" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100"
                           value="Aktif" 
                           disabled>
                    <input type="hidden" name="status_aktif" value="aktif">
                </div>

            </div>

            {{-- Tombol Tambah --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                        class="btn px-6 py-2 bg-sky-500 hover:bg-sky-700 shadow shadow-sky-400 text-white rounded-lg font-semibold">
                    Tambah Data
                </button>
            </div>

        </form>

    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>

@endsection