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

        <div class="bg-white rounded-xl px-6">

            <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">
                {{-- Status Penghapusan --}}
                    <div>
                        <label class="text-sm font-medium">Status Penghapusan</label>

                        <select name="status_penghapusan"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2
                            {{ $penghapusan->status_penghapusan === 'selesai' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            {{ $penghapusan->status_penghapusan === 'selesai' ? 'disabled' : '' }}>

                            {{-- Pending hanya muncul jika status MASIH pending --}}
                            @if ($penghapusan->status_penghapusan === 'pending')
                                <option value="pending" selected>Pending</option>
                            @endif

                            {{-- Diproses selalu tersedia --}}
                            <option value="diproses"
                                {{ $penghapusan->status_penghapusan === 'diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            {{-- Selesai --}}
                            <option value="selesai"
                                {{ $penghapusan->status_penghapusan === 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>

                        {{-- Agar tetap terkirim saat disabled --}}
                        @if ($penghapusan->status_penghapusan === 'selesai')
                            <input type="hidden" name="status_penghapusan" value="selesai">
                        @endif
                    </div>


                {{-- Status Verifikasi --}}
                <div>
                    <label class="text-sm font-medium">Status Verifikasi</label>
                    <select id="statusVerifikasiSelect"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2">
                        @foreach (['menunggu','ditolak','disetujui'] as $status)
                            <option value="{{ $status }}"
                                {{ $penghapusan->status_verifikasi == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <input type="hidden"
                        name="status_verifikasi"
                        id="statusVerifikasiHidden"
                        value="{{ $penghapusan->status_verifikasi }}">

                </div>

                {{-- Tanggal Verifikasi --}}
                <div>
                    <label class="text-sm font-medium">Tanggal Verifikasi</label>
                    <input type="date"
                        name="tanggal_verifikasi"
                        id="tanggalVerifikasi"
                        value="value="{{ optional($penghapusan->tanggal_verifikasi)->format('Y-m-d') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2 bg-gray-100 text-gray-500 cursor-not-allowed"
                        readonly
                        disabled>
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
                                    <span id="dokumenNama" class="text-sm text-gray-700 truncate max-w-90">
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
                    
            </div>

            <hr class="text-gray-200">

            <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium">Status Penetapan Baru</label>

                    <input type="text"
                        id="statusPenetapan"
                        class="w-full mt-1 border rounded-md p-2 bg-gray-100 text-gray-500 cursor-not-allowed"
                        value="Menunggu verifikasi"
                        readonly>

                    <input type="hidden"
                        name="status_penetapan"
                        id="statusPenetapanHidden"
                        value="">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end col-start-2 pb-6">
                <button type="submit"
                        class="btn px-6 py-2 bg-indigo-500 hover:bg-indigo-600 shadow shadow-indigo-400 text-white font-semibold rounded-lg">
                    Verifikasi
                </button>
            </div>
        </div>
        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const statusPenghapusan = document.querySelector('[name="status_penghapusan"]');
    const statusVerifikasiSelect = document.getElementById('statusVerifikasiSelect');
    const statusVerifikasiHidden = document.getElementById('statusVerifikasiHidden');

    const dokumenInput = document.getElementById('dokumenInput');
    const dokumenLabel = document.getElementById('dokumenLabel');
    const dokumenPreview = document.getElementById('dokumenPreview');
    const tanggalVerifikasi = document.getElementById('tanggalVerifikasi');
    const statusPenetapan = document.getElementById('statusPenetapan');
    const statusPenetapanHidden = document.getElementById('statusPenetapanHidden');

    function syncStatusVerifikasi() {
        statusVerifikasiHidden.value = statusVerifikasiSelect.value;
    }

    function resetVerifikasi() {
        statusVerifikasiSelect.disabled = true;
        statusVerifikasiSelect.classList.add(
            'bg-gray-100','text-gray-400','cursor-not-allowed'
        );

        dokumenInput.disabled = true;
        dokumenPreview.classList.add('opacity-50','pointer-events-none');
        dokumenLabel.classList.add('opacity-50','pointer-events-none');

        tanggalVerifikasi.value = '';
        statusPenetapan.value = 'Menunggu verifikasi';
        statusPenetapanHidden.value = '';

        syncStatusVerifikasi();
    }

    function enableVerifikasi() {
        statusVerifikasiSelect.disabled = false;
        statusVerifikasiSelect.classList.remove(
            'bg-gray-100','text-gray-400','cursor-not-allowed'
        );

        dokumenInput.disabled = false;
        dokumenPreview.classList.remove('opacity-50','pointer-events-none');
        dokumenLabel.classList.remove('opacity-50','pointer-events-none');
    }

    statusPenghapusan.addEventListener('change', function () {
        this.value === 'selesai'
            ? enableVerifikasi()
            : resetVerifikasi();
    });

    statusVerifikasiSelect.addEventListener('change', function () {
        const today = new Date().toISOString().split('T')[0];
        syncStatusVerifikasi();

        if (this.value === 'disetujui') {
            tanggalVerifikasi.value = today;
            statusPenetapan.value = 'Terhapus';
            statusPenetapanHidden.value = 'terhapus';
        } 
        else if (this.value === 'ditolak') {
            tanggalVerifikasi.value = today;
            statusPenetapan.value = 'Status penetapan tidak berubah';
            statusPenetapanHidden.value = '';
        } 
        else {
            tanggalVerifikasi.value = '';
            statusPenetapan.value = 'Menunggu verifikasi';
            statusPenetapanHidden.value = '';
        }
    });

    // INIT
    if (statusPenghapusan.value !== 'selesai') {
        resetVerifikasi();
    } else {
        enableVerifikasi();
    }

    syncStatusVerifikasi();
});
</script>

@endsection
