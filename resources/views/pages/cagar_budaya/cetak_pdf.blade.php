<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .no-border {
            border: none;
        }
    </style>


</head>
<body>

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

<h3 style="text-align:center;">
        LAPORAN DATA CAGAR BUDAYA
</h3>

@php
use Carbon\Carbon;

$tanggalIndonesia = Carbon::parse($tanggal)
    ->locale('id')        // set locale ke bahasa Indonesia
    ->isoFormat('D MMMM YYYY');
@endphp
<p style="text-align:center;">Tanggal Cetak: {{ $tanggalIndonesia }}</p>

<table style="width:60%; font-size:11pt; border-collapse: collapse;">
    @if($jumlahTotal > 0)
    <tr>
        <td style="width:25%; border:none; text-align:left;">
            Data cagar budaya
        </td>
        <td style="width:3%; border:none; text-align:left;">
            :
        </td>
        <td style="width:52%; border:none; text-align:left;">
            {{ $jumlahTotal }} data
        </td>
    </tr>
    @endif

    @if($jumlahBaik > 0)
    <tr>
        <td style="border:none; text-align:left;">Kondisi baik</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">{{ $jumlahBaik }} data</td>
    </tr>
    @endif

    @if($jumlahRusakRingan > 0)
    <tr>
        <td style="border:none; text-align:left;">Kondisi rusak ringan</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">{{ $jumlahRusakRingan }} data</td>
    </tr>
    @endif

    @if($jumlahRusakBerat > 0)
    <tr>
        <td style="border:none; text-align:left;">Kondisi rusak berat</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">{{ $jumlahRusakBerat }} data</td>
    </tr>
    @endif

    @if($jumlahAktif > 0)
    <tr>
        <td style="border:none; text-align:left;">Status penetapan aktif</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">{{ $jumlahAktif }} data</td>
    </tr>
    @endif

    @if($jumlahTerhapus > 0)
    <tr>
        <td style="border:none; text-align:left;">Status penetapan terhapus</td>
        <td style="border:none; text-align:left;">:</td>
        <td style="border:none; text-align:left;">{{ $jumlahTerhapus }} data</td>
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
