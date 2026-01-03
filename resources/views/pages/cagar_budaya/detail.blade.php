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
                    <p class="text-gray-500">Status Penetapan</p>
                    <p class="font-medium">{{ ucfirst($data->status_penetapan) }}</p>
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

    <div class="bg-white rounded-2xl my-8 p-6 shadow-sm">
        <h2 class="text-center text-2xl font-semibold text-gray-400 mb-6">
            Riwayat Pemugaran
        </h2>

        <div class="border rounded-lg overflow-hidden">
            <div class="max-h-[350px] overflow-y-auto">
                <table class="w-full text-sm text-left">
                    <thead class="sticky top-0 bg-white border-b">
                        <tr class="font-semibold text-gray-700">
                            <th class="px-4 py-3 w-12">No.</th>
                            <th class="px-4 py-3">Tipe Pemugaran</th>
                            <th class="px-4 py-3">Tanggal Selesai</th>
                            <th class="px-4 py-3">Biaya Pemugaran</th>
                            <th class="px-4 py-3">Status Pemugaran</th>
                            <th class="px-4 py-3">Status Verifikasi</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemugaran as $i => $item)
                            <tr class="{{ $i % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="px-4 py-3">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">{{ ucfirst($item->tipe_pemugaran) }}</td>
                                <td class="px-4 py-3">
                                    {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    Rp {{ number_format($item->biaya_pemugaran, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">{{ ucfirst($item->status_pemugaran) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs
                                        @if($item->status_verifikasi === 'disetujui') bg-green-100 text-green-700
                                        @elseif($item->status_verifikasi === 'ditolak') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif">
                                        {{ ucfirst($item->status_verifikasi) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('pemugaran.detail', $item->id_pemugaran) }}"
                                    class="py-1 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded"
                                    title="Detail Pemugaran">
                                        <i class="fas fa-circle-info"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-400 italic">
                                    Riwayat Pemugaran Tidak Tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="bg-white rounded-2xl my-8 p-6 shadow-sm">
        <h2 class="text-center text-2xl font-semibold text-gray-400 mb-6">
            Riwayat Mutasi
        </h2>

        <div class="border rounded-lg overflow-hidden">
            <div class="max-h-[350px] overflow-y-auto">
                <table class="w-full text-sm text-left">
                    <thead class="sticky top-0 bg-white border-b">
                        <tr class="font-semibold text-gray-700">
                            <th class="px-4 py-3 w-12">No.</th>
                            <th class="px-4 py-3">Kepemilikan</th>
                            <th class="px-4 py-3">Tanggal Pengajuan</th>
                            <th class="px-4 py-3">Status Mutasi</th>
                            <th class="px-4 py-3">Status Verifikasi</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mutasi as $i => $item)
                            <tr class="{{ $i % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="px-4 py-3">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">
                                    {{ ucfirst($item->kepemilikan_asal) }} → {{ ucfirst($item->kepemilikan_tujuan) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3">{{ ucfirst($item->status_mutasi) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs
                                        @if($item->status_verifikasi === 'disetujui') bg-green-100 text-green-700
                                        @elseif($item->status_verifikasi === 'ditolak') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif">
                                        {{ ucfirst($item->status_verifikasi) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('mutasi.detail', $item->id_mutasi) }}"
                                        class="py-1 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded"
                                        title="Detail">
                                            <i class="fas fa-circle-info"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-400 italic">
                                    Riwayat Mutasi Tidak Tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="bg-white rounded-2xl my-8 p-6 shadow-sm">
        <h2 class="text-center text-2xl font-semibold text-gray-400 mb-6">
            Riwayat Penghapusan
        </h2>

        <div class="border rounded-lg overflow-hidden">
            <div class="max-h-[350px] overflow-y-auto">
                <table class="w-full text-sm text-left">
                    <thead class="sticky top-0 bg-white border-b">
                        <tr class="font-semibold text-gray-700">
                            <th class="px-4 py-3 w-12">No.</th>
                            <th class="px-4 py-3">Kondisi</th>
                            <th class="px-4 py-3">Tanggal Penghapusan</th>
                            <th class="px-4 py-3">Alasan</th>
                            <th class="px-4 py-3">Status Penghapusan</th>
                            <th class="px-4 py-3">Status Verifikasi</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penghapusan as $i => $item)
                            <tr class="{{ $i % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="px-4 py-3">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">{{ ucfirst($item->kondisi) }}</td>
                                <td class="px-4 py-3">{{ ucfirst($item->tanggal_verifikasi) }}</td>
                                <td class="px-4 py-3 truncate max-w-xs">
                                    {{ $item->alasan_penghapusan }}
                                </td>
                                <td class="px-4 py-3">{{ ucfirst($item->status_penghapusan) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs
                                        @if($item->status_verifikasi === 'disetujui') bg-green-100 text-green-700
                                        @elseif($item->status_verifikasi === 'ditolak') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif">
                                        {{ ucfirst($item->status_verifikasi) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('penghapusan.detail', $item->id_penghapusan) }}"
                                    class="py-1 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded">
                                        <i class="fas fa-circle-info"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-400 italic">
                                    Riwayat Penghapusan Tidak Tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
