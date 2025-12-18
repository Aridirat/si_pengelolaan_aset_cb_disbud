@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('penghapusan.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    <form action="{{ route('penghapusan.verifikasi.update', $penghapusan->id_penghapusan) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">

            {{-- Status penghapusan --}}
            <div>
                <label class="text-sm font-medium">Status penghapusan</label>
                <select name="status_penghapusan" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                    <option value="">Pilih status penghapusan</option>
                    @foreach (['pending','diproses','selesai'] as $status)
                        <option value="{{ $status }}"
                            {{ $penghapusan->status_penghapusan == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status_penghapusan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Verifikasi --}}
            <div>
                <label class="text-sm font-medium">Status Verifikasi</label>
                <select name="status_verifikasi" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                    <option value="">Pilih status verifikasi</option>
                    @foreach (['menunggu','disetujui','ditolak'] as $status)
                        <option value="{{ $status }}"
                            {{ $penghapusan->status_verifikasi == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status_verifikasi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Verifikasi --}}
            <div>
                <label class="text-sm font-medium">Tanggal Verifikasi</label>
                <input type="date"
                       name="tanggal_verifikasi"
                       value="{{ optional($penghapusan->tanggal_verifikasi)->format('Y-m-d') }}"
                       class="w-full mt-1 border border-gray-300 rounded-md p-2">
                @error('tanggal_verifikasi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dokumen Pengesahan --}}
            <div>
                <div>
                        <label class="block text-sm font-medium mb-1">
                            Dokumen Penghapusan
                        </label>
                        <label id="dokumenLabel"
                            class="flex items-center justify-center w-full px-2 py-1 mt-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50
                            {{ $penghapusan->dokumen_penghapusan ? 'hidden' : '' }}">
                                                    <i class="fas fa-paperclip text-xl text-gray-400 mr-2 py-1"></i>
                                                    <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                                                    <input type="file"
                                                        name="dokumen_penghapusan"
                                                        accept="application/pdf"
                                                        class="hidden"
                                                        id="dokumenInput">
                        </label>
                        <div id="dokumenPreview"
                            class="flex items-center justify-between w-full px-2 py-2 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mt-2
                            {{ empty($penghapusan->dokumen_penghapusan) ? 'hidden' : '' }}">

                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-2xl text-red-500 mr-2"></i>
                                <span id="dokumenNama" class="text-sm text-gray-700 truncate max-w-45">
                                    {{ $penghapusan->dokumen_penghapusan ? basename($penghapusan->dokumen_penghapusan) : '' }}
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

                {{-- Tombol --}}
                <div class="flex justify-end col-start-2">
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
