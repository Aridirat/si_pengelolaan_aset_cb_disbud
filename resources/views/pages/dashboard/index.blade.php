@extends('layouts.main')

@section('content')
        <!-- CAGAR BUDAYA -->
        <div class="p-8 relative">
            <!-- CAGAR BUDAYA -->
            <section class="bg-linear-to-r from-blue-200 to-indigo-600 py-3 px-4 rounded-xl shadow mb-2 w-3/4">
                <h2 class="text-sm font-bold mb-2 ">Cagar Budaya</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white py-1 px-2 rounded-lg shadow">
                        <p class="font-medium text-sm text-left">Kondisi Baik</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['baik'] ?? 0 }}
                        </p>
                    </div>
                    <div class="bg-white py-2 px-3 rounded-lg shadow">
                        <p class="font-medium text-sm text-left">Kondisi Rusak Ringan</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['rusak_ringan'] ?? 0 }}
                        </p>
                    </div>
                    <div class="bg-white py-2 px-3 rounded-lg shadow">
                        <p class="font-medium text-sm text-left">Kondisi Rusak Berat</p>
                        <p class="text-3xl font-bold mt-2 text-center">
                            {{ $cagarBudaya['rusak_berat'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </section>


            <!-- MUTASI DATA -->
            <section class="bg-linear-to-r from-blue-200 to-indigo-600 py-3 px-4 rounded-xl shadow mb-2 w-115">
                <h2 class="text-sm font-bold mb-2 ">Mutasi Data</h2>

                <div class="grid grid-cols-2 gap-4 items-center">
                    <!-- Total Mutasi -->
                    <div class="bg-white py-2 px-3 rounded-lg h-32 shadow">
                        <p class="font-medium text-sm text-left">Total Mutasi Data</p>
                        <p class="text-4xl font-bold mt-8 text-center">
                            {{ array_sum($mutasiStatus->toArray()) }}
                        </p>
                    </div>

                    <!-- Filter Field -->
                    <div class="flex flex-col bg-white p-2 rounded-lg shadow">
                        <label class="font-medium mb-2 text-sm text-left">
                            Filter Berdasarkan:
                        </label>

                        <select
                            class="border border-gray-200 rounded w-40 text-sm text-left bg-white px-2 py-1 mb-4"
                            onchange="updateMutasiField(this.value)"
                        >
                            @foreach ($mutasiFieldCount as $field => $total)
                                <option value="{{ $field }}" data-total="{{ $total }}">
                                    {{ str_replace('_',' ', ucfirst($field)) }}
                                </option>
                            @endforeach
                        </select>

                        <p id="mutasiFieldTotal" class="text-4xl font-bold text-right px-4">
                            {{ collect($mutasiFieldCount)->first() ?? 0 }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- PEMUGARAN -->
            <section class="bg-linear-to-r from-purple-200 to-fuchsia-800 py-3 px-4 rounded-xl shadow mb-2">
                <h2 class="text-sm font-bold mb-2 ">Pemugaran</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['pending','diproses','selesai','menunggu','disetujui','ditolak'] as $status)
                    <div class="bg-white py-2 px-3 rounded-lg shadow">
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
            <section class="bg-linear-to-r from-purple-200 to-fuchsia-800 py-3 px-4 rounded-xl shadow mb-2">
                <h2 class="text-sm  font-bold mb-2">Mutasi</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['pending','diproses','selesai','menunggu','disetujui','ditolak'] as $status)
                    <div class="bg-white py-2 px-3 rounded-lg shadow">
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
            <section class="bg-linear-to-r from-purple-200 to-fuchsia-800 py-3 px-4 rounded-xl shadow mb-2">
                <h2 class="text-sm font-bold mb-2 ">Penghapusan</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['pending','diproses','selesai','menunggu','disetujui','ditolak'] as $status)
                    <div class="bg-white py-2 px-3 rounded-lg shadow">
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
function updateMutasiField(field) {
    const option = document.querySelector(`option[value="${field}"]`);
    document.getElementById('mutasiFieldTotal').innerText =
        option.dataset.total ?? 0;
}
</script>




@endsection