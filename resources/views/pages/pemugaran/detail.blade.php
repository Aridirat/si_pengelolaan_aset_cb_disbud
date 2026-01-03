@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    {{-- Card --}}
    <div class="bg-white rounded-xl p-6">

        {{-- Informasi Utama --}}
        <div class="grid grid-cols-12 gap-4 text-sm">
            <div class="col-span-3 space-y-6">
                <div>
                    <p class="text-gray-500">Nama Cagar Budaya</p>
                    <p class="font-medium">{{ $pemugaran->cagarBudaya->nama_cagar_budaya ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Nama Penanggung Jawab</p>
                    <p class="font-medium">{{ $pemugaran->user->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Kondisi Cagar Budaya</p>
                    <p class="font-medium">{{ $pemugaran->kondisi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal Pengajuan</p>
                    <p class="font-medium">
                        {{ $pemugaran->tanggal_pengajuan
                            ? \Carbon\Carbon::parse($pemugaran->tanggal_pengajuan)->format('d/m/Y')
                            : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Tipe Pemugaran</p>
                    <p class="font-medium">{{ $pemugaran->tipe_pemugaran ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Biaya Pemugaran</p>
                    <p class="font-medium">
                        Rp {{ number_format($pemugaran->biaya_pemugaran ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Proposal Pengajuan --}}
            <div class="col-span-5">
                <p class="text-gray-500 text-sm mb-2">Proposal Pengajuan</p>
    
                @if (!$pemugaran->proposal_pengajuan)
                    <p class="text-sm italic text-gray-500">
                        File proposal belum tersedia
                    </p>
                @else
                    <div class="border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                        <iframe
                            src="{{ asset('storage/' . $pemugaran->proposal_pengajuan) }}"
                            class="w-full h-96"
                            frameborder="0">
                        </iframe>
                    </div>
    
                    <a href="{{ asset('storage/' . $pemugaran->proposal_pengajuan) }}"
                    target="_blank"
                    class="inline-block mt-2 text-sm text-blue-600 hover:underline">
                        Unduh Proposal
                    </a>
                @endif
            </div>

            {{-- Deskripsi --}}
            <div class="col-span-4">
                <p class="text-gray-500 text-sm mb-1">Deskripsi</p>
                <div class="bg-gray-100 rounded-lg p-4 text-sm h-96">
                    {{ $pemugaran->deskripsi_pengajuan ?? '-' }}
                </div>
            </div>

            
        </div>

        <hr class="my-6">

        {{-- Status --}}
        <div class="grid grid-cols-12 gap-6 text-sm">
            <div class="col-span-3">
                <p class="text-gray-500">Status Pemugaran</p>
                @php
                            $statusPemugaran = strtolower($pemugaran->status_pemugaran);

                            $warnaPemugaran = match ($statusPemugaran) {
                                'selesai'   => 'bg-green-100 text-green-700',
                                'diproses'  => 'bg-blue-100 text-blue-700',
                                'pending'   => 'bg-gray-100 text-gray-600',
                                default     => 'bg-gray-100 text-gray-600',
                            };
                        @endphp

                        <span class="px-3 py-1 mt-2 rounded-full text-xs font-semibold {{ $warnaPemugaran }}">
                            {{ ucfirst($pemugaran->status_pemugaran ?? '-') }}
                        </span>
            </div>

            <div class="col-span-4">
                <p class="text-gray-500">Status Verifikasi</p>
                @php
                            $statusVerifikasi = strtolower($pemugaran->status_verifikasi);

                            $warnaVerifikasi = match ($statusVerifikasi) {
                                'disetujui' => 'bg-green-100 text-green-700',
                                'menunggu'  => 'bg-yellow-100 text-yellow-700',
                                'ditolak'   => 'bg-red-100 text-red-700',
                                default     => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warnaVerifikasi }}">
                            {{ ucfirst($pemugaran->status_verifikasi ?? '-') }}
                        </span>
            </div>

            <div class="col-span-5">
                <p class="text-gray-500">Tanggal Verifikasi</p>
                <p class="font-medium">
                    {{ $pemugaran->tanggal_verifikasi
                        ? \Carbon\Carbon::parse($pemugaran->tanggal_verifikasi)->format('d/m/Y')
                        : '-' }}
                </p>
            </div>

        </div>
        <hr class="my-6">
        <div class="grid grid-cols-12 gap-6 text-sm">
            <div class="col-span-3">
                <p class="text-gray-500">Tanggal Selesai</p>
                <p class="font-medium">
                    {{ $pemugaran->tanggal_selesai
                        ? \Carbon\Carbon::parse($pemugaran->tanggal_selesai)->format('d/m/Y')
                        : '-' }}
                </p>
            </div>
            <div class="col-span-4">
                <p class="text-gray-500">Bukti Dokumentasi</p>
                <p class="font-medium">
                    @if ($pemugaran->bukti_dokumentasi)
                        <a href="{{ $pemugaran->bukti_dokumentasi }}"
                           target="_blank"
                           class="text-blue-600 hover:underline">
                            {{ $pemugaran->bukti_dokumentasi }}
                        </a>
                    @else
                        -
                    @endif
                </p>
            </div>

            {{-- Laporan Pertanggungjawaban --}}
            <div class="col-span-5">
                <p class="text-gray-500 text-sm mb-2">Laporan Pertanggungjawaban</p>
    
                @if (!$pemugaran->laporan_pertanggungjawaban)
                    <p class="text-sm italic text-gray-500">
                        File belum tersedia
                    </p>
                @else
                    <div class="border rounded-lg overflow-hidden bg-gray-50">
                        <iframe
                            src="{{ asset('storage/' . $pemugaran->laporan_pertanggungjawaban) }}"
                            class="w-full h-96"
                            frameborder="0">
                        </iframe>
                    </div>
    
                    <a href="{{ asset('storage/' . $pemugaran->laporan_pertanggungjawaban) }}"
                       target="_blank"
                       class="inline-block mt-2 text-sm text-blue-600 hover:underline">
                        Unduh Dokumen
                    </a>
                @endif
            </div>
        </div>


    </div>
</div>
@endsection
