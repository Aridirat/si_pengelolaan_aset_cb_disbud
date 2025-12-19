@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('cagar_budaya.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    {{-- Card --}}
    <div class="bg-white rounded-xl p-6">

        <form action="{{ route('cagar_budaya.update', $data->id_cagar_budaya) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-4 gap-6">

                {{-- KOLOM KIRI --}}
                <div class="col-span-2 space-y-4">

                    {{-- FOTO --}}
                    <div class="relative">
                        <label
                            class="flex flex-col items-center justify-center h-48 bg-white border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50"
                            id="fotoLabel"
                            @if($data->foto) style="display: none;" @endif>
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
                                 src="{{ $data->foto ? asset('storage/' . $data->foto) : '' }}"
                                 class="@if(!$data->foto) hidden @endif w-full h-48 object-cover rounded-lg cursor-pointer" 
                                 alt="Preview">
                            <div id="fotoOverlay" 
                                 class="@if(!$data->foto) hidden @endif absolute inset-0 bg-gray-700/30 border border-dashed border-gray-300 rounded-lg flex items-center justify-center hover:flex">
                                <button type="button" 
                                        id="fotoUbah"
                                        class="bg-white rounded-full py-2 px-3 hover:bg-gray-100">
                                    <i class="fas fa-pen text-gray-700"></i>
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

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Nama Cagar Budaya
                        </label>
                        <input type="text"
                               name="nama_cagar_budaya"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                               placeholder="Masukkan nama"
                               value="{{ $data->nama_cagar_budaya }}">
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Kategori
                        </label>
                        <select name="kategori"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:ring focus:ring-gray-300">
                            <option value="">Pilih kategori</option>
                            <option value="benda" {{ $data->kategori == 'benda' ? 'selected' : '' }}>Benda</option>
                            <option value="bangunan" {{ $data->kategori == 'bangunan' ? 'selected' : '' }}>Bangunan</option>
                            <option value="struktur" {{ $data->kategori == 'struktur' ? 'selected' : '' }}>Struktur</option>
                            <option value="situs" {{ $data->kategori == 'situs' ? 'selected' : '' }}>Situs</option>
                            <option value="kawasan" {{ $data->kategori == 'kawasan' ? 'selected' : '' }}>Kawasan</option>
                        </select>
                    </div>

                    {{-- LOKASI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Lokasi
                        </label>
                        <input type="text"
                               name="lokasi"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                               placeholder="Desa, Kecamatan"
                               value="{{ $data->lokasi }}">
                    </div>

                    {{-- STATUS KEPEMILIKAN --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Status Kepemilikan
                        </label>
                        <select name="status_kepemilikan"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:ring focus:ring-gray-300">
                            <option value="">Pilih status kepemilikan</option>
                            <option value="pemerintah" {{ $data->status_kepemilikan == 'pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                            <option value="pribadi" {{ $data->status_kepemilikan == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                        </select>
                    </div>

                    {{-- KONDISI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Kondisi Cagar Budaya
                        </label>
                        <select name="kondisi"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:ring focus:ring-gray-300">
                            <option value="">Pilih kondisi</option>
                            <option value="baik" {{ $data->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak ringan" {{ $data->kondisi == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak berat" {{ $data->kondisi == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>

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
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                               value="{{ $data->tanggal_pertama_pencatatan ? $data->tanggal_pertama_pencatatan->format('Y-m-d') : '' }}">
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
                               placeholder="Rp"
                               value="{{ $data->nilai_perolehan }}">
                    </div>

                    {{-- DOKUMEN --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Dokumen Kajian (PDF)
                        </label>
                        <label id="dokumenLabel"
                            class="flex items-center justify-center w-full px-3 py-3 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50
                            {{ $data->dokumen_kajian ? 'hidden' : '' }}">
                                                    <i class="fas fa-paperclip text-2xl text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                                                    <input type="file"
                                                        name="dokumen_kajian"
                                                        accept="application/pdf"
                                                        class="hidden"
                                                        id="dokumenInput">
                                                </label>
                                                <div id="dokumenPreview"
                            class="flex items-center justify-between w-full px-3 py-3 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 mt-2
                            {{ empty($data->dokumen_kajian) ? 'hidden' : '' }}">

                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-2xl text-red-500 mr-2"></i>
                                <span id="dokumenNama" class="text-sm text-gray-700">
                                    {{ $data->dokumen_kajian ? basename($data->dokumen_kajian) : '' }}
                                </span>
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
                                            </div>

                                            <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const input = document.getElementById('dokumenInput');
                            const label = document.getElementById('dokumenLabel');
                            const preview = document.getElementById('dokumenPreview');
                            const nama = document.getElementById('dokumenNama');
                            const warning = document.getElementById('dokumenWarning');

                            document.getElementById('dokumenUbah')?.addEventListener('click', function () {
                                input.click();
                            });

                            input.addEventListener('change', function (e) {
                                const file = e.target.files[0];

                                if (!file) return;

                                if (file.size > 5 * 1024 * 1024) {
                                    warning.classList.remove('hidden');
                                    preview.classList.add('hidden');
                                    label.classList.remove('hidden');
                                    input.value = '';
                                    return;
                                }

                                warning.classList.add('hidden');
                                nama.textContent = file.name;
                                label.classList.add('hidden');
                                preview.classList.remove('hidden');
                            });
                        });
                        </script>


                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi"
                                  rows="6"
                                  class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-gray-300"
                                  placeholder="Deskripsi cagar budaya"
                                  >{{ $data->deskripsi }}</textarea>
                    </div>

                </div>
            </div>

            {{-- TOMBOL --}}
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
