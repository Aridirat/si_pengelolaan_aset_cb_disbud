@extends('layouts.main')

@section('content')
        <!-- CAGAR BUDAYA -->
        <div class="p-8 relative">
            <!-- CAGAR BUDAYA -->
            <section class="bg-linear-to-r from-blue-200 to-indigo-600 py-3 px-4 rounded-xl shadow-md shadow-indigo-300/50 mb-2 w-3/4 transition duration-300 ease-in-out hover:scale-102">
                <h2 class="text-sm font-bold mb-2 ">Cagar Budaya</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white py-2 px-2 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-sm text-left">Kondisi Baik</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['baik'] ?? 0 }}
                        </p>
                    </div>
                    <div class="bg-white py-2 px-2 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-sm text-left">Kondisi Rusak Ringan</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['rusak_ringan'] ?? 0 }}
                        </p>
                    </div>
                    <div class="bg-white py-2 px-2 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-sm text-left">Kondisi Rusak Berat</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['rusak_berat'] ?? 0 }}
                        </p>
                    </div>
                </div>
                <hr class="text-white my-5">
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white py-2 px-2 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-sm text-left"> Status Aktif</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['aktif'] ?? 0 }}
                        </p>
                    </div>
                    <div class="bg-white py-2 px-2 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-sm text-left">Status Terhapus</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['terhapus'] ?? 0 }}
                        </p>
                    </div>
                    <div class="bg-white py-2 px-2 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-sm text-left">Status Mutasi Keluar</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['mutasi keluar'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </section>


            <!-- MUTASI DATA -->
            <section class="bg-linear-to-r from-blue-200 to-indigo-600 py-3 px-4 rounded-xl shadow-md shadow-indigo-300/50 mb-2 w-115 transition duration-300 ease-in-out hover:scale-102">
                <h2 class="text-sm font-bold mb-2 ">Mutasi Data</h2>

                <div class="grid grid-cols-2 gap-4 items-center">
                    <!-- Total Mutasi -->
                    <div class="bg-white py-2 px-3 rounded-lg h-32 shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-sm text-left">Total Mutasi Data</p>
                        <p class="text-4xl font-bold mt-8 text-center">
                            {{ $totalMutasiData }}
                        </p>
                    </div>

                    <!-- Filter Field -->
                    <div class="flex flex-col bg-white p-2 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <label class="font-medium mb-2 text-sm text-left">
                            Filter Berdasarkan:
                        </label>

                        <el-dropdown class="inline-block">
                        {{-- Button --}}
                        <button
                            id="mutasiFieldButton"
                            class="inline-flex w-full justify-between items-center gap-x-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring-1 inset-ring-gray-300 transition duration-300 ease-in-out hover:scale-104 hover:text-indigo-900 border border-gray-50 hover:border-indigo-800 hover:bg-indigo-50"
                        >
                            {{ str_replace('_',' ', ucfirst(array_key_first($mutasiFieldCount))) }}
                            <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 hover:text-indigo-800">
                                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28Z"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <el-menu
                            anchor="bottom start"
                            popover
                            class="w-56 origin-top-left rounded-md bg-white shadow-lg outline-1 outline-black/5"
                        >
                            <div class="py-1">
                                @foreach ($mutasiFieldCount as $field => $total)
                                    <button
                                        type="button"
                                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                                        onclick="selectMutasiField('{{ $field }}', {{ $total }})"
                                    >
                                        {{ str_replace('_',' ', ucfirst($field)) }}
                                    </button>
                                @endforeach
                            </div>
                        </el-menu>
                    </el-dropdown>

                        <p id="mutasiFieldTotal" class="text-4xl font-bold text-right px-4">
                            {{ collect($mutasiFieldCount)->first() ?? 0 }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- PEMUGARAN -->
            <section class="bg-linear-to-r from-purple-200 to-fuchsia-800 py-3 px-4 rounded-xl shadow-md shadow-fuchsia-300/50 mb-2 transition duration-300 ease-in-out hover:scale-102">
                <h2 class="text-sm font-bold mb-2 ">Pemugaran</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['pending','diproses','selesai','menunggu','disetujui','ditolak'] as $status)
                    <div class="bg-white py-2 px-3 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-xs text-left">
                            Status {{ ucfirst($status) }}
                        </p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $pemugaran[$status] ?? 0 }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </section>


            <!-- MUTASI -->
            <section class="bg-linear-to-r from-purple-200 to-fuchsia-800 py-3 px-4 rounded-xl shadow-md shadow-fuchsia-300/50 mb-2 transition duration-300 ease-in-out hover:scale-102">
                <h2 class="text-sm  font-bold mb-2">Mutasi</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['pending','diproses','selesai','menunggu','disetujui','ditolak'] as $status)
                    <div class="bg-white py-2 px-3 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-xs text-left">
                            Status {{ ucfirst($status) }}
                        </p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $mutasiStatus[$status] ?? 0 }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- PENGHAPUSAN -->
            <section class="bg-linear-to-r from-purple-200 to-fuchsia-800 py-3 px-4 rounded-xl shadow-md shadow-fuchsia-300/50 mb-2 transition duration-300 ease-in-out hover:scale-102">
                <h2 class="text-sm font-bold mb-2 ">Penghapusan</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['pending','diproses','selesai','menunggu','disetujui','ditolak'] as $status)
                    <div class="bg-white py-2 px-3 rounded-lg shadow transition duration-300 ease-in-out hover:scale-105">
                        <p class="font-medium text-xs text-left">
                            Status {{ ucfirst($status) }}
                        </p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $penghapusan[$status] ?? 0 }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>

    </main>

</div>

<script>
    function selectMutasiField(field, total) {
        document.getElementById('mutasiFieldButton').childNodes[0].nodeValue =
            field.replaceAll('_', ' ').charAt(0).toUpperCase() + field.slice(1).replaceAll('_', ' ')

        document.getElementById('mutasiFieldTotal').innerText = total
    }
</script>

<script>
function updateMutasiField(field) {
    const option = document.querySelector(`option[value="${field}"]`);
    document.getElementById('mutasiFieldTotal').innerText =
        option.dataset.total ?? 0;
}
</script>




@endsection