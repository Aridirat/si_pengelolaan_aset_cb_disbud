@extends('layouts.main')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-semibold mb-6">Cagar Budaya</h1>
    {{-- Card container --}}
    <div class="bg-white p-6 rounded-lg">

        {{-- Header tools --}}
        <div class="flex items-center justify-between mb-5">

            <div class="flex gap-3">
                <a href="{{ route('cagar_budaya.create') }}"
                    class="px-3 py-2 bg-sky-500 hover:bg-sky-700 text-white text-sm font-bold rounded-lg text-center shadow-md shadow-sky-500/30">
                    Tambah Data
                </a>

                <a href="{{ route('cagar_budaya.cetak.pdf', request()->query()) }}"
                    target="_blank"
                    class="px-3 py-2 bg-blue-500 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-md shadow-blue-500/30">
                        Cetak Laporan
                </a>

            </div>

            {{-- Search --}}
            <form action="{{ route('cagar_budaya.index') }}" method="GET" class="d-flex">
                    <div class="input-group relative">
                        <span class="input-group-text absolute left-2 top-1">
                        <i class="fa-solid fa-magnifying-glass text-gray-300 text-xl"></i>
                        </span>
                        <input type="text" name="search" class="w-full pl-9 pr-3 py-1 shadow border border-gray-300 rounded-lg placeholder:text-gray-500 focus:outline-indigo-500 placeholder:italic" placeholder="Cari..." value="{{ request('search') }}">
                    </div>
            </form>
        </div>

        {{-- Table --}}
        <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm">
                            <th class="py-2 text-center">No.</th>

                            {{-- Nama --}}
                            <th class="py-2 text-center">Nama</th>

                            {{-- Kategori (dengan ikon filter) --}}
                            <th class="py-2 text-center relative">
                                <div class="flex items-center justify-center gap-2">
                                    <span>Kategori</span>

                                    <!-- ikon filter -->
                                    <button type="button"
                                        class="filter-toggle text-sky-500 hover:text-sky-700"
                                        data-target="filter-kategori"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        title="Filter kategori">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>

                                <!-- Dropdown kecil untuk kategori -->
                                <div id="filter-kategori" class="filter-dropdown hidden absolute mt-2 left-0 bg-white border rounded shadow z-40 w-44">
                                    <form method="GET" class="p-3" id="form-filter-kategori">
                                        {{-- Bawa query string lain agar tidak hilang --}}
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="lokasi" value="{{ request('lokasi') }}">
                                        <input type="hidden" name="kondisi" value="{{ request('kondisi') }}">

                                        <div class="text-sm font-medium mb-2">Pilih Kategori</div>
                                        <div class="max-h-40 overflow-auto">
                                            @foreach ($kategoriList as $item)
                                                <label class="flex items-center gap-2 py-1">
                                                    <input type="radio" name="kategori" value="{{ $item }}" {{ request('kategori') == $item ? 'checked' : '' }}>
                                                    <span class="text-sm">{{ $item }}</span>
                                                </label>
                                            @endforeach
                                            {{-- Opsi kosong untuk reset --}}
                                            <label class="flex items-center gap-2 py-1">
                                                <input type="radio" name="kategori" value="" {{ request('kategori') == '' ? 'checked' : '' }}>
                                                <span class="text-sm">Semua</span>
                                            </label>
                                        </div>

                                        <div class="mt-3 flex justify-between">
                                            <button type="button" class="clear-filter text-sm text-gray-600" data-field="kategori">Reset</button>
                                            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Terapkan</button>
                                        </div>
                                    </form>
                                </div>
                            </th>

                            {{-- Lokasi (lokasi) --}}
                            <th class="py-2 text-center relative">
                                <div class="flex items-center justify-center gap-2">
                                    <span>Lokasi</span>
                                    <button type="button"
                                        class="filter-toggle text-sky-500 hover:text-sky-700"
                                        data-target="filter-lokasi"
                                        title="Filter lokasi">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>

                                <div id="filter-lokasi" class="filter-dropdown hidden absolute mt-2 left-0 bg-white border rounded shadow z-40 w-48">
                                    <form method="GET" class="p-3" id="form-filter-lokasi">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                                        <input type="hidden" name="kondisi" value="{{ request('kondisi') }}">

                                        <div class="text-sm font-medium mb-2">Pilih Lokasi</div>
                                        <div class="max-h-40 overflow-auto">
                                            @foreach ($lokasiList as $item)
                                                <label class="flex items-center gap-2 py-1">
                                                    <input type="radio"
                                                        name="lokasi"
                                                        value="{{ $item }}"
                                                        {{ request('lokasi') === $item ? 'checked' : '' }}>
                                                    <span class="text-sm capitalize">
                                                        {{ $item }}
                                                    </span>
                                                </label>
                                            @endforeach

                                            <label class="flex items-center gap-2 py-1">
                                                <input type="radio" name="lokasi" value="" {{ request('lokasi') == '' ? 'checked' : '' }}>
                                                <span class="text-sm">Semua</span>
                                            </label>
                                        </div>

                                        <div class="mt-3 flex justify-between">
                                            <button type="button" class="clear-filter text-sm text-gray-600" data-field="lokasi">Reset</button>
                                            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Terapkan</button>
                                        </div>
                                    </form>
                                </div>
                            </th>

                            {{-- Kondisi --}}
                            <th class="py-2 text-center relative">
                                <div class="flex items-center justify-center gap-2"></div>
                                    <span>Kondisi</span>
                                    <button type="button"
                                        class="filter-toggle text-sky-500 hover:text-sky-700"
                                        data-target="filter-kondisi"
                                        title="Filter kondisi">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>

                                <div id="filter-kondisi" class="filter-dropdown hidden absolute mt-2 left-0 bg-white border rounded shadow z-40 w-44">
                                    <form method="GET" class="p-3" id="form-filter-kondisi">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                                        <input type="hidden" name="lokasi" value="{{ request('lokasi') }}">

                                        <div class="text-sm font-medium mb-2">Pilih Kondisi</div>
                                        <div class="max-h-40 overflow-auto">
                                            @foreach ($kondisiList as $item)
                                                <label class="flex items-center gap-2 py-1">
                                                    <input type="radio" name="kondisi" value="{{ $item }}" {{ request('kondisi') == $item ? 'checked' : '' }}>
                                                    <span class="text-sm">{{ $item }}</span>
                                                </label>
                                            @endforeach
                                            <label class="flex items-center gap-2 py-1">
                                                <input type="radio" name="kondisi" value="" {{ request('kondisi') == '' ? 'checked' : '' }}>
                                                <span class="text-sm">Semua</span>
                                            </label>
                                        </div>

                                        <div class="mt-3 flex justify-between">
                                            <button type="button" class="clear-filter text-sm text-gray-600" data-field="kondisi">Reset</button>
                                            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Terapkan</button>
                                        </div>
                                    </form>
                                </div>
                            </th>

                            {{-- Status Penetapan --}}
                            <th class="p-2 text-center relative">
                                <div class="flex items-center justify-center gap-2">
                                    <span>Status Penetapan</span>
                                    <button type="button"
                                        class="filter-toggle text-sky-500 hover:text-sky-700"
                                        data-target="filter-status-penetapan"
                                        title="Filter status penetapan">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>

                                <div id="filter-status-penetapan"
                                    class="filter-dropdown hidden absolute mt-2 left-0 bg-white border rounded shadow z-40 w-48">
                                    <form method="GET" class="p-3" id="form-filter-status-penetapan">

                                        {{-- pertahankan query lain --}}
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                                        <input type="hidden" name="lokasi" value="{{ request('lokasi') }}">
                                        <input type="hidden" name="kondisi" value="{{ request('kondisi') }}">

                                        <div class="text-sm font-medium mb-2">Pilih Status</div>

                                        <div class="max-h-40 overflow-auto">
                                            @foreach ($penetapanList as $item)
                                                <label class="flex items-center gap-2 py-1">
                                                    <input type="radio"
                                                        name="status_penetapan"
                                                        value="{{ $item }}"
                                                        {{ request('status_penetapan') == $item ? 'checked' : '' }}>
                                                    <span class="text-sm">{{ $item }}</span>
                                                </label>
                                            @endforeach

                                            <label class="flex items-center gap-2 py-1">
                                                <input type="radio"
                                                    name="status_penetapan"
                                                    value=""
                                                    {{ request('status_penetapan') == '' ? 'checked' : '' }}>
                                                <span class="text-sm">Semua</span>
                                            </label>
                                        </div>

                                        <div class="mt-3 flex justify-between">
                                            <button type="button"
                                                class="clear-filter text-sm text-gray-600"
                                                data-field="status-penetapan">
                                                Reset
                                            </button>
                                            <button type="submit"
                                                class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                                Terapkan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </th>


                            <th class="py-2 text-center">Nilai Perolehan</th>
                            <th class="py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $row)
                        <tr class="text-sm border-none
                                @if ($row->status_penetapan === 'terhapus')
                                    bg-gray-200 text-gray-700
                                @elseif ($row->status_penetapan === 'mutasi keluar')
                                    bg-amber-100 text-amber-800
                                @else
                                    hover:bg-gray-100
                                @endif
                            ">

                            <td class="py-3 text-center">{{ $data->firstItem() + $index }}</td>
                            <td class="py-3 text-center">{{ $row->nama_cagar_budaya }}</td>
                            <td class="py-3 text-center">{{ $row->kategori }}</td>
                            <td class="py-3 text-center">{{ $row->lokasi }}</td>
                            <td class="py-3 text-center">{{ $row->kondisi }}</td>
                            <td class="py-3 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if ($row->status_penetapan === 'aktif')
                                        bg-green-100 text-green-700
                                    @elseif ($row->status_penetapan === 'mutasi keluar')
                                        bg-amber-200 text-amber-800
                                    @else
                                        bg-gray-100 text-gray-600
                                    @endif
                                ">
                                    {{ $row->status_penetapan }}
                                </span>
                            </td>

                            <td class="py-3 text-center">Rp.{{ number_format($row->nilai_perolehan, 2, ',', '.') }}</td>
                            <td class="flex p-3 gap-2 justify-center">

                                <a href="{{ route('cagar_budaya.detail', $row->id_cagar_budaya) }}" class="py-1 px-2 bg-teal-500 hover:bg-teal-700 shadow-sm shadow-teal-400 text-white rounded-lg">
                                    <i class="fas fa-circle-info"></i>
                                </a>
                                @if ($row->status_penetapan !== 'aktif')
                                    <button
                                        type="button"
                                        disabled
                                        title="Data sudah terhapus dan tidak dapat diedit"
                                        class="py-1 px-2 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                @else
                                    <a href="{{ route('cagar_budaya.edit', $row->id_cagar_budaya) }}"
                                    class="py-1 px-2 bg-amber-500 hover:bg-amber-700 shadow-sm shadow-amber-400 text-white rounded-lg">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                @endif


                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-lg py-4 text-gray-400 italic">Tidak ada data yang ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
            </table>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $data->links() }}
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // buka/tutup dropdown saat ikon diklik
    document.querySelectorAll('.filter-toggle').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const targetId = this.getAttribute('data-target');
            const el = document.getElementById(targetId);

            // tutup semua dropdown lain
            document.querySelectorAll('.filter-dropdown').forEach(d => {
                if (d.id !== targetId) d.classList.add('hidden');
            });

            // toggle target
            el.classList.toggle('hidden');
        });
    });

    // klik di luar dropdown -> tutup semua
    document.addEventListener('click', function () {
        document.querySelectorAll('.filter-dropdown').forEach(d => d.classList.add('hidden'));
    });

    // jangan close saat klik di dalam dropdown
    document.querySelectorAll('.filter-dropdown').forEach(drop => {
        drop.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });

    // tombol reset di dalam dropdown (set value ke kosong lalu submit)
    document.querySelectorAll('.clear-filter').forEach(btn => {
        btn.addEventListener('click', function () {
            const field = this.getAttribute('data-field');
            const form = document.getElementById('form-filter-' + field);
            // find input radio with value ""
            const input = form.querySelector('input[name="'+field+'"][value=""]');
            if (input) input.checked = true;
            form.submit();
        });
    });

    // opsional: close dropdown saat scroll
    window.addEventListener('scroll', function () {
        document.querySelectorAll('.filter-dropdown').forEach(d => d.classList.add('hidden'));
    });
});
</script>

@endsection
