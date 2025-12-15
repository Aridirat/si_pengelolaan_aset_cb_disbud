<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .no-border { border: none; }
    </style>
</head>
<body>

<h2 style="text-align:center;">LAPORAN DATA CAGAR BUDAYA</h2>
<p style="text-align:center;">Dinas Kebudayaan Kabupaten Badung</p>
@php
use Carbon\Carbon;

$tanggalIndonesia = Carbon::parse($tanggal)
    ->locale('id')        // set locale ke bahasa Indonesia
    ->isoFormat('D MMMM YYYY');
@endphp
<p style="text-align:center;">Tanggal Cetak: {{ $tanggalIndonesia }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Cagar Budaya</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Status Kepemilikan</th>
            <th>Kondisi</th>
            <th>Nilai Perolehan (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->id_cagar_budaya }}</td>
            <td>{{ $row->nama_cagar_budaya }}</td>
            <td>{{ $row->kategori }}</td>
            <td>{{ ucfirst($row->status_kepemilikan) }}</td>
            <td>{{ ucfirst($row->kondisi) }}</td>
            <td class="text-right">
                {{ number_format($row->nilai_perolehan, 2, ',', '.') }}
            </td>
        </tr>
        @endforeach

        {{-- TOTAL --}}
        <tr>
            <th colspan="6" class="text-right">Total Nilai Perolehan</th>
            <th class="text-right">
                {{ number_format($totalNilai, 2, ',', '.') }}
            </th>
        </tr>
    </tbody>
</table>

<br><br>

<table class="no-border" width="100%">
    <tr class="no-border">
        <td class="no-border" width="70%"></td>
        <td class="no-border" style="text-align:center;">
            Badung, {{ $tanggalIndonesia }}<br>
            Kepala Bidang Cagar Budaya<br><br>

            {{-- TTD DIGITAL --}}
            <img src="{{ public_path('storage/ttd/ttd.png') }}" width="120"><br>

            <strong>NIP: {{ $penandatangan }}</strong><br>
            <strong>{{ $namaPenandatangan }}</strong>
        </td>
    </tr>
</table>

</body>
</html>
