@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    <form action="{{ route('pemugaran.update', $pemugaran->id_pemugaran) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">

            {{-- Kolom Kiri --}}
            <div class="space-y-4">

                {{-- Nama Cagar Budaya --}}
                <div>
                    <label class="text-sm font-medium">Nama Cagar Budaya</label>
                    <select name="id_cagar_budaya" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                        @foreach ($cagarBudaya as $cb)
                            <option value="{{ $cb->id_cagar_budaya }}"
                                @selected($cb->id_cagar_budaya == $pemugaran->id_cagar_budaya)>
                                {{ $cb->nama_cagar_budaya }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Penanggung Jawab --}}
                <div>
                    <label class="text-sm font-medium">Nama Penanggung Jawab</label>
                    <select name="id" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                        @foreach ($penanggungJawab as $user)
                            <option value="{{ $user->id }}"
                                @selected($user->id == $pemugaran->id)>
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kondisi --}}
                <div>
                    <label class="text-sm font-medium">Kondisi Cagar Budaya</label>
                    <select name="kondisi" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                        @foreach (['Rusak Ringan','Rusak Sedang','Rusak Berat'] as $kondisi)
                            <option value="{{ $kondisi }}"
                                @selected($kondisi == $pemugaran->kondisi)>
                                {{ $kondisi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="text-sm font-medium">Tanggal Pengajuan</label>
                    <input type="date"
                           name="tanggal_pengajuan"
                           value="{{ $pemugaran->tanggal_pengajuan->format('Y-m-d') }}"
                           class="w-full mt-1 border border-gray-300 rounded-md p-2">
                </div>

                {{-- Biaya --}}
                <div>
                    <label class="text-sm font-medium">Biaya Pemugaran</label>
                    <input type="number"
                           name="biaya_pemugaran"
                           value="{{ $pemugaran->biaya_pemugaran }}"
                           class="w-full mt-1 border border-gray-300 rounded-md p-2">
                </div>

                {{-- Proposal --}}

                <div>
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Proposal Pengajuan
                        </label>
                        <label id="dokumenLabel"
                            class="flex items-center justify-center w-full px-3 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50
                            {{ $pemugaran->proposal_pengajuan ? 'hidden' : '' }}">
                                                    <i class="fas fa-paperclip text-2xl text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                                                    <input type="file"
                                                        name="proposal_pengajuan"
                                                        accept="application/pdf"
                                                        class="hidden"
                                                        id="dokumenInput">
                                                </label>
                                                <div id="dokumenPreview"
                            class="flex items-center justify-between w-full px-3 py-3 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mt-2
                            {{ empty($pemugaran->proposal_pengajuan) ? 'hidden' : '' }}">

                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-2xl text-red-500 mr-2"></i>
                                <span id="dokumenNama" class="text-sm text-gray-700">
                                    {{ $pemugaran->proposal_pengajuan ? basename($pemugaran->proposal_pengajuan) : '' }}
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
                </div>

            </div>

            {{-- Kolom Kanan --}}
            <div class="flex flex-col h-full">
                <label class="text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi_pengajuan"
                          class="flex-1 border border-gray-300 rounded-md p-3 resize-none">{{ $pemugaran->deskripsi_pengajuan }}</textarea>

                
            </div>
            <div class="flex justify-end mt-4 col-start-2">
                    <button type="submit"
                            class="btn px-6 py-2 bg-amber-500 hover:bg-amber-600 shadow shadow-amber-400 text-white font-semibold rounded-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
            </div>


    </form>

</div>
@endsection
