<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 10px;
            text-align: center;
            word-wrap: break-word;
            vertical-align: top;
        }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .no-border { border: none; }
    </style>
</head>
<body>

<h2 style="text-align:center;">LAPORAN MUTASI DATA CAGAR BUDAYA</h2>
<p style="text-align:center;">Dinas Kebudayaan Kabupaten Badung</p>
<p style="text-align:center;">Tanggal Cetak: {{ $tanggal }}</p>

<table>
    <thead>
        <tr>
            <th style="font-size:7px; text-align:center;">No</th>
            <th style="font-size:7px; text-align:center;">Nama Cagar Budaya</th>
            <th style="font-size:7px; text-align:center;">Tanggal Mutasi</th>
            <th style="font-size:7px; text-align:center;">Penanggung Jawab</th>
            <th style="font-size:7px; text-align:center;">Field yang Dimutasi</th>
            <th style="font-size:7px; text-align:center;">Data Lama</th>
            <th style="font-size:7px; text-align:center;">Data Baru</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mutasiData as $i => $item)
        @php
            $changedFields = \App\Constants\CagarBudayaBitmask::decodeBitmask($item->bitmask);
            $dataLama = json_decode($item->nilai_lama, true) ?? [];
            $dataBaru = json_decode($item->nilai_baru, true) ?? [];
        @endphp
        <tr>
            <td style="font-size:7px; text-align:justify; vertical-align: top;">{{ $i + 1 }}</td>
            <td style="font-size:7px; text-align:justify; vertical-align: top;">{{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}</td>
            <td style="font-size:7px; text-align:justify; vertical-align: top;">{{ $item->tanggal_mutasi_data->format('d/m/Y H:i') }}</td>
            <td style="font-size:7px; text-align:justify; vertical-align: top;">{{ $item->user->nama ?? '-' }}</td>
            <td style="font-size:7px; text-align:justify; vertical-align: top;">
                @if(count($changedFields))
                    {{ collect($changedFields)
                        ->map(fn($f) => ucwords(str_replace('_', ' ', $f)))
                        ->implode(', ')
                    }}
                @else
                    -
                @endif
            </td>
            <td style="font-size:7px; text-align:justify; vertical-align: top;">
                @foreach ($dataLama as $key => $value)
                    <div style="margin-bottom:2px;">
                        <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                        {{ is_array($value) ? json_encode($value) : $value }}
                    </div>
                @endforeach
            </td>

            <td style="font-size:7px; text-align:justify; vertical-align: top;">
                @foreach ($dataBaru as $key => $value)
                    <div style="margin-bottom:2px;">
                        <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                        {{ is_array($value) ? json_encode($value) : $value }}
                    </div>
                @endforeach
            </td>
        </tr>
        @endforeach
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
            <img src="{{ public_path('storage/ttd/ttd.png') }}" width="120"><br>

            <strong><u>{{ $namaPenandatangan }}</u></strong><br>
            <strong>NIP. {{ $penandatangan }}</strong>
        </td>
    </tr>
</table>

</body>
</html>
