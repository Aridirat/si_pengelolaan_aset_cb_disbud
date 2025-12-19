@extends('layouts.main')

@section('content')

<div class="px-6 py-6">

    <!-- Judul Halaman -->
    <h1 class="text-2xl font-semibold mb-6">Pengguna</h1>

    <!-- Card Container -->
    <div class="bg-white p-6 rounded-lg shadow-sm">

        <!-- Header: Tombol Tambah & Cari -->
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('user.create') }}"
            class="px-3 py-2 bg-sky-500 hover:bg-sky-700 text-white text-sm font-bold rounded-lg text-center shadow-md shadow-sky-500/30">
                Tambah Pengguna
            </a>

                <form action="{{ route('user.index') }}" method="GET" class="d-flex">
                <div class="input-group relative">
                    <span class="input-group-text absolute left-2 top-1">
                    <i class="fa-solid fa-magnifying-glass text-gray-300 text-xl"></i>
                    </span>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-1 shadow border border-gray-300 rounded-lg placeholder:text-gray-500 focus:outline-indigo-500 placeholder:italic" placeholder="Cari..." value="{{ request('search') }}">
                </div>
            </form>
            
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-auto">
                <thead class="border-b border-gray-300">
                    <tr class="text-gray-700">
                        <th class="py-2">No.</th>
                        <th class="py-2">NIP</th>
                        <th class="py-2">Nama Lengkap</th>
                        <th class="py-2">Username</th>
                        <th class="py-2">Role</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $i => $user)
                        <tr class="border-none hover:bg-gray-100">
                            <td class="py-3 text-center">{{ $users->firstItem() + $i }}</td>
                            <td class="py-3 text-center">{{ $user->id }}</td>
                            <td class="py-3 text-center">{{ $user->nama }}</td>
                            <td class="py-3 text-center">{{ $user->username }}</td>
                            <td class="py-3 text-center">{{ ucfirst($user->role) }}</td>
                            <td class="py-3 text-center">{{ ucfirst($user->status_aktif) }}</td>
                            <td class="py-3 flex gap-2 justify-center">

                                {{-- Edit --}}
                                <a href="{{ url('user/'.$user->id.'/edit') }}"
                                class="py-1 px-2 bg-amber-500 hover:bg-amber-700 shadow-sm shadow-amber-400 text-white rounded">
                                    <i class="fas fa-pen"></i>
                                </a>

                                {{-- Delete --}}
                                @if (auth()->id() !== $user->id)
                                    <button type="button"
                                            class="btn-delete px-2 py-1 bg-rose-600 hover:bg-rose-700 shadow-sm shadow-rose-400 text-white rounded"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->nama }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <form id="delete-form-{{ $user->id }}"
                                        action="{{ route('user.delete', $user->id) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <button class="px-2 py-1 bg-rose-300 text-white rounded cursor-not-allowed"
                                            title="Tidak dapat menghapus pengguna yang sedang login"
                                            disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-lg text-gray-400 italic">
                                Tidak ada data pengguna
                            </td>
                        </tr>
                    @endforelse
                </tbody>


            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function (e) {

            let userId = this.getAttribute('data-id');
            let userName = this.getAttribute('data-name');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: "Data <b>" + userName + "</b> akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        });
    });

});
</script>

@endsection