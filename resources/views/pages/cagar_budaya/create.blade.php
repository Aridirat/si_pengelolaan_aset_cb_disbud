@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('cagar_budaya.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    {{-- Card --}}
    <div class="bg-white rounded-xl p-6">

        <form action="{{ route('cagar_budaya.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-4 gap-6">

                {{-- KOLOM KIRI --}}
                <div class="col-span-2 space-y-4">

                    {{-- FOTO --}}
                    <div class="relative">
                        <label
                            class="flex flex-col items-center justify-center h-48 bg-white border-2 border-dotted border-gray-300 rounded-lg cursor-pointer hover:bg-neutral-50"
                            id="fotoLabel">
                            <i class="far fa-image text-4xl text-gray-400 mb-2"></i>
                            <span class="text-sm text-gray-500">Klik untuk menambah foto</span>
                            <input type="file"
                                   name="foto"
                                   accept="image/*"
                                   class="hidden"
                                   id="fotoInput">
                        </label>
                        <div class="relative">
                            <img id="fotoPreview" 
                                 class="hidden w-full h-48 object-cover rounded-lg cursor-pointer border border-dashed border-gray-300" 
                                 alt="Preview">
                            <div id="fotoOverlay" 
                                 class="hidden absolute inset-0 bg-gray-700/30 rounded-lg flex items-center justify-center hover:flex">
                                <button type="button" 
                                        id="fotoUbah"
                                        class="bg-white rounded-full p-3 hover:bg-gray-100">
                                    <i class="fas fa-edit text-gray-700"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="fotoError" class="hidden text-red-500 text-xs mt-1"></div>

                    <script>
                        document.getElementById('fotoPreview').addEventListener('mouseenter', function() {
                            document.getElementById('fotoOverlay').classList.remove('hidden');
                        });

                        document.getElementById('fotoPreview').addEventListener('mouseleave', function() {
                            document.getElementById('fotoOverlay').classList.add('hidden');
                        });

                        document.getElementById('fotoUbah').addEventListener('click', function(e) {
                            e.preventDefault();
                            document.getElementById('fotoInput').click();
                        });

                        document.getElementById('fotoInput').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    const preview = document.getElementById('fotoPreview');
                                    preview.src = event.target.result;
                                    preview.classList.remove('hidden');
                                    document.getElementById('fotoLabel').classList.add('hidden');
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>
                    <p class="text-xs text-gray-500">
                        JPG, PNG, maksimal 2 MB
                    </p>
                    @error('foto')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p> 
                    @enderror

                    {{-- NOMOR --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Nomor Cagar Budaya
                        </label>
                        <input type="number"
                               name="id_cagar_budaya"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                               placeholder="Masukkan nomor">
                            @error('id_cagar_budaya')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Nama Cagar Budaya
                        </label>
                        <input type="text"
                               name="nama_cagar_budaya"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                               placeholder="Masukkan nama">
                        @error('nama_cagar_budaya')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror        
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Kategori
                        </label>
                        <select name="kategori"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:ring focus:ring-gray-300">
                            <option value="">Pilih kategori</option>
                            <option value="benda">Benda</option>
                            <option value="bangunan">Bangunan</option>
                            <option value="struktur">Struktur</option>
                            <option value="situs">Situs</option>
                            <option value="kawasan">Kawasan</option>
                        </select>
                        @error('kategori')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- LOKASI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Lokasi
                        </label>
                        <input type="text"
                               name="lokasi"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                               placeholder="Desa, Kecamatan">
                            @error('lokasi')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                    </div>

                    {{-- STATUS PENETAPAN --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Status Penetapan
                        </label>
                        <select name="status_penetapan"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:ring focus:ring-gray-300">
                            <option value="">Pilih status</option>
                            <option value="aktif">Aktif</option>
                            <option value="terhapus">Terhapus</option>
                        </select>
                    @error('status_penetapan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    </div>

                    {{-- STATUS KEPEMILIKAN --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Status Kepemilikan
                        </label>
                        <select name="status_kepemilikan"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:ring focus:ring-gray-300">
                            <option value="">Pilih status</option>
                            <option value="pemerintah">Pemerintah</option>
                            <option value="pribadi">Pribadi</option>
                        </select>
                    @error('status_kepemilikan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    </div>

                    {{-- KONDISI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Kondisi Cagar Budaya
                        </label>
                        <select name="kondisi"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:ring focus:ring-gray-300">
                            <option value="">Pilih kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="rusak ringan">Rusak Ringan</option>
                            <option value="rusak berat">Rusak Berat</option>
                        </select>
                    </div>
                    @error('kondisi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- KOLOM KANAN --}}
                <div class="col-span-2 space-y-4">

                    {{-- TANGGAL --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Tanggal Pencatatan
                        </label>
                        <input type="date"
                               name="tanggal_pertama_pencatatan"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300">
                    @error('tanggal_pertama_pencatatan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    </div>

                    {{-- NILAI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Nilai Perolehan
                        </label>
                        <input type="number"
                               name="nilai_perolehan"
                               min="0"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                               placeholder="Rp">
                        @error('nilai_perolehan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DOKUMEN --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Dokumen Kajian
                        </label>
                        <label class="flex items-center justify-center w-full px-3 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50"
                               id="dokumenLabel">
                            <i class="fas fa-paperclip text-2xl text-gray-400 mr-2"></i>
                            <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                            <input type="file"
                                   name="dokumen_kajian"
                                   accept="application/pdf"
                                   class="hidden"
                                   id="dokumenInput">
                        </label>
                        <div id="dokumenPreview" class="hidden flex items-center justify-between w-full px-3 py-3 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mt-2">
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-2xl text-red-500 mr-2"></i>
                                <span id="dokumenNama" class="text-sm text-gray-700"></span>
                            </div>
                            <button type="button"
                                    id="dokumenUbah"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                Ubah
                            </button>
                        </div>
                        <div id="dokumenWarning" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg flex items-start">
                            <i class="fas fa-exclamation-triangle text-red-600 mr-2 mt-0.5"></i>
                            <span class="text-xs text-red-700">File terlalu besar. Maksimal ukuran 5 MB.</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            PDF, maksimal 5 MB
                        </p>
                        <div id="dokumenError" class="hidden text-red-500 text-xs mt-1"></div>
                        @error('dokumen_kajian')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        document.getElementById('dokumenUbah').addEventListener('click', function() {
                            document.getElementById('dokumenInput').click();
                        });

                        document.getElementById('dokumenInput').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                if (file.size > 5 * 1024 * 1024) {
                                    document.getElementById('dokumenWarning').classList.remove('hidden');
                                    document.getElementById('dokumenError').classList.add('hidden');
                                    document.getElementById('dokumenPreview').classList.add('hidden');
                                    document.getElementById('dokumenLabel').classList.remove('hidden');
                                    e.target.value = '';
                                } else {
                                    document.getElementById('dokumenWarning').classList.add('hidden');
                                    document.getElementById('dokumenError').classList.add('hidden');
                                    document.getElementById('dokumenNama').textContent = file.name;
                                    document.getElementById('dokumenLabel').classList.add('hidden');
                                    document.getElementById('dokumenPreview').classList.remove('hidden');
                                }
                            }
                        });
                    </script>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi"
                                  rows="16"
                                  class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                                  placeholder="Deskripsi cagar budaya"></textarea>
                        @error('deskripsi')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                        class="btn px-6 py-2 bg-sky-500 hover:bg-sky-700 shadow shadow-sky-400 text-white rounded-lg font-semibold">
                    Tambah Data
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
