@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('mutasi.index') }}"
       class="flex items-center text-gray-700 mb-4 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    {{-- Card --}}
    <div class="bg-white rounded-xl p-6">

        {{-- Informasi Utama --}}
        <div class="grid grid-cols-12 gap-4 text-sm">
            <div class="col-span-3 space-y-6">
                <div>
                    <p class="text-gray-500">Nama Cagar Budaya</p>
                    <p class="font-medium">{{ $mutasi->cagarBudaya->nama_cagar_budaya ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Nama Penanggung Jawab</p>
                    <p class="font-medium">{{ $mutasi->user->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Kepemilikan Asal</p>
                    <p class="font-medium">{{ $mutasi->kepemilikan_asal ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Kepemilikan Tujuan</p>
                    <p class="font-medium">{{ $mutasi->kepemilikan_tujuan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal Pengajuan</p>
                    <p class="font-medium">
                        {{ $mutasi->tanggal_pengajuan
                            ? \Carbon\Carbon::parse($mutasi->tanggal_pengajuan)->format('d/m/Y')
                            : '-' }}
                    </p>
                </div>
            </div>

            {{-- Proposal Pengajuan --}}
            <div class="col-span-5">
                <p class="text-gray-500 text-sm mb-2">Dokumen Pengajuan</p>
    
                @if (!$mutasi->dokumen_pengajuan)
                    <p class="text-sm italic text-gray-500">
                        File dokumen belum tersedia
                    </p>
                @else
                    <div class="border rounded-lg overflow-hidden bg-gray-50">
                        <iframe
                            src="{{ asset('storage/' . $mutasi->dokumen_pengajuan) }}"
                            class="w-full h-96"
                            frameborder="0">
                        </iframe>
                    </div>
    
                    <a href="{{ asset('storage/' . $mutasi->dokumen_pengajuan) }}"
                    target="_blank"
                    class="inline-block mt-2 text-sm text-blue-600 hover:underline">
                        Lihat dokumen
                    </a>
                @endif
            </div>

            {{-- keterangan --}}
            <div class="col-span-4">
                <p class="text-gray-500 text-sm mb-1">Keterangan</p>
                <div class="bg-gray-100 rounded-lg p-4 text-sm h-96">
                    {{ $mutasi->keterangan ?? '-' }}
                </div>
            </div>

            
        </div>
        <hr class="my-6">
        {{-- Status --}}
        <div class="grid grid-cols-9 gap-6 text-sm">
            <div class="col-span-2">
                <p class="text-gray-500">Status Mutasi</p>
                @php
                            $statusMutasi = strtolower($mutasi->status_mutasi);

                            $warnaMutasi = match ($statusMutasi) {
                                'selesai'   => 'bg-green-100 text-green-700',
                                'diproses'  => 'bg-blue-100 text-blue-700',
                                'pending'   => 'bg-gray-100 text-gray-600',
                                default     => 'bg-gray-100 text-gray-600',
                            };
                        @endphp

                        <span class="px-3 py-1 mt-2 rounded-full text-xs font-semibold {{ $warnaMutasi }}">
                            {{ ucfirst($mutasi->status_mutasi ?? '-') }}
                        </span>
            </div>

            <div class="col-span-2">
                <p class="text-gray-500">Status Verifikasi</p>
                @php
                            $statusVerifikasi = strtolower($mutasi->status_verifikasi);

                            $warnaVerifikasi = match ($statusVerifikasi) {
                                'disetujui' => 'bg-green-100 text-green-700',
                                'menunggu'  => 'bg-yellow-100 text-yellow-700',
                                'ditolak'   => 'bg-red-100 text-red-700',
                                default     => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warnaVerifikasi }}">
                            {{ ucfirst($mutasi->status_verifikasi ?? '-') }}
                        </span>
            </div>

            <div class="col-span-2">
                <p class="text-gray-500">Tanggal Verifikasi</p>
                <p class="font-medium">
                    {{ $mutasi->tanggal_verifikasi
                        ? \Carbon\Carbon::parse($mutasi->tanggal_verifikasi)->format('d/m/Y')
                        : '-' }}
                </p>
            </div>

            {{-- Dokumen Pengesahan --}}
            <div class="col-span-3">
                <p class="text-gray-500 text-sm mb-2">Dokumen Pengesahan</p>
    
                @if (!$mutasi->dokumen_pengesahan)
                    <p class="text-sm italic text-gray-500">
                        File belum tersedia
                    </p>
                @else
                    <div class="border rounded-lg overflow-hidden bg-gray-50">
                        <iframe
                            src="{{ asset("storage/{$mutasi->dokumen_pengesahan}") }}"
                            class="w-full h-80"
                            frameborder="0">
                        </iframe>
                    </div>
    
                    <a href="{{ asset('storage/' . $mutasi->dokumen_pengesahan) }}"
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
