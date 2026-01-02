@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('mutasi.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>


    <form action="{{ route('mutasi.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">

            {{-- Kolom Kiri --}}
            <div class="space-y-4">

                {{-- Cagar Budaya --}}
                <div>
                    <label class="text-sm font-medium">Nama Cagar Budaya</label>
                    <select name="id_cagar_budaya" id="cagarBudayaSelect" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                        <option value="">Pilih cagar budaya</option>
                        @foreach ($cagarBudaya as $cb)
                            <option 
                                value="{{ $cb->id_cagar_budaya }}"
                                data-kepemilikan="{{ $cb->status_kepemilikan }}"
                            >
                                {{ $cb->nama_cagar_budaya }}
                            </option>
                        @endforeach
                    </select>
                @error('id_cagar_budaya')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                </div>

                {{-- Penanggung Jawab --}}
                <div>
                    <label class="text-sm font-medium">Nama Penanggung Jawab</label>
                    <select name="id" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                        <option value="">Pilih penanggung jawab</option>
                        @foreach ($penanggungJawab as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                @error('id')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    
                @enderror
                </div>

                {{-- Pemilik Asal --}}
                <div>
                    <label class="text-sm font-medium">Pemilik Asal</label>
                    <select 
                        id="kepemilikanAsalDisplay"
                        disabled
                        class="w-full mt-1 border border-gray-300 rounded-md p-2 bg-gray-100 cursor-not-allowed">

                        <option value="">Pilih kepemilikan asal</option>
                        <option value="pemerintah">Pemerintah</option>
                        <option value="pribadi">Pribadi</option>
                    </select>


                {{-- Input tersembunyi untuk dikirim ke server --}}
                <input type="hidden" name="kepemilikan_asal" id="kepemilikanAsal">


                @error('kepemilikan_asal')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                </div>

                {{-- Pemilik Tujuan --}}
                <div>
                    <label class="text-sm font-medium">Pemilik Tujuan</label>
                    <select name="kepemilikan_tujuan" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                        <option value="">Pilih kepemilikan tujuan</option>
                        <option value="pemerintah">Pemerintah</option>
                        <option value="pribadi">Pribadi</option>
                    </select>
                @error('kepemilikan_tujuan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                </div>

                {{-- Tanggal Pengajuan --}}
                <div>
                    <label class="text-sm font-medium">Tanggal Pengajuan</label>
                    <input
                        type="date"
                        name="tanggal_pengajuan"
                        value="{{ now()->format('Y-m-d') }}"
                        readonly
                        class="w-full mt-1 border border-gray-300 rounded-md p-2 bg-gray-100 cursor-not-allowed"
                    >
                    @error('tanggal_pengajuan')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dokumen --}}
                <div>
                <label class="block text-sm font-medium mb-1">
                    Dokumen Pengajuan
                </label>
                <label class="flex items-center justify-center w-full px-3 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50"
                        id="dokumenLabel">
                    <i class="fas fa-paperclip text-2xl text-gray-400 mr-2"></i>
                    <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                    <input type="file"
                            name="dokumen_pengajuan"
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
                @error('dokumen_pengajuan')
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
            </div>

            {{-- Kolom Kanan --}}
            <div class="flex flex-col">
                <label class="text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan"
                    class="flex-1 border border-gray-300 rounded-md p-3 resize-none"
                    placeholder="Masukkan keterangan mutasi..."></textarea>
                @error('keterangan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="col-span-2 flex justify-end">
                <button type="submit"
                        class="btn px-6 py-2 bg-sky-500 hover:bg-sky-700 shadow shadow-sky-400 text-white rounded-lg font-semibold">
                    Ajukan
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    document.getElementById('cagarBudayaSelect').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const kepemilikan = selected.getAttribute('data-kepemilikan');

        const hiddenInput = document.getElementById('kepemilikanAsal');
        const displaySelect = document.getElementById('kepemilikanAsalDisplay');

        if (kepemilikan) {
            hiddenInput.value = kepemilikan;
            displaySelect.value = kepemilikan;
        } else {
            hiddenInput.value = '';
            displaySelect.value = '';
        }
    });
</script>


@endsection
