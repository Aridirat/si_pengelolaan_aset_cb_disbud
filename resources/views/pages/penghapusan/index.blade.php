@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Header --}}
    <h1 class="text-2xl font-semibold mb-4">Penghapusan</h1>

    <div class="bg-white p-6 rounded-lg">
        <div class="flex justify-between items-center mb-4">

            {{-- Toolbar --}}
            <div class="flex gap-2">
                <a href="{{ route('penghapusan.create') }}"
                   class="px-3 py-2 bg-sky-500 hover:bg-sky-700 text-white text-sm font-bold rounded-lg text-center shadow-md shadow-sky-500/30">
                    Ajukan Penghapusan
                </a>

                <a href="{{ route('penghapusan.cetak.pdf') }}"
                   class="px-3 py-2 bg-blue-500 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-md shadow-blue-500/30"
                   target="_blank">
                    Cetak Laporan
                </a>
            </div>

            {{-- Search --}}
            <form action="{{ route('penghapusan.index') }}" method="GET" class="d-flex">
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

                        {{-- Kondisi --}}
                        <th class="py-2 text-center relative">
                            <div class="flex justify-center items-center gap-1">
                                <span>Kondisi</span>
                                <button type="button" class="filter-toggle" data-target="filter-kondisi">
                                    <i class="fas fa-filter text-sky-500 hover:text-sky-700"></i>
                                </button>
                            </div>

                            <div id="filter-kondisi"
                                class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                                <form method="GET" class="p-3">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="status_penghapusan" value="{{ request('status_penghapusan') }}">

                                    @foreach (['musnah','hilang','berubah wujud'] as $kondisi)
                                        <label class="flex items-center gap-2 py-1">
                                            <input type="radio" name="kondisi" value="{{ $kondisi }}"
                                                {{ request('kondisi') == $kondisi ? 'checked' : '' }}>
                                            <span class="capitalize">{{ $kondisi }}</span>
                                        </label>
                                    @endforeach

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="kondisi" value="">
                                        <span>Semua</span>
                                    </label>

                                    <div class="mt-3 flex justify-between">
                                        <a href="{{ route('penghapusan.index') }}" class="text-gray-500 text-sm">Reset</a>
                                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                            Terapkan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </th>

                        {{-- Status penghapusan --}}
                        <th class="py-2 text-center relative">
                            <div class="flex justify-center items-center gap-1">
                                <span>Status Penghapusan</span>
                                <button type="button" class="filter-toggle" data-target="filter-status">
                                    <i class="fas fa-filter text-sky-500 hover:text-sky-700"></i>
                                </button>
                            </div>

                            <div id="filter-status"
                                 class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                                <form method="GET" class="p-3">
                                    @foreach (['pending','diproses','selesai'] as $status)
                                        <label class="flex items-center gap-2 py-1">
                                            <input type="radio" name="status_penghapusan" value="{{ $status }}"
                                                {{ request('status_penghapusan') == $status ? 'checked' : '' }}>
                                            <span class="capitalize">{{ $status }}</span>
                                        </label>
                                    @endforeach

                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="status_penghapusan" value="">
                                        <span>Semua</span>
                                    </label>

                                    <div class="mt-3 flex justify-between">
                                        <a href="{{ route('penghapusan.index') }}" class="text-gray-500 text-sm">Reset</a>
                                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                            Terapkan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </th>

                        <th class="py-2 text-center">Verifikasi</th>
                        <th class="py-2 text-center">Tanggal Verifikasi</th>
                        <th class="py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($penghapusan as $item)
                    <tr class="text-center hover:bg-gray-100">
                        <td class="py-2">{{ $loop->iteration }}</td>
                        <td class="py-2">{{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}</td>
                        <td class="py-2 capitalize">{{ $item->kondisi }}</td>
                        <td class="py-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $item->status_penghapusan == 'selesai' ? 'bg-green-100 text-green-700' :
                                   ($item->status_penghapusan == 'diproses' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                {{ ucfirst($item->status_penghapusan) }}
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
                                <a href="{{ route('penghapusan.detail', $item->id_penghapusan) }}"
                                   class="py-1 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded">
                                    <i class="fas fa-circle-info"></i>
                                </a>
                                <a href="{{ route('penghapusan.edit', $item->id_penghapusan) }}"
                                   class="py-1 px-2 bg-amber-500 hover:bg-amber-700 shadow-sm shadow-amber-400 text-white rounded">
                                    <i class="fas fa-pen"></i>
                                </a>

                                @php

                                $userRole = auth()->user()->role;
                                
                                @endphp
                               @if ($userRole === 'admin')
                                    <a href="{{ route('penghapusan.verifikasi', $item->id_penghapusan) }}"
                                    class="py-1 px-2 bg-indigo-500 hover:bg-indigo-700 shadow-sm shadow-indigo-400 text-white rounded">
                                        <i class="fa-regular fa-circle-check"></i>
                                    </a>
                                @else
                                    <div class="relative group">
                                        <button
                                            type="button"
                                            disabled
                                            class="py-1 px-2 bg-indigo-300 text-white rounded cursor-not-allowed opacity-60"
                                        >
                                            <i class="fa-regular fa-circle-check"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-lg py-4 text-gray-400 italic">
                            Data penghapusan tidak tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $penghapusan->links() }}
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
