@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('penghapusan.index') }}"
       class="inline-flex items-center text-gray-700 mb-6 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>


    <form action="{{ route('penghapusan.update', $penghapusan->id_penghapusan) }}"
          method="POST">
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
                                {{ $penghapusan->id_cagar_budaya == $cb->id_cagar_budaya ? 'selected' : '' }}>
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
                                {{ $penghapusan->id == $user->id ? 'selected' : '' }}>
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- -Kondisi --}}
                <div>
                    <label class="text-sm font-medium">Kondisi</label>
                    <select name="kondisi" class="w-full mt-1 border rounded-md p-2">
                        <option value="musnah" {{ $penghapusan->kondisi == 'musnah' ? 'selected' : '' }}>
                            Musnah
                        </option>
                        <option value="hilang" {{ $penghapusan->kondisi == 'hilang' ? 'selected' : '' }}>
                            Hilang
                        </option>
                        <option value="berubah wujud" {{ $penghapusan->kondisi == 'berubah wujud' ? 'selected' : '' }}>
                            Berubah Wujud
                        </option>
                    </select>
                </div>

                {{-- Bukti Dokumentasi (Link) --}}
                <div>
                    <label class="text-sm font-medium">Bukti Dokumentasi</label>
                    <input type="text" name="bukti_dokumentasi"
                        class="w-full mt-1 border rounded-md p-2"
                        value="{{ old('bukti_dokumentasi', $penghapusan->bukti_dokumentasi) }}"
                        placeholder="Masukkan link bukti dokumentasi...">
                </div>


            </div>

            {{-- Kolom Kanan --}}
            <div class="flex flex-col">
                <label class="text-sm font-medium mb-1">Alasan Penghapusan</label>
                <textarea name="alasan_penghapusan"
                    class="flex-1 border rounded-md p-3 resize-none"
                    placeholder="Masukkan alasan penghapusan...">{{ old('alasan_penghapusan', $penghapusan->alasan_penghapusan) }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="col-span-2 flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-yellow-500 hover:bg-yellow-700 text-white rounded-md">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
