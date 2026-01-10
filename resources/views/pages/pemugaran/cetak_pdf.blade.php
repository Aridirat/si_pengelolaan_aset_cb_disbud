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

    <div class="header" style="text-align:center;">
        <h2>LAPORAN DATA PEMUGARAN CAGAR BUDAYA</h2>
        <p style="font-size: 10pt">Tanggal Cetak: {{ $tanggalIndonesia }}</p>
    </div>

    @php
    $dataRingkasan = [];

    if ($totalData > 0) $dataRingkasan[] = ['Total data pemugaran', $totalData];
    if ($kondisiRusakRingan > 0) $dataRingkasan[] = ['Kondisi rusak ringan', $kondisiRusakRingan];
    if ($kondisiRusakBerat > 0) $dataRingkasan[] = ['Kondisi rusak berat', $kondisiRusakBerat];
    if ($tipeKonsolidasi > 0) $dataRingkasan[] = ['Tipe konsolidasi', $tipeKonsolidasi];
    if ($tipeRehabilitasi > 0) $dataRingkasan[] = ['Tipe rehabilitasi', $tipeRehabilitasi];
    if ($tipeRestorasi > 0) $dataRingkasan[] = ['Tipe restorasi', $tipeRestorasi];
    if ($tipeRekonstruksi > 0) $dataRingkasan[] = ['Tipe rekonstruksi', $tipeRekonstruksi];
    if ($statusPending > 0) $dataRingkasan[] = ['Status pending', $statusPending];
    if ($statusDiproses > 0) $dataRingkasan[] = ['Status diproses', $statusDiproses];
    if ($statusSelesai > 0) $dataRingkasan[] = ['Status selesai', $statusSelesai];
    if ($verifMenunggu > 0) $dataRingkasan[] = ['Verifikasi menunggu', $verifMenunggu];
    if ($verifDitolak > 0) $dataRingkasan[] = ['Verifikasi ditolak', $verifDitolak];
    if ($verifDisetujui > 0) $dataRingkasan[] = ['Verifikasi disetujui', $verifDisetujui];

    $kolomKiri  = array_slice($dataRingkasan, 0, 6);
    $kolomKanan = array_slice($dataRingkasan, 6);
    @endphp

    <table style="width:50%; font-size:8pt; border-collapse:collapse; margin-bottom:15px; border:none;">
        <tr>
            {{-- KOLOM KIRI --}}
            <td style="width:50%; vertical-align:top; border:none;">
                <table style="width:100%; border-collapse:collapse; border:none;">
                    @foreach($kolomKiri as $item)
                    <tr>
                        <td style="width:60%; border:none; text-align:left;">
                            {{ $item[0] }}
                        </td>
                        <td style="width:5%; border:none; text-align:left;">
                            :
                        </td>
                        <td style="width:35%; border:none; text-align:left;">
                            {{ $item[1] }} data
                        </td>
                    </tr>
                    @endforeach
                </table>
            </td>

            {{-- KOLOM KANAN --}}
            <td style="width:50%; vertical-align:top; border:none;">
                <table style="width:100%; border-collapse:collapse; border:none;">
                    @foreach($kolomKanan as $item)
                    <tr>
                        <td style="width:60%; border:none; text-align:left;">
                            {{ $item[0] }}
                        </td>
                        <td style="width:5%; border:none; text-align:left;">
                            :
                        </td>
                        <td style="width:35%; border:none; text-align:left;">
                            {{ $item[1] }} data
                        </td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>




    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th>Cagar Budaya</th>
                <th>Kondisi</th>
                <th>Tipe Pemugaran</th>
                <th>Tgl Pengajuan</th>
                <th>Status Pemugaran</th>
                <th>Status Verifikasi</th>
                <th>Tgl Verifikasi</th>
                <th>Tgl Selesai</th>
                <th>Kondisi Baru</th>
                <th>Nilai Perolehan Baru</th>
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
                        {{ $item->tipe_pemugaran ?? '-' }}
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
                    <td class="text-center">
                        {{ $item->kondisi_baru ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->nilai_perolehan_baru ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($item->biaya_pemugaran ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">
                        Data pemugaran tidak tersedia
                    </td>
                </tr>
            @endforelse
            @if ($pemugaran->count())
            <tr class="total-row">
                <td colspan="11" class="text-right" style="font-weight: bold;">
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
            <br><br>

            <strong><u>{{ $namaPenandatangan }}</u></strong><br>
            <strong>NIP. {{ $penandatangan }}</strong>
        </td>
    </tr>
    </table> 

</body>
</html>
