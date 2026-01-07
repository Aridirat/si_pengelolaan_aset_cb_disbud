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

<table style="width:60%; margin: 5px auto; border-collapse: collapse;">

    @if($jumlahTotal > 0)
    <tr>
        <td style="border:1px solid #000; padding:6px; text-align:left;">
            Jumlah Total Data Cagar Budaya
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:right;">
            {{ $jumlahTotal }} Data
        </td>
    </tr>
    @endif

    @if($jumlahBaik > 0)
    <tr>
        <td style="border:1px solid #000; padding:6px; text-align:left;">
            Kondisi Baik
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:right;">
            {{ $jumlahBaik }} Data
        </td>
    </tr>
    @endif

    @if($jumlahRusakRingan > 0)
    <tr>
        <td style="border:1px solid #000; padding:6px; text-align:left;">
            Kondisi Rusak Ringan
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:right;">
            {{ $jumlahRusakRingan }} Data
        </td>
    </tr>
    @endif

    @if($jumlahRusakBerat > 0)
    <tr>
        <td style="border:1px solid #000; padding:6px; text-align:left;">
            Kondisi Rusak Berat
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:right;">
            {{ $jumlahRusakBerat }} Data
        </td>
    </tr>
    @endif

    @if($jumlahAktif > 0)
    <tr>
        <td style="border:1px solid #000; padding:6px; text-align:left;">
            Status Aktif
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:right;">
            {{ $jumlahAktif }} Data
        </td>
    </tr>
    @endif

    @if($jumlahTerhapus > 0)
    <tr>
        <td style="border:1px solid #000; padding:6px; text-align:left;">
            Status Terhapus
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:right;">
            {{ $jumlahTerhapus }} Data
        </td>
    </tr>
    @endif

</table>



<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Cagar Budaya</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Status Kepemilikan</th>
            <th>Kondisi</th>
            <th>Status Penetapan</th>
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
            <td>{{ ucfirst($row->status_penetapan) }}</td>
            <td class="text-right">
                {{ number_format($row->nilai_perolehan, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach

        {{-- TOTAL --}}
        <tr class="total-row">
            <th colspan="7" class="text-right">TOTAL NILAI PEROLEHAN</th>
            <th class="text-right">
                {{ number_format($totalNilai, 0, ',', '.') }}
            </th>
        </tr>
    </tbody>
</table>

<br><br>

<table class="no-border" width="100%">
    <tr class="no-border">
        <td class="no-border" width="70%"></td>
        <td class="no-border" style="text-align:center;">
            Mengetahui, Kepala Bidang Cagar Budaya<br>
            Kabupaten Badung<br><br>

            {{-- TTD DIGITAL --}}
            <br><br>

            <strong><u>{{ $namaPenandatangan }}</u></strong><br>
            <strong>NIP. {{ $penandatangan }}</strong>
        </td>
    </tr>
</table>

</body>
</html>
