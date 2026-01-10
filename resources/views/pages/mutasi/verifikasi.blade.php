@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('mutasi.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    <div class="bg-white rounded-xl px-6 space-y-4">

        <form action="{{ route('mutasi.verifikasi.update', $mutasi->id_mutasi) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">

            {{-- Status Mutasi --}}
            <div>
                <label class="text-sm font-medium">Status mutasi</label>

                <select name="status_mutasi"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2
                    {{ $mutasi->status_mutasi === 'selesai' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                    {{ $mutasi->status_mutasi === 'selesai' ? 'disabled' : '' }}>

                    {{-- Pending hanya muncul jika status MASIH pending --}}
                    @if ($mutasi->status_mutasi === 'pending')
                        <option value="pending" selected>Pending</option>
                    @endif

                    {{-- Diproses selalu tersedia --}}
                    <option value="diproses"
                        {{ $mutasi->status_mutasi === 'diproses' ? 'selected' : '' }}>
                        Diproses
                    </option>

                    {{-- Selesai --}}
                    <option value="selesai"
                        {{ $mutasi->status_mutasi === 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>

                {{-- Agar tetap terkirim saat disabled --}}
                @if ($mutasi->status_mutasi === 'selesai')
                    <input type="hidden" name="status_mutasi" value="selesai">
                @endif
            </div>

            {{-- Status Verifikasi --}}
            <div>
                <label class="text-sm font-medium">Status Verifikasi</label>
                <select id="statusVerifikasi"
                        class="w-full mt-1 border rounded-md p-2 bg-gray-100"
                        disabled>
                    @foreach (['menunggu','disetujui','ditolak'] as $status)
                        <option value="{{ $status }}"
                            @selected($mutasi->status_verifikasi === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <input type="hidden"
                    name="status_verifikasi"
                    id="statusVerifikasiHidden"
                    value="{{ $mutasi->status_verifikasi }}">
            </div>

            {{-- Tanggal Verifikasi --}}
            <div>
                <label class="text-sm font-medium">Tanggal Verifikasi</label>
                <input type="date"
                    id="tanggalVerifikasi"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2 bg-gray-100"
                    readonly
                    value="{{ optional($mutasi->tanggal_verifikasi)->format('Y-m-d') }}">
            </div>

            {{-- Dokumen Pengesahan --}}
            <div>
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Dokumen Pengesahan
                        </label>
                        <label id="dokumenLabel"
                            class="flex items-center justify-center w-full px-2 py-2 mt-2 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50
                            {{ $mutasi->dokumen_pengesahan ? 'hidden' : '' }}">
                                                    <i class="fas fa-paperclip text-xl text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                                                    <input type="file"
                                                        name="dokumen_pengesahan"
                                                        accept="application/pdf"
                                                        class="hidden"
                                                        id="dokumenInput">
                        </label>
                        <div id="dokumenPreview"
                            class="flex items-center justify-between w-full px-2 py-2 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 mt-2
                            {{ empty($mutasi->dokumen_pengesahan) ? 'hidden' : '' }}">

                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-xl text-red-500 mr-2"></i>
                                <span id="dokumenNama" class="text-sm text-gray-700 truncate max-w-90">
                                    {{ $mutasi->dokumen_pengesahan ? basename($mutasi->dokumen_pengesahan) : '' }}
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
            
            <div class="bg-white py-3 px-6 grid grid-cols-2 gap-6">
                {{-- Kepemilikan Baru --}}
                <div>
                    <label class="text-sm font-medium">Pemilik Baru</label>

                    {{-- Tampilan saja --}}
                    <input type="text"
                        class="w-full mt-1 border rounded-md p-2 bg-gray-100"
                        value="{{ ucfirst($mutasi->kepemilikan_tujuan) }}"
                        readonly>

                    {{-- Nilai aktual yang dikirim --}}
                    <input type="hidden"
                        name="status_kepemilikan"
                        value="{{ $mutasi->kepemilikan_tujuan }}">
                </div>

                @php
                    $asal   = $mutasi->kepemilikan_asal;
                    $tujuan = $mutasi->kepemilikan_tujuan;

                    $autoStatus = null;
                    $editable = false;

                    if ($asal === 'pribadi' && $tujuan === 'pemerintah') {
                        $autoStatus = 'aktif';
                    } elseif ($asal === 'pemerintah' && $tujuan === 'pribadi') {
                        $autoStatus = 'mutasi keluar';
                    } elseif ($asal === 'pemerintah' && $tujuan === 'pemerintah') {
                        $editable = true;
                    }
                @endphp

                {{-- Status Penetapan --}}
                <div>
                    <label class="text-sm font-medium">Status Penetapan</label>

                    @if ($editable)
                        {{-- Bisa dipilih --}}
                        <select name="status_penetapan"
                            id="statusPenetapanSelect"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2">

                            <option value="">Pilih status penetapan</option>
                            <option value="aktif">Mutasi Masuk (Aktif)</option>
                            <option value="mutasi keluar">Mutasi Keluar</option>
                        </select>
                    @else
                        {{-- Otomatis --}}
                        <input type="text"
                            class="w-full mt-1 border rounded-md p-2 bg-gray-100"
                            value="{{ $autoStatus === 'aktif'
                                        ? 'Mutasi Masuk (Aktif)'
                                        : 'Mutasi Keluar' }}"
                            readonly>

                        <input type="hidden"
                            name="status_penetapan"
                            id="statusPenetapanHidden"
                            value="{{ $autoStatus }}">

                    @endif
                </div>

            </div>


            {{-- Tombol --}}
            <div class="flex justify-end py-6 pe-6 col-start-2">
                <button type="submit"
                        class="btn px-10 py-2 bg-indigo-500 hover:bg-indigo-600 shadow shadow-indigo-400 text-white font-semibold rounded-lg">
                    Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const statusMutasi      = document.querySelector('[name="status_mutasi"]');
        const statusVerifikasi  = document.getElementById('statusVerifikasi');
        const statusHidden      = document.getElementById('statusVerifikasiHidden');
        const tanggalVerifikasi = document.getElementById('tanggalVerifikasi');
        const dokumenInput      = document.getElementById('dokumenInput');
        const pemilikBaru       = document.getElementById('pemilikBaru');

        function today() {
            return new Date().toISOString().split('T')[0];
        }

        function handleStatusMutasi() {
            if (statusMutasi.value === 'selesai') {
                statusVerifikasi.disabled = false;
                dokumenInput.disabled = false;
                statusVerifikasi.classList.remove('bg-gray-100');
            } else {
                statusVerifikasi.disabled = true;
                dokumenInput.disabled = true;
                statusHidden.value = 'menunggu';
                tanggalVerifikasi.value = '';
                pemilikBaru.disabled = true;
            }
        }

        function handleStatusVerifikasi() {
            statusHidden.value = statusVerifikasi.value;

            if (['disetujui','ditolak'].includes(statusVerifikasi.value)) {
                tanggalVerifikasi.value = today();
            } else {
                tanggalVerifikasi.value = '';
            }

            if (statusVerifikasi.value === 'disetujui') {
                pemilikBaru.disabled = false;
                pemilikBaru.classList.remove('bg-gray-100');
            } else {
                pemilikBaru.disabled = true;
                pemilikBaru.classList.add('bg-gray-100');
            }
        }

        statusMutasi.addEventListener('change', handleStatusMutasi);
        statusVerifikasi.addEventListener('change', handleStatusVerifikasi);

        handleStatusMutasi();
        handleStatusVerifikasi();
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const statusVerifikasi = document.getElementById('statusVerifikasi');
    const statusHidden     = document.getElementById('statusVerifikasiHidden');

    const penetapanSelect  = document.getElementById('statusPenetapanSelect');
    const penetapanHidden  = document.getElementById('statusPenetapanHidden');

    function syncStatusPenetapan() {

        const isApproved = statusHidden.value === 'disetujui';

        // CASE: editable (select)
        if (penetapanSelect) {
            penetapanSelect.disabled = !isApproved;

            if (!isApproved) {
                penetapanSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
            } else {
                penetapanSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
            }
        }

        // CASE: otomatis (hidden)
        if (penetapanHidden && !isApproved) {
            // safety: jangan kirim nilai sebelum disetujui
            penetapanHidden.value = penetapanHidden.value;
        }
    }

    // jalan saat load
    syncStatusPenetapan();

    // jalan saat status verifikasi berubah
    statusVerifikasi.addEventListener('change', function () {
        statusHidden.value = this.value;
        syncStatusPenetapan();
    });
});
</script>

@endsection
