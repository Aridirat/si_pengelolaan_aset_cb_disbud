@extends('layouts.main')

@section('content')
<div class="px-6 py-6">

    {{-- Header --}}
    <h1 class="text-2xl font-semibold mb-4">Pemugaran</h1>

    <div class="bg-white p-6 rounded-lg">
        <div class="flex justify-between items-center mb-4">
        <div class="flex gap-2">
            <a href="{{ route('pemugaran.create') }}" class="px-3 py-2 bg-sky-500 hover:bg-sky-700 text-white text-sm font-bold rounded-lg text-center shadow-md shadow-sky-500/30">
                Ajukan Pemugaran
            </a>
            <a href="{{ route('pemugaran.cetak.pdf') }}" class="px-3 py-2 bg-blue-500 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-md shadow-blue-500/30" target="_blank">
                Cetak Laporan
            </a>
        </div>

        {{-- Search --}}
        <form action="{{ route('pemugaran.index') }}" method="GET" class="d-flex">
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
                    <th class="py-2 text-center relative">
                        <div class="flex items-center gap-0.5 justify-center">
                            <span>Kondisi</span>

                            <button type="button"
                                class="filter-toggle text-sky-500 hover:text-sky-700"
                                data-target="filter-kondisi">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>

                        {{-- Dropdown Filter Kondisi --}}
                        <div id="filter-kondisi"
                            class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                            <form method="GET" class="p-3">
                                {{-- Pertahankan filter lain --}}
                                <input type="hidden" name="status_pemugaran" value="{{ request('status_pemugaran') }}">

                                <div class="text-sm font-medium mb-2">Pilih Kondisi</div>

                                <label class="flex items-center gap-2 py-1">
                                    <input type="radio" name="kondisi" value="Rusak Ringan"
                                        {{ request('kondisi') == 'Rusak Ringan' ? 'checked' : '' }}>
                                    <span class="text-sm">Rusak Ringan</span>
                                </label>

                                <label class="flex items-center gap-2 py-1">
                                    <input type="radio" name="kondisi" value="Rusak Berat"
                                        {{ request('kondisi') == 'Rusak Berat' ? 'checked' : '' }}>
                                    <span class="text-sm">Rusak Berat</span>
                                </label>

                                <label class="flex items-center gap-2 py-1">
                                    <input type="radio" name="kondisi" value=""
                                        {{ request('kondisi') === null || request('kondisi') === '' ? 'checked' : '' }}>
                                    <span class="text-sm">Semua</span>
                                </label>


                                <div class="mt-3 flex justify-between">
                                    <a href="{{ route('pemugaran.index', ['status_pemugaran' => request('status_pemugaran')]) }}"
                                    class="text-sm text-gray-600">
                                        Reset
                                    </a>
                                    <button type="submit"
                                            class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                        Terapkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </th>

                    <th class="py-2 text-center">Tanggal Pengajuan</th>

                    <th class="py-2 text-center relative">
                        <div class="flex items-center gap-0.5 justify-center">
                            <span>Status Pemugaran</span>

                            <button type="button"
                                class="filter-toggle text-sky-500 hover:text-sky-700"
                                data-target="filter-status">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>

                        {{-- Dropdown Filter Status --}}
                        <div id="filter-status"
                            class="filter-dropdown hidden absolute mt-2 bg-white border rounded shadow z-40 w-44">
                            <form method="GET" class="p-3">
                                {{-- Pertahankan filter lain --}}
                                <input type="hidden" name="kondisi" value="{{ request('kondisi') }}">

                                <div class="text-sm font-medium mb-2">Status Pemugaran</div>

                                @foreach (['pending','diproses','selesai'] as $status)
                                    <label class="flex items-center gap-2 py-1">
                                        <input type="radio" name="status_pemugaran"
                                            value="{{ $status }}"
                                            {{ request('status_pemugaran') == $status ? 'checked' : '' }}>
                                        <span class="text-sm capitalize">{{ $status }}</span>
                                    </label>
                                @endforeach

                                <label class="flex items-center gap-2 py-1">
                                    <input type="radio" name="status_pemugaran" value=""
                                        {{ request('status_pemugaran') === null || request('status_pemugaran') === '' ? 'checked' : '' }}>
                                    <span class="text-sm">Semua</span>
                                </label>


                                <div class="mt-3 flex justify-between">
                                    <a href="{{ route('pemugaran.index', ['kondisi' => request('kondisi')]) }}"
                                    class="text-sm text-gray-600">
                                        Reset
                                    </a>
                                    <button type="submit"
                                            class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                        Terapkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </th>


                    <th class="py-2 text-center">Verifikasi</th>
                    <th class="py-2 text-center">Tanggal Selesai</th>
                    <th class="py-2 text-center">Biaya Pemugaran</th>
                    <th class="py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemugaran as $item)
                <tr class="text-center hover:bg-gray-100">
                    <td class="py-2">{{ $loop->iteration }}</td>
                    <td class="py-2">
                        {{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}
                    </td>
                    <td class="py-2">{{ $item->kondisi }}</td>
                    <td class="py-2">
                        {{ $item->tanggal_pengajuan?->parse($item->tanggal_pengajuan)->locale('id')->translatedFormat('l, d/m/Y') }}
                    </td>
                    <td class="py-2">
                        @php
                            $statusPemugaran = strtolower($item->status_pemugaran);

                            $warnaPemugaran = match ($statusPemugaran) {
                                'selesai'   => 'bg-green-100 text-green-700',
                                'diproses'  => 'bg-blue-100 text-blue-700',
                                'pending'   => 'bg-gray-100 text-gray-600',
                                default     => 'bg-gray-100 text-gray-600',
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warnaPemugaran }}">
                            {{ ucfirst($item->status_pemugaran) }}
                        </span>
                    </td>

                    <td class="py-2">
                        @php
                            $statusVerifikasi = strtolower($item->status_verifikasi);

                            $warnaVerifikasi = match ($statusVerifikasi) {
                                'disetujui' => 'bg-green-100 text-green-700',
                                'menunggu'  => 'bg-yellow-100 text-yellow-700',
                                'ditolak'   => 'bg-red-100 text-red-700',
                                default     => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warnaVerifikasi }}">
                            {{ ucfirst($item->status_verifikasi ?? 'Belum') }}
                        </span>
                    </td>

                    <td class="py-2">
                        {{ $item->tanggal_selesai?->parse($item->tanggal_selesai)->locale('id')->translatedFormat('l, d/m/Y') ?? '-' }}
                    </td>
                    <td class="py-2">
                        Rp {{ number_format($item->biaya_pemugaran, 0, ',', '.') }}
                    </td>
                    <td class="py-2 text-center">
                        <div class="flex justify-center gap-1">
                            <a href="{{ route('pemugaran.detail', $item->id_pemugaran) }}" class="py-1 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded">
                                <i class="fas fa-circle-info"></i>
                            </a>
                            <a href="{{ route('pemugaran.edit', $item->id_pemugaran) }}" class="py-1 px-2 bg-amber-500 hover:bg-amber-700 shadow-sm shadow-amber-400 text-white rounded">
                                <i class="fas fa-pen"></i>
                            </a>
                            
                            @php
                            $userRole = auth()->user()->role;
                            @endphp
                            @if ($userRole === 'admin')
                                <a href="{{ route('pemugaran.verifikasi', $item->id_pemugaran) }}" class="py-1 px-2 bg-indigo-500 hover:bg-indigo-700 shadow-sm shadow-indigo-400 text-white rounded">
                                <i class="fa-regular fa-circle-check"></i>
                            </a>
                            @else
                                <button
                                    type="button"
                                    disabled
                                    class="py-1 px-2 bg-indigo-300 text-white rounded cursor-not-allowed opacity-60"
                                    title="Hanya admin yang dapat melakukan verifikasi"
                                >
                                    <i class="fa-regular fa-circle-check"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-lg py-4 text-gray-400 italic">
                        Data pemugaran tidak tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $pemugaran->links() }}
    </div>
    </div>
    {{-- Toolbar --}}
    

</div>

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
