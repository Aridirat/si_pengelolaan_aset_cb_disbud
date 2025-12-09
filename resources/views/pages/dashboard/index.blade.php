@extends('layouts.main')

@section('content')
        <!-- CAGAR BUDAYA -->
        <div class="p-8 relative">
            <section class="bg-white py-3 px-4 rounded-xl shadow mb-2 w-3/4">
                <h2 class="text-sm font-semibold mb-2">Cagar Budaya</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-blue-100 py-1 px-2 rounded-lg shadow">
                        <p class="font-medium text-sm text-left">Kondisi Baik</p>
                        <p class="text-3xl font-bold mt-2 text-center">10</p>
                    </div>
                    <div class="bg-blue-100 py-2 px-3 rounded-lg shadow text-left">
                        <p class="font-medium text-sm text-left">Kondisi Rusak Ringan</p>
                        <p class="text-3xl font-bold mt-2 text-center">10</p>
                    </div>
                    <div class="bg-blue-100 py-2 px-3 rounded-lg shadow text-left">
                        <p class="font-medium text-sm text-left">Kondisi Rusak Berat</p>
                        <p class="text-3xl font-bold mt-2 text-center">10</p>
                    </div>
                </div>
            </section>

            <!-- MUTASI DATA -->
            <section class="bg-white py-3 px-4 rounded-xl shadow mb-2 w-115">
                <h2 class="text-sm font-semibold mb-2">Mutasi Data</h2>
                <div class="grid grid-cols-2 gap-4 items-center">
                    <div class="bg-blue-100 py-2 px-3 rounded-lg shadow ">
                        <p class="font-medium text-sm text-left">Total Mutasi Data</p>
                        <p class="text-4xl font-bold mt-8 text-center">10</p>
                    </div>
                    <div class="flex flex-col bg-blue-100 p-2 rounded-lg shadow ">
                        <label class="font-medium mb-2 text-sm text-left">Filter Berdasarkan:</label>
                        <select class="border border-gray-300 rounded w-20 text-sm text-left">
                            <option>Field 1</option>
                            <option>Field 2</option>
                            <option>Field 3</option>
                        </select>
                        <p class="text-4xl font-bold text-right px-4">10</p>
                    </div>
                </div>
            </section>

            <!-- PEMUGARAN -->
            <section class="bg-white py-3 px-4 rounded-xl shadow mb-2">
                <h2 class="text-sm font-semibold mb-2">Pemugaran</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['Pending','Diproses','Selesai','Menunggu','Disetujui','Ditolak'] as $status)
                    <div class="bg-blue-100 py-2 px-3 rounded-lg shadow">
                        <p class="font-medium text-xs text-left">Status {{ $status }}</p>
                        <p class="text-3xl font-bold mt-2 text-center">10</p>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- MUTASI -->
            <section class="bg-white py-3 px-4 rounded-xl shadow mb-2">
                <h2 class="text-sm font-semibold mb-2">Mutasi</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['Pending','Diproses','Selesai','Menunggu','Disetujui','Ditolak'] as $status)
                    <div class="bg-blue-100 py-2 px-3 rounded-lg shadow">
                        <p class="font-medium text-xs text-left">Status {{ $status }}</p>
                        <p class="text-3xl font-bold mt-2 text-center">10</p>
                    </div>
                    @endforeach
                </div>
            </section>
            <!-- PENGHAPUSAN -->
            <section class="bg-white py-3 px-4 rounded-xl shadow mb-2">
                <h2 class="text-sm font-semibold mb-2">Penghapusan</h2>
                <div class="grid grid-cols-6 gap-4">
                    @foreach (['Pending','Diproses','Selesai','Menunggu','Disetujui','Ditolak'] as $status)
                    <div class="bg-blue-100 py-2 px-3 rounded-lg shadow">
                        <p class="font-medium text-xs text-left">Status {{ $status }}</p>
                        <p class="text-3xl font-bold mt-2 text-center">10</p>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>

    </main>

</div>




@endsection