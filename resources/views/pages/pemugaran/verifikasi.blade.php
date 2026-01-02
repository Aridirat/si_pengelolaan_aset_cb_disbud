@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    @php
        $verifikasiFinal = in_array(
            $pemugaran->status_verifikasi,
            ['ditolak','disetujui']
        );
    @endphp

    <form action="{{ route('pemugaran.verifikasi.update', $pemugaran->id_pemugaran) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl p-6 space-y-4">

            {{-- Baris 1 --}}
            <div class="grid grid-cols-3 gap-4 pb-4">
                <div>
                    @php
                        $statusPemugaranDB = $pemugaran->status_pemugaran;
                        $disableStatusPemugaran = $statusPemugaranDB === 'selesai';
                    @endphp

                    <label class="text-sm font-medium">Status Pemugaran</label>
                    <select name="status_pemugaran"
                        id="statusPemugaran"
                        class="
                            w-full mt-1 border rounded-md p-2
                            {{ $disableStatusPemugaran
                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                : 'bg-white text-gray-800 border-gray-300'
                            }}
                        "
                        {{ $disableStatusPemugaran ? 'disabled' : '' }}>


                        @foreach (['pending','diproses','selesai'] as $status)
                            @if (
                                ($statusPemugaranDB === 'diproses' && $status === 'pending')
                                || ($statusPemugaranDB === 'selesai' && $status !== 'selesai')
                            )
                                @continue
                            @endif

                            <option value="{{ $status }}"
                                @selected($statusPemugaranDB === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    @if ($disableStatusPemugaran)
                        <input type="hidden" name="status_pemugaran" value="{{ $statusPemugaranDB }}">
                    @endif

                </div>

                {{-- Status Verifikasi --}}
                <div>
                    @php
                        $statusVerifikasiDB = $pemugaran->status_verifikasi;
                        $statusPemugaranDB  = $pemugaran->status_pemugaran;

                        $disableVerifikasi =
                            $statusPemugaranDB !== 'selesai'
                            || in_array($statusVerifikasiDB, ['ditolak','disetujui']);
                    @endphp

                    <label class="text-sm font-medium">Status Verifikasi</label>

                    <select id="statusVerifikasi"
                            class="w-full mt-1 border rounded-md p-2 bg-gray-100 text-gray-400"
                            disabled>
                        @foreach (['menunggu','ditolak','disetujui'] as $status)
                            <option value="{{ $status }}"
                                @selected($pemugaran->status_verifikasi === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <input type="hidden"
                        name="status_verifikasi"
                        id="statusVerifikasiHidden"
                        value="{{ $pemugaran->status_verifikasi }}">
                </div>


                <div>
                    <label class="text-sm font-medium">Tanggal Verifikasi</label>
                    <input type="date"
                        name="tanggal_verifikasi"
                        id="tanggalVerifikasi"
                        value="{{ optional($pemugaran->tanggal_verifikasi)->format('Y-m-d') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2 bg-gray-100"
                        readonly>
                </div>
                @error('tanggal_verifikasi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="text-gray-300">


            {{-- Baris 2 --}}
            @php
                $pemugaranSelesai = $pemugaran->status_pemugaran === 'selesai';
            @endphp
            <div class="grid grid-cols-3 gap-4 pt-3">
                <div>
                    <label class="text-sm font-medium">Tanggal Selesai</label>
                    <input type="date"
                        name="tanggal_selesai"
                        id="tanggalSelesai"
                        value="{{ optional($pemugaran->tanggal_selesai)->format('Y-m-d') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2 bg-gray-100"
                        readonly>
                </div>

                <div>
                    <label class="text-sm font-medium">Bukti Dokumentasi</label>
                    <input type="url"
                        name="bukti_dokumentasi"
                        id="buktiDokumentasi"
                        value="{{ $pemugaran->bukti_dokumentasi }}"
                        placeholder="Link Google Drive Dokumentasi"
                        class="
                                w-full mt-1 border border-gray-300 rounded-md p-2
                                {{ $verifikasiFinal ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}
                        "
                        {{ $verifikasiFinal ? 'readonly' : '' }}>
                </div>

                <div>
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Laporan Pertanggungjawaban
                        </label>
                        <label id="dokumenLabel"
                            class="
                                flex items-center justify-center w-full px-2 py-1 mt-2
                                border-2 border-dashed rounded-lg
                                {{ $verifikasiFinal
                                    ? 'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'
                                    : 'border-gray-300 cursor-pointer hover:bg-gray-50'
                                }}
                                {{ $pemugaran->laporan_pertanggungjawaban ? 'hidden' : '' }}
                            ">
                                                    <i class="fas fa-paperclip text-xl text-gray-400 mr-2 py-1"></i>
                                                    <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                                                    <input type="file"
                                                        name="laporan_pertanggungjawaban"
                                                        id="dokumenInput"
                                                        accept="application/pdf"
                                                        class="hidden"
                                                        id="dokumenInput"
                                                        {{ $verifikasiFinal ? 'disabled' : '' }}>

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
                                    class="
                                        text-xs font-medium
                                        {{ $verifikasiFinal
                                            ? 'text-gray-400 cursor-not-allowed'
                                            : 'text-blue-600 hover:text-blue-800'
                                        }}
                                    "
                                    {{ $verifikasiFinal ? 'disabled' : '' }}>
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
                            const verifikasiFinal = @json($verifikasiFinal);

                            document.getElementById('dokumenUbah')?.addEventListener('click', function () {
                                if (verifikasiFinal) return;
                                input.click();
                            });

                            input.addEventListener('change', function (e) {
                                if (verifikasiFinal) return;
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

                

            <hr class="text-gray-300">

            {{-- Baris 3 --}}
            {{-- Ini adalah 2 field khusus yang otomatis tercatat sebagai update data ke tabel cagar budaya di field nilai_perolehan dan kondisi--}}
            <div class="grid grid-cols-3 gap-4 pt-3">
                {{-- Nilai Perolehan Baru --}}
            <div>
                <label class="text-sm font-medium">Nilai Perolehan Baru</label>
                <input type="number"
                    id="nilaiPerolehanBaru"
                    class="w-full mt-1 border rounded-md p-2 bg-gray-100 text-gray-400 cursor-not-allowed"
                    placeholder="Rp."
                    readonly>

                <input type="hidden"
                    name="nilai_perolehan"
                    id="nilaiPerolehanHidden">
            </div>

            {{-- Kondisi Baru --}}
            <div>
                <label class="text-sm font-medium">Kondisi Baru</label>
                <select id="kondisiBaru"
                        class="w-full mt-1 border rounded-md p-2 bg-gray-100 text-gray-400 cursor-not-allowed"
                        disabled>
                    <option value="">Pilih Kondisi Baru</option>
                    <option value="baik">Baik</option>
                </select>

                <input type="hidden"
                    name="kondisi_baru"
                    id="kondisiBaruHidden">
            </div>

            </div>
            {{-- End Baris 3 --}}

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

<script>
    window.STATUS_VERIFIKASI_FINAL = @json(
        in_array($pemugaran->status_verifikasi, ['ditolak','disetujui'])
    );
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const statusPemugaran = document.getElementById('statusPemugaran');
        const statusVerifikasi = document.getElementById('statusVerifikasi');
        const statusVerifikasiHidden = document.getElementById('statusVerifikasiHidden');

        const tanggalSelesai = document.getElementById('tanggalSelesai');
        const tanggalVerifikasi = document.getElementById('tanggalVerifikasi');

        const buktiDokumentasi = document.getElementById('buktiDokumentasi');
        const laporanInput = document.getElementById('dokumenInput');

        const hasBuktiDokumentasi = @json(!empty($pemugaran->bukti_dokumentasi));
        const hasLaporan = @json(!empty($pemugaran->laporan_pertanggungjawaban));

        const nilaiInput = document.getElementById('nilaiPerolehanBaru');
        const nilaiHidden = document.getElementById('nilaiPerolehanHidden');

        const kondisiSelect = document.getElementById('kondisiBaru');
        const kondisiHidden = document.getElementById('kondisiBaruHidden');

        const VERIFIKASI_FINAL = window.STATUS_VERIFIKASI_FINAL;

        function today() {
            return new Date().toISOString().split('T')[0];
        }

        /* ======================
        STATUS PEMUGARAN
        ====================== */
        function handlePemugaranChange() {
            if (VERIFIKASI_FINAL) return;

            if (statusPemugaran.value === 'selesai') {
                tanggalSelesai.value = today();

                statusVerifikasi.disabled = false;
                statusVerifikasi.classList.remove('bg-gray-100','text-gray-400');

                buktiDokumentasi.required = true;
                laporanInput.required = true;
                laporanInput.disabled = false;
                buktiDokumentasi.readOnly = false;

            } else {
                tanggalSelesai.value = '';

                statusVerifikasi.value = 'menunggu';
                statusVerifikasiHidden.value = 'menunggu';
                statusVerifikasi.disabled = true;

                tanggalVerifikasi.value = '';

                buktiDokumentasi.required = false;
                laporanInput.required = false;
                laporanInput.disabled = true;
                buktiDokumentasi.readOnly = true;
            }
        }

        /* ======================
        STATUS VERIFIKASI
        ====================== */
        function handleVerifikasiChange() {
            if (VERIFIKASI_FINAL) return;

            statusVerifikasiHidden.value = statusVerifikasi.value;

            if (['ditolak','disetujui'].includes(statusVerifikasi.value)) {
                tanggalVerifikasi.value = today();
            } else {
                tanggalVerifikasi.value = '';
            }

            handleFinalApprovalField();
        }

        /* ======================
        FIELD KHUSUS DISETUJUI
        ====================== */
        function handleFinalApprovalField() {
            if (statusVerifikasi.value === 'disetujui') {

                nilaiInput.readOnly = false;
                kondisiSelect.disabled = false;

                nilaiInput.required = true;
                kondisiSelect.required = true;

                nilaiInput.classList.remove('bg-gray-100','text-gray-400','cursor-not-allowed');
                nilaiInput.classList.add('bg-white','text-gray-800');

                kondisiSelect.classList.remove('bg-gray-100','text-gray-400','cursor-not-allowed');
                kondisiSelect.classList.add('bg-white','text-gray-800');

            } else {

                nilaiInput.readOnly = true;
                kondisiSelect.disabled = true;

                nilaiInput.required = false;
                kondisiSelect.required = false;

                nilaiInput.value = '';
                kondisiSelect.value = '';
                nilaiHidden.value = '';
                kondisiHidden.value = '';

                nilaiInput.classList.add('bg-gray-100','text-gray-400','cursor-not-allowed');
                kondisiSelect.classList.add('bg-gray-100','text-gray-400','cursor-not-allowed');
            }
        }

        function handleDokumentasiRequirement(statusPemugaran) {

            if (statusPemugaran === 'selesai') {

                // WAJIB HANYA JIKA BELUM ADA DATA
                buktiDokumentasi.required = !hasBuktiDokumentasi;
                laporanInput.required = !hasLaporan;

                buktiDokumentasi.readOnly = false;
                laporanInput.disabled = false;

            } else {

                buktiDokumentasi.required = false;
                laporanInput.required = false;

                buktiDokumentasi.readOnly = true;
                laporanInput.disabled = true;
            }
        }

        /* ======================
        SYNC KE HIDDEN INPUT
        ====================== */
        nilaiInput.addEventListener('input', () => {
            nilaiHidden.value = nilaiInput.value;
        });

        kondisiSelect.addEventListener('change', () => {
            kondisiHidden.value = kondisiSelect.value;
        });

        statusPemugaran.addEventListener('change', handlePemugaranChange);
        statusVerifikasi.addEventListener('change', handleVerifikasiChange);

        /* ======================
        INIT
        ====================== */
        handlePemugaranChange();
        handleVerifikasiChange();
        handleDokumentasiRequirement(
            document.getElementById('statusPemugaran').value
        );
    });
</script>

@endsection
