@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}"
       class="inline-flex items-center text-gray-700 mb-6 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <form action="{{ route('pemugaran.store') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl p-6 grid grid-cols-2 gap-6">

          {{-- Kolom Kiri --}}
          <div class="space-y-4">

            {{-- Nama Cagar Budaya --}}
            <div>
                <label class="text-sm font-medium">Nama Cagar Budaya</label>
                <select name="id_cagar_budaya" class="w-full mt-1 border rounded-md p-2">
                  <option value="">Pilih cagar budaya</option>
                  @foreach ($cagarBudaya as $cb)
                    <option value="{{ $cb->id_cagar_budaya }}">{{ $cb->nama_cagar_budaya }}</option>
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
                    <option value="{{ $user->id }}">{{ $user->nama }}</option>
                  @endforeach
                </select>
                @error('id')
                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kondisi --}}
            <div>
                <label class="text-sm font-medium">Kondisi Cagar Budaya</label>
                <select name="kondisi" class="w-full mt-1 border rounded-md p-2">
                  <option value="">Pilih kondisi</option>
                  <option value="Rusak Ringan">Rusak Ringan</option>
                  <option value="Rusak Berat">Rusak Berat</option>
                </select>
                @error('kondisi')
                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="text-sm font-medium">Tanggal Pengajuan</label>
                <input type="date" name="tanggal_pengajuan" class="w-full mt-1 border rounded-md p-2">
                @error('tanggal_pengajuan')
                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Biaya --}}
            <div>
                <label class="text-sm font-medium">Biaya Pemugaran</label>
                <input type="number" name="biaya_pemugaran" class="w-full mt-1 border rounded-md p-2">
                @error('biaya_pemugaran')
                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Proposal --}}
            <div>
                <label class="block text-sm font-medium mb-1">Proposal Pengajuan</label>
                <label class="flex items-center justify-center w-full px-3 py-3 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50"
                     id="dokumenLabel">
                  <i class="fas fa-paperclip text-2xl text-gray-400 mr-2"></i>
                  <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                  <input type="file" name="proposal_pengajuan" accept="application/pdf" class="hidden" id="dokumenInput">
                </label>
                <div id="dokumenPreview" class="hidden items-center justify-between w-full px-3 py-3 border-2 border-dashed rounded-lg bg-gray-50 mt-2">
                  <div class="flex items-center">
                    <i class="fas fa-file-pdf text-2xl text-red-500 mr-2"></i>
                    <span id="dokumenNama" class="text-sm text-gray-700"></span>
                  </div>
                  <button type="button" id="dokumenUbah" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Ubah</button>
                </div>
                <div id="dokumenWarning" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                  <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                  <span class="text-xs text-red-700">File terlalu besar. Maksimal ukuran 5 MB.</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">PDF, maksimal 5 MB</p>
                <div id="dokumenError" class="hidden text-red-500 text-xs mt-1"></div>
                @error('proposal_pengajuan')
                  <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
          </div>

          {{-- Kolom Kanan --}}
          <div class="flex flex-col h-full">
            <label class="text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi_pengajuan" class="flex-1 border rounded-md p-3 resize-none" placeholder="Masukkan deskripsi pengajuan..."></textarea>
            @error('deskripsi_pengajuan')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <div class="flex justify-end mt-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Ajukan</button>
            </div>
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
