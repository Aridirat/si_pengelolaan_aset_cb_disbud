@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Kembali --}}
    <a href="{{ route('pemugaran.index') }}" class="flex items-center font-semibold text-neutral-700 mb-4 hover:text-neutral-900">
        <i class="fas fa-angle-left"></i> Kembali
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
                <select
                    name="id_cagar_budaya"
                    id="cagarBudayaSelect"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2"
                >
                    <option value="">Pilih cagar budaya</option>
                    @foreach ($cagarBudaya as $cb)
                        <option
                            value="{{ $cb->id_cagar_budaya }}"
                            data-kondisi="{{ strtolower($cb->kondisi) }}"
                        >
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
                <select name="id" class="w-full mt-1 border border-gray-300 rounded-md p-2">
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

                {{-- Input tampilan --}}
                <input
                    type="text"
                    id="kondisi_display"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2 bg-gray-100 cursor-not-allowed"
                    placeholder="Kondisi akan terisi otomatis"
                    readonly
                >

                {{-- Hidden input untuk backend --}}
                <input type="hidden" name="kondisi" id="kondisi">

                @error('kondisi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>



            {{-- Tanggal --}}
            <div>
                <label class="text-sm font-medium">Tanggal Pengajuan</label>
                <input type="date" name="tanggal_pengajuan" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                @error('tanggal_pengajuan')
                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Biaya --}}
            <div>
                <label class="text-sm font-medium">Biaya Pemugaran</label>
                <input type="number" name="biaya_pemugaran" placeholder="Rp" class="w-full mt-1 border border-gray-300 rounded-md p-2">
                @error('biaya_pemugaran')
                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Proposal --}}
              <div>
                  <label class="block text-sm font-medium mb-1">
                      Proposal Pengajuan
                  </label>
                  <label class="flex items-center justify-center w-full px-3 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50"
                          id="dokumenLabel">
                      <i class="fas fa-paperclip text-2xl text-gray-400 mr-2"></i>
                      <span class="text-sm text-gray-500">Klik untuk menambah dokumen</span>
                      <input type="file"
                              name="proposal_pengajuan"
                              accept="application/pdf"
                              class="hidden"
                              id="dokumenInput">
                  </label>
                  <div id="dokumenPreview" class="hidden flex items-center justify-between w-full px-3 py-3 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mt-2">
                      <div class="flex items-center">
                          <i class="fas fa-file-pdf text-2xl text-red-500 mr-2"></i>
                          <span id="dokumenNama" class="text-sm text-gray-700"></span>
                      </div>
                      <button type="button"
                              id="dokumenUbah"
                              class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                          Ubah
                      </button>
                  </div>
                  <div id="dokumenWarning" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg flex items-start">
                      <i class="fas fa-exclamation-triangle text-red-600 mr-2 mt-0.5"></i>
                      <span class="text-xs text-red-700">File terlalu besar. Maksimal ukuran 5 MB.</span>
                  </div>
                  <p class="text-xs text-gray-500 mt-1">
                      PDF, maksimal 5 MB
                  </p>
                  <div id="dokumenError" class="hidden text-red-500 text-xs mt-1"></div>
                  @error('proposal_pengajuan')
                      <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                  @enderror
              </div>

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
                              document.getElementById('dokumenPreview').classList.remove('hidden');
                          }
                      }
                  });
              </script>
          </div>

          {{-- Kolom Kanan --}}
          <div class="flex flex-col h-full">
            <label class="text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi_pengajuan" class="flex-1 border border-gray-300 rounded-md p-3 resize-none" placeholder="Masukkan deskripsi pengajuan..."></textarea>
            @error('deskripsi_pengajuan')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

          </div>
          <div class="col-span-2 flex justify-end mt-4">
              <button type="submit" class="btn px-6 py-2 bg-sky-500 hover:bg-sky-700 shadow shadow-sky-400 text-white rounded-lg font-semibold">Ajukan</button>
          </div>
        </div>
    </form>

</div>

<script>
document.getElementById('cagarBudayaSelect').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const kondisi = selectedOption.getAttribute('data-kondisi');

    // Set nilai ke select tampilan
    document.getElementById('kondisi_display').value = kondisi ?? '';

    // Set nilai ke hidden input (untuk dikirim ke server)
    document.getElementById('kondisi').value = kondisi ?? '';
});
</script>

@endsection
