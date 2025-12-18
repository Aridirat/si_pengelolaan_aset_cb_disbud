@extends('layouts.main')

@section('content')

<div class="p-6 bg-gray-100 rounded-lg">

    {{-- Judul --}}
    <h1 class="text-2xl font-semibold mb-4">
        Mutasi Data Cagar Budaya
    </h1>
<div class="bg-white p-6 rounded-lg">
    
    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <a href="{{ route('mutasi_data.cetak.pdf', request()->query()) }}"
                    target="_blank"
                    class="px-3 py-2 mt-5 bg-blue-500 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-md shadow-blue-500/30">
                        Cetak Laporan
        </a>

        <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('mutasi_data.index') }}" id="filterForm">

            {{-- Input tersembunyi untuk GET --}}
            <input type="hidden" name="field" id="selectedField" value="{{ request('field') }}">

            <div class="flex flex-col gap-1">
                <span class="text-sm text-gray-600">
                    Filter berdasarkan field:
                </span>

                <el-dropdown class="inline-block">
                    {{-- Button --}}
                    <button
                        type="button"
                        id="filterDropdownButton"
                        class="inline-flex w-72 justify-between items-center gap-x-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring-1 inset-ring-gray-300 hover:bg-gray-50"
                    >
                        {{ request('field')
                            ? ucwords(str_replace('_', ' ', request('field')))
                            : 'Semua Field'
                        }}
                        <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                            <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28Z"/>
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <el-menu
                        anchor="bottom start"
                        popover
                        class="w-64 origin-top-left rounded-md bg-white shadow-lg outline-1 outline-black/5"
                    >
                        <div class="py-1">

                            {{-- Semua Field --}}
                            <button
                                type="button"
                                class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                                onclick="applyFieldFilter('')"
                            >
                                Semua Field
                            </button>

                            <hr class="my-1 text-gray-300">

                            @foreach (\App\Constants\CagarBudayaBitmask::FIELDS as $field => $bit)
                                <button
                                    type="button"
                                    class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                                    onclick="applyFieldFilter('{{ $field }}')"
                                >
                                    {{ ucwords(str_replace('_', ' ', $field)) }}
                                </button>
                            @endforeach

                        </div>
                    </el-menu>
                </el-dropdown>
            </div>
        </form>

            
            {{-- Search --}}
            <form action="{{ route('mutasi_data.index') }}" method="GET" class="d-flex">
                    <div class="mt-5">
                        <div class="input-group relative">
                            <span class="input-group-text absolute left-2 top-1">
                            <i class="fa-solid fa-magnifying-glass text-gray-300 text-xl"></i>
                            </span>
                            <input type="text" name="search" class="w-full pl-9 pr-3 py-1 shadow border border-gray-300 rounded-lg placeholder:text-gray-500 focus:outline-indigo-500 placeholder:italic" placeholder="Cari..." value="{{ request('search') }}">
                        </div>
                    </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-3 w-12">No.</th>
                    <th class="px-4 py-3">Cagar Budaya</th>
                    <th class="px-4 py-3">Tanggal Mutasi Data</th>
                    <th class="px-4 py-3">Penanggung Jawab</th>
                    <th class="px-4 py-3">Field yang Dimutasi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @forelse ($mutasi_data as $index => $item)

                @php
                    // Mapping bitmask → field
                    $fieldMap = [
                        'nama_cagar_budaya',
                        'kategori',
                        'lokasi',
                        'tanggal_pertama_pencatatan',
                        'nilai_perolehan',
                        'status_kepemilikan',
                        'kondisi',
                        'deskripsi',
                    ];

                    $changedFields = [];
                    foreach ($fieldMap as $i => $field) {
                        if ($item->bitmask & (1 << $i)) {
                            $changedFields[] = ucwords(str_replace('_', ' ', $field));
                        }
                    }
                @endphp

                <tr class=" hover:bg-gray-200">
                    <td class="px-4 py-4">
                        {{ $mutasi_data->firstItem() + $index }}
                    </td>

                    <td class="px-4 py-4 font-medium">
                        {{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}
                    </td>

                    <td class="px-4 py-4">
                        {{ $item->tanggal_mutasi_data->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-4 py-4">
                        {{ $item->user->nama ?? '-' }}
                    </td>

                    <td class="px-4 py-4 text-gray-700">
                        @php
                            $changedFields = \App\Constants\CagarBudayaBitmask::decodeBitmask($item->bitmask);
                        @endphp
                        @if(count($changedFields))
                            {{ collect($changedFields)
                                ->map(fn($f) => ucwords(str_replace('_', ' ', $f)))
                                ->implode(', ')
                            }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="px-4 py-4 text-center">
                        <a href="{{ route('mutasi_data.detail', $item->id_mutasi_data) }}"
                           class="py-2 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded-lg">
                            <i class="fas fa-circle-info"></i>
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-500">
                        Tidak ada daftar Mutasi Data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $mutasi_data->links() }}
    </div>
</div>


</div>

<script>
    function applyFieldFilter(field) {
        document.getElementById('selectedField').value = field;
        document.getElementById('filterForm').submit();
    }
</script>

@endsection
