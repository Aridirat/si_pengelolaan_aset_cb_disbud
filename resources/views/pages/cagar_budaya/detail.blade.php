@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('cagar_budaya.index') }}" class="flex items-center text-gray-700 mb-4 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
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
                    <span class="font-semibold">Nomor Cagar Budaya</span><br>
                    {{ $data->id_cagar_budaya }}
                </div>

                <div class="pb-3">
                    <span class="font-semibold">Nama Cagar Budaya</span><br>
                    {{ $data->nama_cagar_budaya }}
                </div>

                <div class="pb-3">
                    <span class="font-semibold">Kategori</span><br>
                    {{ ucfirst($data->kategori) }}
                </div>

                <div class="pb-3">
                    <span class="font-semibold">Lokasi</span><br>
                    {{ $data->lokasi }}
                </div>

                <div class="pb-3">
                    <span class="font-semibold">Status Kepemilikan</span><br>
                    {{ ucfirst($data->status_kepemilikan) }}
                </div>

                <div class="pb-3">
                    <span class="font-semibold">Kondisi Cagar Budaya</span><br>
                    {{ ucfirst($data->kondisi) }}
                </div>
            </div>
        </div>

        {{-- KOLOM TENGAH & KANAN --}}
        <div class="md:col-span-2 space-y-4">

            {{-- TANGGAL --}}
            <div>
                <span class="text-sm font-semibold">Tanggal Pencatatan</span>
                <div class="bg-white rounded-md px-3 py-2 text-sm">
                    {{ \Carbon\Carbon::parse($data->tanggal_pertama_pencatatan)->locale('id')->translatedFormat('l, d/m/Y') }}
                </div>
            </div>

            {{-- NILAI PEROLEHAN --}}
            <div>
                <span class="text-sm font-semibold">Nilai Perolehan</span>
                <div class="bg-white rounded-md px-3 py-2 text-sm">
                    Rp {{ number_format($data->nilai_perolehan, 2, ',', '.') }}
                </div>
            </div>

            {{-- DOKUMEN KAJIAN --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-semibold">Dokumen Kajian</span>

                    @if($data->dokumen_kajian)
                        <a href="{{ asset('storage/'.$data->dokumen_kajian) }}"
                        target="_blank"
                        class="text-xs text-blue-600 hover:underline">
                            Buka penuh
                        </a>
                    @endif
                </div>

                <div class="bg-gray-300 rounded-lg h-100 overflow-hidden">
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
                <span class="text-sm font-semibold">Deskripsi</span>
                <div class="bg-gray-100 rounded-lg p-4 min-h-[120px] text-sm">
                    {{ $data->deskripsi }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
