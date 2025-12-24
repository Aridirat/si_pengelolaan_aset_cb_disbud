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
    <div class="header" style="text-align:center;">
        <h2>LAPORAN DATA MUTASI CAGAR BUDAYA</h2>
        <p>Dinas Kebudayaan Kabupaten Badung</p>
        <p>Tanggal Cetak: {{ $tanggalIndonesia }}</p>
    </div>

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
        @foreach ($mutasi as $item)
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
        @endforeach

        {{-- TOTAL --}}
        <tr class="total-row">
            <td colspan="7" style="text-align:right;"><strong>TOTAL NILAI PEROLEHAN</strong></td>
            <td style="text-align:right;">
                <strong>
                    Rp {{ number_format($totalNilai, 0, ',', '.') }}
                </strong>
            </td>
        </tr>
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
