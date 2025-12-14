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
                    class="px-4 py-2 bg-teal-600 text-white text-sm rounded hover:bg-teal-700">
                        Cetak Laporan
        </a>

        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('mutasi_data.index') }}" class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Filter berdasarkan field:</span>

                <select name="field" onchange="this.form.submit()"
                        class="border rounded px-3 py-2 text-sm">
                    <option value="">Semua Field</option>

                    @foreach (\App\Constants\CagarBudayaBitmask::FIELDS as $field => $bit)
                        <option value="{{ $field }}"
                            {{ request('field') === $field ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $field)) }}
                        </option>
                    @endforeach
                </select>
            </form>

            <form action="{{ route('mutasi_data.index') }}" method="GET" class="d-flex">
                    <div class="input-group relative">
                        <span class="input-group-text absolute left-2 top-8 -translate-y-1/2">
                        <i class="fa-solid fa-magnifying-glass text-gray-300 text-xl"></i>
                        </span>
                        <input type="text" name="search" class="w-full pl-9 pr-3 py-1 border-2 rounded placeholder:text-gray-500 focus:outline-indigo-500 placeholder:italic" placeholder="Cari..." value="{{ request('search') }}">
                    </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
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
            <tbody>
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

                <tr class=" hover:bg-gray-100">
                    <td class="px-4 py-3">
                        {{ $mutasi_data->firstItem() + $index }}
                    </td>

                    <td class="px-4 py-3 font-medium">
                        {{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->tanggal_mutasi_data->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->user->nama ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-gray-700">
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

                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('mutasi_data.detail', $item->id_mutasi_data) }}"
                           class="inline-flex items-center justify-center w-8 h-8 bg-teal-500 text-white rounded hover:bg-teal-700">
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

@endsection
