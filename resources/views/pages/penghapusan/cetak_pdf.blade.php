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
<div style="text-align:center;">
    <h2>LAPORAN DATA PENGHAPUSAN CAGAR BUDAYA</h2>
    <p>Dinas Kebudayaan Kabupaten Badung</p>
    <p>Tanggal Cetak: {{ $tanggalIndonesia }}</p>
</div>

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
        @foreach ($penghapusan as $item)
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
        @endforeach

        {{-- TOTAL --}}
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
    </tbody>
</table>

<br><br>

{{-- Footer Tanda Tangan --}}
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
