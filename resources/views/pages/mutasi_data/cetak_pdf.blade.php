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

<table class="">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Cagar Budaya</th>
            <th>Tanggal Mutasi</th>
            <th>Penanggung Jawab</th>
            <th>Field yang Dimutasi</th>
            <th>Data Lama</th>
            <th>Data Baru</th>
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
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}</td>
            <td>{{ $item->tanggal_mutasi_data->format('d/m/Y H:i') }}</td>
            <td>{{ $item->user->nama ?? '-' }}</td>
            <td>
                @if(count($changedFields))
                    {{ collect($changedFields)
                        ->map(fn($f) => ucwords(str_replace('_', ' ', $f)))
                        ->implode(', ')
                    }}
                @else
                    -
                @endif
            </td>
            <td style="font-size:10px; text-align:left; vertical-align: top;">
                @foreach ($dataLama as $key => $value)
                    <div style="margin-bottom:2px;">
                        <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                        {{ is_array($value) ? json_encode($value) : $value }}
                    </div>
                @endforeach
            </td>

            <td style="font-size:10px; text-align:left; vertical-align: top;">
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
            Badung, {{ $tanggal }}<br>
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
