@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Header --}}
    <h1 class="text-2xl font-semibold mb-4">Mutasi</h1>

    <div class="bg-white p-6 rounded-lg">
        <div class="flex justify-between items-center mb-4">

            {{-- Toolbar --}}
            <div class="flex gap-2">
                <a href="{{ route('mutasi.create') }}"
                   class="px-3 py-2 bg-sky-500 hover:bg-sky-700 text-white text-sm font-bold rounded-lg text-center shadow-md shadow-sky-500/30">
                    Ajukan Mutasi
                </a>

                <a href="{{ route('mutasi.cetak.pdf', request()->query()) }}"
                   class="px-3 py-2 bg-blue-500 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-md shadow-blue-500/30"
                   target="_blank">
                    Cetak Laporan
                </a>
            </div>

            {{-- Search --}}
            <form action="{{ route('mutasi.index') }}" method="GET" class="d-flex">
                <div class="input-group relative">
                    <span class="input-group-text absolute left-2 top-1">
                    <i class="fa-solid fa-magnifying-glass text-gray-300 text-xl"></i>
                    </span>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-1 shadow border border-gray-300 rounded-lg placeholder:text-gray-500 focus:outline-indigo-500 placeholder:italic" placeholder="Cari..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        {{-- Table --}}
       
            <table class="w-full text-xs border-collapse">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="py-2 text-center">No.</th>
                        <th class="py-2 text-center">Cagar Budaya</th>

                        {{-- Pemilik Asal --}}
                        <th class="py-2 text-center relative">
                            <div class="flex justify-center items-center gap-1">
                                <span>Pemilik Asal</span>
                                <button type="button" class="filter-toggle" data-target="filter-asal">
                                    <i class="fas fa-filter text-sky-500 hover:text-sky-700"></i>
                                </button>
                            </div>

                            <div id="filter-asal"
                                 class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                                <form method="GET" class="p-3">
                                    <input type="hidden" name="kepemilikan_asal" value="{{ request('kepemilikan_asal') }}">
                                    <input type="hidden" name="status_mutasi" value="{{ request('status_mutasi') }}">

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="kepemilikan_asal" value="pemerintah"
                                            {{ request('kepemilikan_asal') == 'pemerintah' ? 'checked' : '' }}>
                                        <span>Pemerintah</span>
                                    </label>

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="kepemilikan_asal" value="pribadi"
                                            {{ request('kepemilikan_asal') == 'pribadi' ? 'checked' : '' }}>
                                        <span>Pribadi</span>
                                    </label>

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="kepemilikan_asal" value="">
                                        <span>Semua</span>
                                    </label>

                                    <div class="mt-3 flex justify-between">
                                        <a href="{{ route('mutasi.index') }}" class="text-gray-500 text-sm">Reset</a>
                                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                            Terapkan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </th>

                        {{-- Pemilik Tujuan --}}
                        <th class="py-2 text-center relative">
                            <div class="flex justify-center items-center gap-1">
                                <span>Pemilik Tujuan</span>
                                <button type="button" class="filter-toggle" data-target="filter-tujuan">
                                    <i class="fas fa-filter text-sky-500 hover:text-sky-700"></i>
                                </button>
                            </div>

                            <div id="filter-tujuan"
                                 class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                                <form method="GET" class="p-3">
                                    <input type="hidden" name="kepemilikan_tujuan" value="{{ request('kepemilikan_tujuan') }}">
                                    <input type="hidden" name="status_mutasi" value="{{ request('status_mutasi') }}">

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="kepemilikan_tujuan" value="pemerintah"
                                            {{ request('kepemilikan_tujuan') == 'pemerintah' ? 'checked' : '' }}>
                                        <span>Pemerintah</span>
                                    </label>

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="kepemilikan_tujuan" value="pribadi"
                                            {{ request('kepemilikan_tujuan') == 'pribadi' ? 'checked' : '' }}>
                                        <span>Pribadi</span>
                                    </label>

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="kepemilikan_tujuan" value="">
                                        <span>Semua</span>
                                    </label>

                                    <div class="mt-3 flex justify-between">
                                        <a href="{{ route('mutasi.index') }}" class="text-gray-500 text-sm">Reset</a>
                                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                            Terapkan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </th>

                        <th class="py-2 text-center">Tanggal Pengajuan</th>

                        {{-- Status Mutasi --}}
                        <th class="py-2 text-center relative">
                            <div class="flex justify-center items-center gap-1">
                                <span>Status Mutasi</span>
                                <button type="button" class="filter-toggle" data-target="filter-status">
                                    <i class="fas fa-filter text-sky-500 hover:text-sky-700"></i>
                                </button>
                            </div>

                            <div id="filter-status"
                                 class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                                <form method="GET" class="p-3">
                                    @foreach (['pending','diproses','selesai'] as $status)
                                        <label class="flex items-center gap-2 py-1">
                                            <input type="radio" name="status_mutasi" value="{{ $status }}"
                                                {{ request('status_mutasi') == $status ? 'checked' : '' }}>
                                            <span class="capitalize">{{ $status }}</span>
                                        </label>
                                    @endforeach

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="status_mutasi" value="">
                                        <span>Semua</span>
                                    </label>

                                    <div class="mt-3 flex justify-between">
                                        <a href="{{ route('mutasi.index') }}" class="text-gray-500 text-sm">Reset</a>
                                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                            Terapkan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </th>

                        {{-- Status Verifikasi --}}
                        <th class="py-2 text-center relative">
                            <div class="flex justify-center items-center gap-1">
                                <span>Verifikasi</span>
                                <button type="button" class="filter-toggle" data-target="filter-status-verifikasi">
                                    <i class="fas fa-filter text-sky-500 hover:text-sky-700"></i>
                                </button>
                            </div>

                            <div id="filter-status-verifikasi"
                                 class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                                <form method="GET" class="p-3">
                                    @foreach (['menunggu','ditolak','disetujui'] as $status)
                                        <label class="flex items-center gap-2 py-1">
                                            <input type="radio" name="status_verifikasi" value="{{ $status }}"
                                                {{ request('status_verifikasi') == $status ? 'checked' : '' }}>
                                            <span class="capitalize">{{ $status }}</span>
                                        </label>
                                    @endforeach

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="status_verifikasi" value="">
                                        <span>Semua</span>
                                    </label>

                                    <div class="mt-3 flex justify-between">
                                        <a href="{{ route('mutasi.index') }}" class="text-gray-500 text-sm">Reset</a>
                                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                            Terapkan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </th>

                        <th class="py-2 text-center">Tanggal Verifikasi</th>
                        <th class="py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($mutasi as $item)
                    <tr class="text-center hover:bg-gray-100">
                        <td class="py-2">{{ $loop->iteration }}</td>
                        <td class="py-2">{{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}</td>
                        <td class="py-2 capitalize">{{ $item->kepemilikan_asal }}</td>
                        <td class="py-2 capitalize">{{ $item->kepemilikan_tujuan }}</td>
                        <td class="py-2">
                            {{ $item->tanggal_pengajuan?->parse($item->tanggal_pengajuan)->locale('id')->translatedFormat('l, d/m/Y') ?? '-' }}
                        </td>
                        <td class="py-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $item->status_mutasi == 'selesai' ? 'bg-green-100 text-green-700' :
                                   ($item->status_mutasi == 'diproses' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                {{ ucfirst($item->status_mutasi) }}
                            </span>
                        </td>
                        <td class="py-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $item->status_verifikasi == 'disetujui' ? 'bg-green-100 text-green-700' :
                                   ($item->status_verifikasi == 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($item->status_verifikasi) }}
                            </span>
                        <td class="py-2">
                            {{ $item->tanggal_verifikasi?->parse($item->tanggal_verifikasi)->locale('id')->translatedFormat('l, d/m/Y') ?? '-' }}
                        </td>
                        <td class="py-2">
                            <div class="flex justify-center gap-1">

                                {{-- DETAIL (SELALU AKTIF) --}}
                                <a href="{{ route('mutasi.detail', $item->id_mutasi) }}"
                                class="py-1 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded"
                                title="Detail">
                                    <i class="fas fa-circle-info"></i>
                                </a>

                                {{-- EDIT --}}
                                @if (in_array($item->status_mutasi, ['diproses','selesai']))
                                    <button
                                        type="button"
                                        disabled
                                        class="py-1 px-2 bg-amber-300 text-white rounded cursor-not-allowed opacity-60"
                                        title="Tidak dapat diedit karena status mutasi {{ $item->status_mutasi }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                @else
                                    <a href="{{ route('mutasi.edit', $item->id_mutasi) }}"
                                    class="py-1 px-2 bg-amber-500 hover:bg-amber-700 shadow-sm shadow-amber-400 text-white rounded"
                                    title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                @endif

                                {{-- VERIFIKASI --}}
                                @php
                                    $userRole = auth()->user()->role;
                                @endphp

                                @if ($userRole === 'admin')
                                    @if (in_array($item->status_verifikasi, ['disetujui','ditolak']))
                                        <button
                                            type="button"
                                            disabled
                                            class="py-1 px-2 bg-indigo-300 text-white rounded cursor-not-allowed opacity-60"
                                            title="Verifikasi sudah final">
                                            <i class="fa-regular fa-circle-check"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('mutasi.verifikasi', $item->id_mutasi) }}"
                                        class="py-1 px-2 bg-indigo-500 hover:bg-indigo-700 shadow-sm shadow-indigo-400 text-white rounded"
                                        title="Verifikasi">
                                            <i class="fa-regular fa-circle-check"></i>
                                        </a>
                                    @endif
                                @else
                                    <button
                                        type="button"
                                        disabled
                                        class="py-1 px-2 bg-indigo-300 text-white rounded cursor-not-allowed opacity-60"
                                        title="Hanya admin yang dapat melakukan verifikasi">
                                        <i class="fa-regular fa-circle-check"></i>
                                    </button>
                                @endif

                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-lg py-4 text-gray-400 italic">
                            Data mutasi tidak tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $mutasi->links() }}
        </div>
    </div>
</div>

{{-- Script Filter --}}
<script>
document.querySelectorAll('.filter-toggle').forEach(button => {
    button.addEventListener('click', function (e) {
        e.stopPropagation();

        const target = document.getElementById(this.dataset.target);

        document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
            if (dropdown !== target) dropdown.classList.add('hidden');
        });

        target.classList.toggle('hidden');
    });
});

document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
    dropdown.addEventListener('click', function (e) {
        e.stopPropagation();
    });
});

document.addEventListener('click', function () {
    document.querySelectorAll('.filter-dropdown')
        .forEach(dropdown => dropdown.classList.add('hidden'));
});
</script>
@endsection
