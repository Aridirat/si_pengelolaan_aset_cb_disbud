<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f0f0f0; }
        .no-border, .no-border td { border: none; }
        .text-right { text-align: right; }

        .total-row {
        background-color: #f2f2f2; 
        font-weight: bold;
        }
    </style>
</head>
<body>

{{-- Header --}}
{{-- KOP SURAT --}}
    <table width="100%" style="border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="text-align:center; border:none;">
                <div style="font-size:14pt; font-weight:bold;">
                    PEMERINTAH KABUPATEN BADUNG
                </div>
                <div style="font-size:16pt; font-weight:bold; margin-top:2px;">
                    DINAS KEBUDAYAAN
                </div>
                <div style="font-size:11pt; margin-top:4px;">
                    Pusat Pemerintahan Kabupaten Badung Mangupraja Mandala
                </div>
                <div style="font-size:11pt;">
                    Jalan Raya Sempidi Mengwi – Kabupaten Badung Provinsi Bali (80351)
                </div>
                <div style="font-size:11pt;">
                    Telp. (0361) 9009273 &nbsp; Faks. (0361) 9009274
                </div>
                <div style="font-size:11pt;">
                    <i>
                        Website: www.badungkab.go.id
                    </i>
                </div>
            </td>
        </tr>
    </table>
    <!-- GARIS KOP -->
    <hr style="border:0; border-top:4px solid #000; margin-top:8px;">
    <hr style="border:0; border-top:1px solid #000;">
<div style="text-align:center;">
    <h2>LAPORAN DATA PENGHAPUSAN CAGAR BUDAYA</h2>
    <p>Tanggal Cetak: {{ $tanggalIndonesia }}</p>
</div>

@php
$dataRingkasan = array_filter([
    ['Total data penghapusan', $totalData],
    ['Kondisi musnah', $kondisiMusnah],
    ['Kondisi hilang', $kondisiHilang],
    ['Kondisi berubah wujud', $kondisiBerubahWujud],
    ['Status pending', $statusPending],
    ['Status diproses', $statusDiproses],
    ['Status selesai', $statusSelesai],
    ['Verifikasi menunggu', $verifMenunggu],
    ['Verifikasi ditolak', $verifDitolak],
    ['Verifikasi disetujui', $verifDisetujui],
], fn($item) => $item[1] > 0);

$kolomKiri  = array_slice($dataRingkasan, 0, 6);
$kolomKanan = array_slice($dataRingkasan, 6);
@endphp

<table style="width:50%; font-size:8pt; border-collapse:collapse; margin-bottom:15px; border:none;">
    <tr>
        <td style="width:50%; vertical-align:top; border:none;">
            <table style="width:100%; border-collapse:collapse; border:none;">
                @foreach($kolomKiri as $item)
                <tr>
                    <td style="width:50%; border:none; text-align:left;">{{ $item[0] }}</td>
                    <td style="width:5%; border:none; text-align:left;">:</td>
                    <td style="width:35%; border:none; text-align:left;">{{ $item[1] }} data</td>
                </tr>
                @endforeach
            </table>
        </td>

        <td style="width:50%; vertical-align:top; border:none;">
            <table style="width:100%; border-collapse:collapse; border:none;">
                @foreach($kolomKanan as $item)
                <tr>
                    <td style="width:50%; border:none; text-align:left;">{{ $item[0] }}</td>
                    <td style="width:5%; border:none; text-align:left;">:</td>
                    <td style="width:35%; border:none; text-align:left;">{{ $item[1] }} data</td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>

<br>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Cagar Budaya</th>
            <th>Kondisi</th>
            <th>Alasan Penghapusan</th>
            <th>Status Penghapusan</th>
            <th>Status Verifikasi</th>
            <th>Tanggal Verifikasi</th>
            <th>Nilai Perolehan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penghapusan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}</td>
                <td>{{ ucfirst($item->kondisi) }}</td>
                <td>{{ $item->alasan_penghapusan }}</td>
                <td>{{ ucfirst($item->status_penghapusan) }}</td>
                <td>{{ ucfirst($item->status_verifikasi) }}</td>
                <td>
                    {{ $item->tanggal_verifikasi
                        ? \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d/m/Y')
                        : '-' }}
                </td>
                <td class="text-right">
                    Rp {{ number_format($item->cagarBudaya->nilai_perolehan ?? 0, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center py-6 text-gray-500 italic">
                    Data penghapusan tidak tersedia
                </td>
            </tr>
        @endforelse

        {{-- TOTAL --}}
        @if ($penghapusan->count() > 0)
            <tr class="total-row">
                <td colspan="7" class="text-right">
                    <strong>TOTAL NILAI PEROLEHAN</strong>
                </td>
                <td class="text-right">
                    <strong>
                        Rp {{ number_format($totalNilai, 0, ',', '.') }}
                    </strong>
                </td>
            </tr>
        @endif
    </tbody>

</table>

<br><br>

{{-- Footer Tanda Tangan --}}
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
