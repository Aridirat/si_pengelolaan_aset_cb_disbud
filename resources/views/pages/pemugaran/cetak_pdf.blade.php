<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemugaran</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .no-border { border: none; }

        .total-row {
        background-color: #f2f2f2;
        font-weight: bold;
        }
    </style>
</head>
<body>
@php
use Carbon\Carbon;

$tanggalIndonesia = Carbon::parse($tanggal)
    ->locale('id')        // set locale ke bahasa Indonesia
    ->isoFormat('D MMMM YYYY');
@endphp
    {{-- Header --}}
    <div class="header" style="text-align:center;">
        <h2>LAPORAN DATA PEMUGARAN CAGAR BUDAYA</h2>
        <p>Dinas Kebudayaan Kabupaten Badung</p>
        <p>Tanggal Cetak: {{ $tanggalIndonesia }}</p>
    </div>

    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th>Cagar Budaya</th>
                <th>Kondisi</th>
                <th>Tgl Pengajuan</th>
                <th>Status Pemugaran</th>
                <th>Status Verifikasi</th>
                <th>Tgl Verifikasi</th>
                <th>Tgl Selesai</th>
                <th>Biaya Pemugaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pemugaran as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>

                    <td>
                        {{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->kondisi ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ ucfirst($item->status_pemugaran) }}
                    </td>

                    <td class="text-center">
                        {{ $item->status_verifikasi ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->tanggal_verifikasi?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->tanggal_selesai?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->biaya_pemugaran ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Data pemugaran tidak tersedia
                    </td>
                </tr>
            @endforelse
            @if ($pemugaran->count())
            <tr class="total-row">
                <td colspan="8" class="text-right" style="font-weight: bold;">
                    TOTAL BIAYA PEMUGARAN
                </td>
                <td class="text-right" style="font-weight: bold;">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
            </tr>
            @endif

        </tbody>
    </table>

    {{-- Footer Tanda Tangan --}}
    <table class="no-border" width="100%">
    <tr class="no-border">
        <td class="no-border" width="70%"></td>
        <td class="no-border" style="text-align:center;">
            Mengetahui, Kepala Bidang Cagar Budaya<br>
            Kabupaten Badung<br><br>

            {{-- TTD DIGITAL --}}
            <img src="{{ public_path('storage/ttd/ttd.png') }}" width="120"><br>

            <strong><u>{{ $namaPenandatangan }}</u></strong><br>
            <strong>NIP. {{ $penandatangan }}</strong>
        </td>
    </tr>
    </table> 

</body>
</html>
