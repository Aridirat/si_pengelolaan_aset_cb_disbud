@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}"
       class="inline-flex items-center text-gray-700 mb-6 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <form action="{{ route('pemugaran.verifikasi.update', $pemugaran->id_pemugaran) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl p-6 space-y-4">

            {{-- Baris 1 --}}
            <div class="grid grid-cols-3 gap-4 pb-4">
                <div>
                    <label class="text-sm font-medium">Status Pemugaran</label>
                    <select name="status_pemugaran"
                            class="w-full mt-1 border rounded-md p-2">

                        @php
                            $currentStatusPemugaran =
                                old('status_pemugaran')
                                ?? $pemugaran->status_pemugaran
                                ?? 'pending';
                        @endphp

                        @foreach (['pending','diproses','selesai'] as $status)
                            <option value="{{ $status }}"
                                {{ $currentStatusPemugaran === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <label class="text-sm font-medium">Status Verifikasi</label>
                    <select name="status_verifikasi"
                            class="w-full mt-1 border rounded-md p-2">

                        @php
                            $currentStatusVerifikasi =
                                old('status_verifikasi')
                                ?? $pemugaran->status_verifikasi
                                ?? 'menunggu';
                        @endphp

                        @foreach (['menunggu','ditolak','disetujui'] as $status)
                            <option value="{{ $status }}"
                                {{ $currentStatusVerifikasi === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <label class="text-sm font-medium">Tanggal Verifikasi</label>
                    <input type="date"
                           name="tanggal_verifikasi"
                           value="{{ optional($pemugaran->tanggal_verifikasi)->format('Y-m-d') }}"
                           class="w-full mt-1 border rounded-md p-2">
                </div>
                @error('tanggal_verifikasi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            {{-- Baris 2 --}}
            <div class="grid grid-cols-3 gap-4 pt-3">
                <div>
                    <label class="text-sm font-medium">Tanggal Selesai</label>
                    <input type="date"
                           name="tanggal_selesai"
                           value="{{ optional($pemugaran->tanggal_selesai)->format('Y-m-d') }}"
                           class="w-full mt-1 border rounded-md p-2">
                </div>

                <div>
                    <label class="text-sm font-medium">Bukti Dokumentasi</label>
                    <input type="url"
                           name="bukti_dokumentasi"
                           value="{{ $pemugaran->bukti_dokumentasi }}"
                           placeholder="Link Google Drive Dokumentasi"
                           class="w-full mt-1 border rounded-md p-2">
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Laporan Pertanggungjawaban (PDF)
                    </label>
                    <input type="file"
                           name="laporan_pertanggungjawaban"
                           accept="application/pdf"
                           class="w-full mt-1 border rounded-md p-2">

                    @if ($pemugaran->laporan_pertanggungjawaban)
                        <p class="text-xs mt-1">
                            File saat ini:
                            <a href="{{ asset('storage/'.$pemugaran->laporan_pertanggungjawaban) }}"
                               target="_blank"
                               class="text-blue-600 underline">
                                Lihat Laporan
                            </a>
                        </p>
                    @endif
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="px-6 py-2 bg-green-500 hover:bg-green-700 text-white rounded-md">
                    Verifikasi
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
