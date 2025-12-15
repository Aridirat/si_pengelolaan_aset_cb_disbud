@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}"
       class="inline-flex items-center text-gray-700 mb-6 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <form action="{{ route('pemugaran.update', $pemugaran->id_pemugaran) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">

            {{-- Kolom Kiri --}}
            <div class="space-y-4">

                {{-- Nama Cagar Budaya --}}
                <div>
                    <label class="text-sm font-medium">Nama Cagar Budaya</label>
                    <select name="id_cagar_budaya" class="w-full mt-1 border rounded-md p-2">
                        @foreach ($cagarBudaya as $cb)
                            <option value="{{ $cb->id_cagar_budaya }}"
                                @selected($cb->id_cagar_budaya == $pemugaran->id_cagar_budaya)>
                                {{ $cb->nama_cagar_budaya }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Penanggung Jawab --}}
                <div>
                    <label class="text-sm font-medium">Nama Penanggung Jawab</label>
                    <select name="id" class="w-full mt-1 border rounded-md p-2">
                        @foreach ($penanggungJawab as $user)
                            <option value="{{ $user->id }}"
                                @selected($user->id == $pemugaran->id)>
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kondisi --}}
                <div>
                    <label class="text-sm font-medium">Kondisi Cagar Budaya</label>
                    <select name="kondisi" class="w-full mt-1 border rounded-md p-2">
                        @foreach (['Rusak Ringan','Rusak Sedang','Rusak Berat'] as $kondisi)
                            <option value="{{ $kondisi }}"
                                @selected($kondisi == $pemugaran->kondisi)>
                                {{ $kondisi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="text-sm font-medium">Tanggal Pengajuan</label>
                    <input type="date"
                           name="tanggal_pengajuan"
                           value="{{ $pemugaran->tanggal_pengajuan->format('Y-m-d') }}"
                           class="w-full mt-1 border rounded-md p-2">
                </div>

                {{-- Biaya --}}
                <div>
                    <label class="text-sm font-medium">Biaya Pemugaran</label>
                    <input type="number"
                           name="biaya_pemugaran"
                           value="{{ $pemugaran->biaya_pemugaran }}"
                           class="w-full mt-1 border rounded-md p-2">
                </div>

                {{-- Proposal --}}
                <div>
                    <label class="text-sm font-medium">Proposal Pengajuan</label>
                    <input type="file"
                        name="proposal_pengajuan"
                        accept="application/pdf"
                        class="w-full mt-1 border rounded-md p-2">
                    @if ($pemugaran->proposal_pengajuan)
                        <p class="text-xs mt-1">
                            File saat ini:
                            <a href="{{ asset('storage/'.$pemugaran->proposal_pengajuan) }}"
                               target="_blank"
                               class="text-blue-600 underline">
                                Lihat Proposal
                            </a>
                        </p>
                    @endif
                </div>

            </div>

            {{-- Kolom Kanan --}}
            <div class="flex flex-col h-full">
                <label class="text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi_pengajuan"
                          class="flex-1 border rounded-md p-3 resize-none">{{ $pemugaran->deskripsi_pengajuan }}</textarea>

                
            </div>
            <div class="flex justify-end mt-4 col-start-2">
                    <button type="submit"
                            class="px-6 py-2 bg-yellow-500 hover:bg-yellow-700 text-white rounded-md">
                        Simpan Perubahan
                    </button>
                </div>
            </div>

    </form>

</div>
@endsection
