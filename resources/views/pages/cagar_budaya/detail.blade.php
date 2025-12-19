@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('cagar_budaya.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
    </a>

    <div class="bg-white rounded-xl p-6 grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- KOLOM KIRI --}}
        <div class="md:col-span-2 space-y-4">

            {{-- FOTO --}}
            <div class="bg-white rounded-lg flex items-center justify-center overflow-hidden">
                @if($data->foto)
                    <img src="{{ asset('storage/'.$data->foto) }}"
                         alt="Foto Cagar Budaya"
                         class="object-cover w-full">
                @else
                    <span class="text-white text-sm">Tidak ada foto</span>
                @endif
            </div>

            {{-- DATA UTAMA --}}
            <div class="text-sm space-y-2">
                <div class="pb-3">
                    <p class="text-gray-500">Nomor Cagar Budaya</p>
                    <p class="font-medium">{{ $data->id_cagar_budaya }}</p>
                </div>

                <div class="pb-3">
                    <p class="text-gray-500">Nama Cagar Budaya</p>
                    <p class="font-medium">{{ $data->nama_cagar_budaya }}</p>
                </div>

                <div class="pb-3">
                    <p class="text-gray-500">Kategori</p>
                    <p class="font-medium">{{ ucfirst($data->kategori) }}</p>
                </div>

                <div class="pb-3">
                    <p class="text-gray-500">Lokasi</p>
                    <p class="font-medium">{{ $data->lokasi }}
                </div>

                <div class="pb-3">
                    <p class="text-gray-500">Status Kepemilikan</p>
                    <p class="font-medium">{{ ucfirst($data->status_kepemilikan) }}</p>
                </div>

                <div class="pb-3">
                    <p class="text-gray-500">Kondisi Cagar Budaya</p>
                    <p class="font-medium">{{ ucfirst($data->kondisi) }}</p>
                </div>
            </div>
        </div>

        {{-- KOLOM TENGAH & KANAN --}}
        <div class="md:col-span-2 space-y-4">

            {{-- TANGGAL --}}
            <div>
                <p class="text-gray-500">Tanggal Pencatatan</p>
                <div class="bg-white rounded-md py-2 text-sm font-medium">
                    {{ \Carbon\Carbon::parse($data->tanggal_pertama_pencatatan)->locale('id')->translatedFormat('l, d/m/Y') }}
                </div>
            </div>

            {{-- NILAI PEROLEHAN --}}
            <div>
                <p class="text-gray-500">Nilai Perolehan</p>
                <div class="bg-white rounded-md py-2 text-sm font-medium">
                    Rp {{ number_format($data->nilai_perolehan, 2, ',', '.') }}
                </div>
            </div>

            {{-- DOKUMEN KAJIAN --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <p class="text-sm text-gray-500">Dokumen Kajian</p>

                    @if($data->dokumen_kajian)
                        <a href="{{ asset('storage/'.$data->dokumen_kajian) }}"
                        target="_blank"
                        class="text-xs text-blue-600 hover:underline">
                            Buka penuh
                        </a>
                    @endif
                </div>

                <div class="bg-gray-300 rounded-lg h-80 overflow-hidden">
                    @if($data->dokumen_kajian)
                        @php
                            $path = asset('storage/'.$data->dokumen_kajian);
                            $ext  = strtolower(pathinfo($data->dokumen_kajian, PATHINFO_EXTENSION));
                        @endphp

                        @if($ext === 'pdf')
                            <iframe
                                src="{{ $path }}"
                                class="w-full h-full"
                                frameborder="0">
                            </iframe>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-700">
                                <span class="text-sm mb-1">Dokumen tersedia</span>
                                <a href="{{ $path }}" target="_blank"
                                class="text-xs text-blue-600 hover:underline">
                                    Buka dokumen
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-full flex items-center justify-center text-sm text-gray-500">
                            Tidak ada dokumen
                        </div>
                    @endif
                </div>
            </div>


            {{-- DESKRIPSI --}}
            <div>
                <p class="text-gray-500">Deskripsi</p>
                <div class="bg-gray-100 rounded-lg p-4 min-h-[120px] text-sm">
                    {{ $data->deskripsi }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
