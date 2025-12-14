@extends('layouts.main')


@section('content')
<div class="px-6 py-6 min-h-screen">

    {{-- Tombol Kembali --}}
    <a href="{{ route('mutasi_data.index') }}"
       class="inline-flex items-center text-gray-700 mb-6 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    {{-- Card Utama --}}
    <div class="bg-white rounded-lg shadow p-6">

        {{-- Header --}}
        {{-- <h2 class="text-xl font-semibold mb-6">
            Detail Mutasi Data
        </h2> --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Informasi Umum --}}
            <div class="space-y-4">

                <div>
                    <p class="text-sm text-gray-500">Nama Cagar Budaya</p>
                    <p class="font-medium">
                        {{ $data->cagarBudaya->nama_cagar_budaya ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Nama Penanggung Jawab</p>
                    <p class="font-medium">
                        {{ $data->user->nama ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Tanggal Mutasi Data</p>
                    <p class="font-medium">
                        {{ $data->tanggal_mutasi_data->timezone('Asia/Makassar')->format('d/m/Y H:i') }}
                    </p>
                </div>

                {{-- Field yang Dimutasi --}}
                <div>
                    <p class="text-sm text-gray-500 mb-1">Field yang Dimutasi</p>
                    <ul class="list-disc list-inside text-gray-700 text-sm">
                        @php
                            $fields = \App\Constants\CagarBudayaBitmask::decodeBitmask($data->bitmask);
                        @endphp

                        @forelse ($fields as $field)
                            <li>{{ ucwords(str_replace('_', ' ', $field)) }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ul>
                </div>

            </div>

            {{-- Nilai Lama --}}
            <div>
                <p class="text-sm text-gray-500 mb-2">Nilai Lama</p>
                <div class="bg-gray-100 rounded p-4 text-sm overflow-auto h-64">
                    <table class="w-full text-left border-collapse">
                        <tbody>
                            @foreach (json_decode($data->nilai_lama, true) as $key => $value)
                                <tr class="border-b border-gray-200 last:border-b-0">
                                    <td class="py-1 pr-3 font-medium text-gray-600 capitalize">
                                        {{ str_replace('_', ' ', $key) }}
                                    </td>
                                    <td class="py-1 text-gray-800">
                                        {{ is_array($value) ? json_encode($value) : $value }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- Nilai Baru --}}
            <div>
                <p class="text-sm text-gray-500 mb-2">Nilai Baru</p>
                <div class="bg-gray-100 rounded p-4 text-sm overflow-auto h-64">
                    <table class="w-full text-left border-collapse">
                        <tbody>
                            @foreach (json_decode($data->nilai_baru, true) as $key => $value)
                                <tr class="border-b border-gray-200 last:border-b-0">
                                    <td class="py-1 pr-3 font-medium text-gray-600 capitalize">
                                        {{ str_replace('_', ' ', $key) }}
                                    </td>
                                    <td class="py-1 text-gray-800">
                                        {{ is_array($value) ? json_encode($value) : $value }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>
</div>
@endsection