@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    <form action="{{ route('pemugaran.verifikasi.update', $pemugaran->id_pemugaran) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl p-6 space-y-4">

            {{-- Baris 1 --}}
            <div class="grid grid-cols-3 gap-4 pb-4">
                <div>
                    <label class="text-sm font-medium">Status Pemugaran</label>
                    <select name="status_pemugaran"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2">

                        @php
                            $currentStatusPemugaran =
                                old('status_pemugaran')
                                ?? $pemugaran->status_pemugaran
                                ?? 'pending';
                        @endphp

                        @foreach (['pending','diproses','selesai'] as $status)
                            <option value="{{ $status }}"
                                {{ $currentStatusPemugaran === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <label class="text-sm font-medium">Status Verifikasi</label>
                    <select name="status_verifikasi"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2">

                        @php
                            $currentStatusVerifikasi =
                                old('status_verifikasi')
                                ?? $pemugaran->status_verifikasi
                                ?? 'menunggu';
                        @endphp

                        @foreach (['menunggu','ditolak','disetujui'] as $status)
                            <option value="{{ $status }}"
                                {{ $currentStatusVerifikasi === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <label class="text-sm font-medium">Tanggal Verifikasi</label>
                    <input type="date"
                           name="tanggal_verifikasi"
                           value="{{ optional($pemugaran->tanggal_verifikasi)->format('Y-m-d') }}"
                           class="w-full mt-1 border border-gray-300 rounded-md p-2">
                </div>
                @error('tanggal_verifikasi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            {{-- Baris 2 --}}
            <div class="grid grid-cols-3 gap-4 pt-3">
                <div>
                    <label class="text-sm font-medium">Tanggal Selesai</label>
                    <input type="date"
                           name="tanggal_selesai"
                           value="{{ optional($pemugaran->tanggal_selesai)->format('Y-m-d') }}"
                           class="w-full mt-1 border border-gray-300 rounded-md p-2">
                </div>

                <div>
                    <label class="text-sm font-medium">Bukti Dokumentasi</label>
                    <input type="url"
                           name="bukti_dokumentasi"
                           value="{{ $pemugaran->bukti_dokumentasi }}"
                           placeholder="Link Google Drive Dokumentasi"
                           class="w-full mt-1 border border-gray-300 rounded-md p-2">
                </div>

                <div>
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Laporan Pertanggungjawaban
                        </label>
                        <label id="dokumenLabel"
                            class="flex items-center justify-center w-full px-2 py-1 mt-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50
                            {{ $pemugaran->laporan_pertanggungjawaban ? 'hidden' : '' }}">
                                                    <i class="fas fa-paperclip text-xl text-gray-400 mr-2 py-1"></i>
                                                    <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                                                    <input type="file"
                                                        name="laporan_pertanggungjawaban"
                                                        accept="application/pdf"
                                                        class="hidden"
                                                        id="dokumenInput">
                        </label>
                        <div id="dokumenPreview"
                            class="flex items-center justify-between w-full px-2 py-2 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mt-2
                            {{ empty($pemugaran->laporan_pertanggungjawaban) ? 'hidden' : '' }}">

                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-2xl text-red-500 mr-2"></i>
                                <span id="dokumenNama" class="text-sm text-gray-700 truncate max-w-45">
                                    {{ $pemugaran->laporan_pertanggungjawaban ? basename($pemugaran->laporan_pertanggungjawaban) : '' }}
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

                {{-- Tombol --}}
                <div class="flex justify-end pt-4">
                    <button type="submit"
                            class="btn px-6 py-2 bg-indigo-500 hover:bg-indigo-600 shadow shadow-indigo-400 text-white font-semibold rounded-lg">
                        Verifikasi
                    </button>
            </div>

            </div>

        </div>
    </form>

</div>
@endsection
