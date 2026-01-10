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

        .total-row {
        background-color: #f2f2f2;
        font-weight: bold;
        }
    </style>
</head>
<body>
    {{-- Header --}}
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
                    <i>Website: www.badungkab.go.id</i>
                </div>
            </td>
        </tr>
    </table>

<hr style="border:0; border-top:4px solid #000; margin-top:8px;">
<hr style="border:0; border-top:1px solid #000;">

<h2 style="text-align:center;">
    LAPORAN DATA MUTASI CAGAR BUDAYA
</h2>
<p style="text-align:center; font-size: 11pt;">
    Tanggal Cetak: {{ $tanggalIndonesia }}
</p>

<table style="width:60%; font-size:11pt; border-collapse: collapse; margin-bottom:15px;">

    @if($totalData > 0)
    <tr>
        <td style="width:25%; border:none; text-align:left;">Total data mutasi</td>
        <td style="width:3%; border:none; text-align:left;">:</td>
        <td style="width:52%; border:none; text-align:left;">
            {{ $totalData }} data
        </td>
    </tr>
    @endif

    @if($asalPemerintah > 0)
    <tr>
        <td style="border:none; text-align:left;">Pemilik asal pemerintah</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $asalPemerintah }} data
        </td>
    </tr>
    @endif

    @if($asalPribadi > 0)
    <tr>
        <td style="border:none; text-align:left;">Pemilik asal pribadi</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $asalPribadi }} data
        </td>
    </tr>
    @endif

    @if($mutasiPending > 0)
    <tr>
        <td style="border:none; text-align:left;">Status mutasi pending</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $mutasiPending }} data
        </td>
    </tr>
    @endif

    @if($mutasiDiproses > 0)
    <tr>
        <td style="border:none; text-align:left;">Status mutasi diproses</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $mutasiDiproses }} data
        </td>
    </tr>
    @endif

    @if($mutasiSelesai > 0)
    <tr>
        <td style="border:none; text-align:left;">Status mutasi selesai</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $mutasiSelesai }} data
        </td>
    </tr>
    @endif

    @if($verifMenunggu > 0)
    <tr>
        <td style="border:none; text-align:left;">Verifikasi menunggu</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $verifMenunggu }} data
        </td>
    </tr>
    @endif

    @if($verifDitolak > 0)
    <tr>
        <td style="border:none; text-align:left;">Verifikasi ditolak</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $verifDitolak }} data
        </td>
    </tr>
    @endif

    @if($verifDisetujui > 0)
    <tr>
        <td style="border:none; text-align:left;">Verifikasi disetujui</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">
            {{ $verifDisetujui }} data
        </td>
    </tr>
    @endif

</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Cagar Budaya</th>
            <th>Kepemilikan Asal</th>
            <th>Kepemilikan Tujuan</th>
            <th>Tanggal Pengajuan</th>
            <th>Status Mutasi</th>
            <th>Status Verifikasi</th>
            <th>Nilai Perolehan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($mutasi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}</td>
                <td>{{ ucfirst($item->kepemilikan_asal) }}</td>
                <td>{{ ucfirst($item->kepemilikan_tujuan) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($item->status_mutasi) }}</td>
                <td>{{ ucfirst($item->status_verifikasi) }}</td>
                <td style="text-align:right;">
                    Rp {{ number_format($item->cagarBudaya->nilai_perolehan ?? 0, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align:center; font-style:italic; color:#555;">
                    Data mutasi tidak tersedia
                </td>
            </tr>
        @endforelse

        {{-- TOTAL (hanya tampil jika ada data) --}}
        @if ($mutasi->count() > 0)
            <tr class="total-row">
                <td colspan="7" style="text-align:right;">
                    <strong>TOTAL NILAI PEROLEHAN</strong>
                </td>
                <td style="text-align:right;">
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
