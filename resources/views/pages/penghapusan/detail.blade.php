@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('penghapusan.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    {{-- Card --}}
    <div class="bg-white rounded-xl p-6">

        {{-- Informasi Utama --}}
        <div class="grid grid-cols-4 gap-4 text-sm">
            <div class="col-span-2 space-y-6">
                <div>
                    <p class="text-gray-500">Nama Cagar Budaya</p>
                    <p class="font-medium">{{ $penghapusan->cagarBudaya->nama_cagar_budaya ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Nama Penanggung Jawab</p>
                    <p class="font-medium">{{ $penghapusan->user->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Kondisi</p>
                    <p class="font-medium">{{ $penghapusan->kondisi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Bukti Dokumentasi</p>
                    @if ($penghapusan->bukti_dokumentasi)
                        <a href="{{ $penghapusan->bukti_dokumentasi }}"
                           target="_blank"
                           class="text-blue-600 hover:underline">
                            {{ $penghapusan->bukti_dokumentasi }}
                        </a>
                    @else
                        -
                    @endif
                </div>
            </div>

            {{-- Alasan penghapusan --}}
            <div class="col-span-2">
                <p class="text-gray-500 text-sm mb-1">Alasan Penghapusan</p>
                <div class="bg-gray-100 rounded-lg p-4 text-sm h-54">
                    {{ $penghapusan->alasan_penghapusan ?? '-' }}
                </div>
            </div>
        </div>

        <hr class="my-6 text-gray-300">

        {{-- Status --}}
        <div class="grid grid-cols-9 gap-6 text-sm">
            <div class="col-span-2">
                <p class="text-gray-500">Status Penghapusan</p>
                @php
                            $statusPenghapusan = strtolower($penghapusan->status_penghapusan);

                            $warnaPenghapusan = match ($statusPenghapusan) {
                                'selesai'   => 'bg-green-100 text-green-700',
                                'diproses'  => 'bg-blue-100 text-blue-700',
                                'pending'   => 'bg-gray-100 text-gray-600',
                                default     => 'bg-gray-100 text-gray-600',
                            };
                        @endphp

                        <span class="px-3 py-1 mt-2 rounded-full text-xs font-semibold {{ $warnaPenghapusan }}">
                            {{ ucfirst($penghapusan->status_penghapusan ?? '-') }}
                        </span>
            </div>

            <div class="col-span-2">
                <p class="text-gray-500">Status Verifikasi</p>
                @php
                            $statusVerifikasi = strtolower($penghapusan->status_verifikasi);

                            $warnaVerifikasi = match ($statusVerifikasi) {
                                'disetujui' => 'bg-green-100 text-green-700',
                                'menunggu'  => 'bg-yellow-100 text-yellow-700',
                                'ditolak'   => 'bg-red-100 text-red-700',
                                default     => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warnaVerifikasi }}">
                            {{ ucfirst($penghapusan->status_verifikasi ?? '-') }}
                        </span>
            </div>

            <div class="col-span-2">
                <p class="text-gray-500">Tanggal Verifikasi</p>
                <p class="font-medium">
                    {{ $penghapusan->tanggal_verifikasi
                        ? \Carbon\Carbon::parse($penghapusan->tanggal_verifikasi)->format('d/m/Y')
                        : '-' }}
                </p>
            </div>

            {{-- Dokumen penghapusan --}}
            <div class="col-span-3">
                <p class="text-gray-500 text-sm mb-2">Dokumen Penghapusan</p>
    
                @if (!$penghapusan->dokumen_penghapusan)
                    <p class="text-sm italic text-gray-500">
                        File belum tersedia
                    </p>
                @else
                    <div class="border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                        <iframe
                            src="{{ asset("storage/{$penghapusan->dokumen_penghapusan}") }}"
                            class="w-full h-80"
                            frameborder="0">
                        </iframe>
                    </div>
    
                    <a href="{{ asset('storage/' . $penghapusan->dokumen_penghapusan) }}"
                       target="_blank"
                       class="inline-block mt-2 text-sm text-blue-600 hover:underline">
                        Lihat Dokumen
                    </a>
                @endif
            </div>
        </div>


    </div>
</div>
@endsection
