@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('penghapusan.index') }}"
       class="inline-flex items-center text-gray-700 mb-6 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>


    <form action="{{ route('penghapusan.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">

            {{-- Kolom Kiri --}}
            <div class="space-y-4">

                {{-- Cagar Budaya --}}
                <div>
                    <label class="text-sm font-medium">Nama Cagar Budaya</label>
                    <select name="id_cagar_budaya" class="w-full mt-1 border rounded-md p-2">
                        <option value="">Pilih cagar budaya</option>
                        @foreach ($cagarBudaya as $cb)
                            <option value="{{ $cb->id_cagar_budaya }}">
                                {{ $cb->nama_cagar_budaya }}
                            </option>
                        @endforeach
                    </select>
                @error('id_cagar_budaya')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                </div>

                {{-- Penanggung Jawab --}}
                <div>
                    <label class="text-sm font-medium">Nama Penanggung Jawab</label>
                    <select name="id" class="w-full mt-1 border rounded-md p-2">
                        <option value="">Pilih penanggung jawab</option>
                        @foreach ($penanggungJawab as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                @error('id')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    
                @enderror
                </div>

                {{-- -Kondisi --}}
                <div>
                    <label class="text-sm font-medium">Kondisi</label>
                    <select name="kondisi" class="w-full mt-1 border rounded-md p-2">
                        <option value="">Pilih kondisi</option>
                        <option value="musnah">Musnah</option>
                        <option value="hilang">Hilang</option>
                        <option value="berubah wujud">Berubah Wujud</option>
                    </select>
                @error('kondisi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                </div>

                {{-- Bukti Dokumentasi (Link) --}}
                <div>
                    <label class="text-sm font-medium">Bukti Dokumentasi (Link Drive)</label>
                    <input type="url"
                        name="bukti_dokumentasi"
                        class="w-full mt-1 border rounded-md p-2"
                        placeholder="https://drive.google.com/...">
                    @error('bukti_dokumentasi')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>


            </div>

            {{-- Kolom Kanan --}}
            <div class="flex flex-col">
                <label class="text-sm font-medium mb-1">Alasan Penghapusan</label>
                <textarea name="alasan_penghapusan"
                    class="flex-1 border rounded-md p-3 resize-none"
                    placeholder="Masukkan alasan penghapusan..."></textarea>
                @error('alasan_penghapusan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="col-span-2 flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                    Ajukan
                </button>
            </div>

        </div>
    </form>

    <script>
        document.getElementById('dokumenUbah').addEventListener('click', function() {
          document.getElementById('dokumenInput').click();
        });

        document.getElementById('dokumenInput').addEventListener('change', function(e) {
          const file = e.target.files[0];
          if (file) {
            if (file.size > 5 * 1024 * 1024) {
                document.getElementById('dokumenWarning').classList.remove('hidden');
                document.getElementById('dokumenError').classList.add('hidden');
                document.getElementById('dokumenPreview').classList.add('hidden');
                document.getElementById('dokumenLabel').classList.remove('hidden');
                e.target.value = '';
            } else {
                document.getElementById('dokumenWarning').classList.add('hidden');
                document.getElementById('dokumenError').classList.add('hidden');
                document.getElementById('dokumenNama').textContent = file.name;
                document.getElementById('dokumenLabel').classList.add('hidden');
                document.getElementById('dokumenPreview').classList.remove('flex');
            }
          }
        });
    </script>
</div>
@endsection
