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
<h2 style="text-align:center;">LAPORAN MUTASI DATA CAGAR BUDAYA</h2>
<p style="text-align:center;">Tanggal Cetak: {{ $tanggal }}</p>

<table style="width:60%; font-size:11px; border-collapse: collapse; margin-bottom:15px;">
    <tr>
        <td style="width:40%; border:none; text-align:left;">
            Jumlah total mutasi data
        </td>
        <td style="width:5%; border:none;">:</td>
        <td style="width:55%; border:none; text-align:left;">
            {{ $totalMutasi }} data
        </td>
    </tr>

    @foreach ($fieldCounts as $field => $jumlah)
        @if($jumlah > 0)
        <tr>
            <td style="width:40%; border:none; text-align:left;">
                {{ ucfirst(strtolower('jumlah mutasi ' . str_replace('_',' ', $field))) }}
            </td>
            <td style="width:5%; border:none;">:</td>
            <td style="width:55%; border:none; text-align:left;">
                {{ $jumlah }} data
            </td>
        </tr>
        @endif
    @endforeach
</table>


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
        @forelse ($mutasiData as $i => $item)
            @php
                $changedFields = \App\Constants\CagarBudayaBitmask::decodeBitmask($item->bitmask);
                $dataLama = is_string($item->nilai_lama)
                    ? json_decode($item->nilai_lama, true)
                    : ($item->nilai_lama ?? []);

                $dataBaru = is_string($item->nilai_baru)
                    ? json_decode($item->nilai_baru, true)
                    : ($item->nilai_baru ?? []);

                $printedChangedFields = array_intersect($changedFields, $selectedFields);
            @endphp

            <tr>
                <td style="text-align:left; font-size:7px; vertical-align: top;">{{ $i + 1 }}</td>

                <td style="text-align:left; font-size:7px; vertical-align: top;">
                    {{ $item->cagarBudaya->nama_cagar_budaya ?? '-' }}
                </td>

                <td style="text-align:left; font-size:7px; vertical-align: top;">
                    {{ $item->tanggal_mutasi_data->format('d/m/Y H:i') }}
                </td>

                <td style="text-align:left; font-size:7px; vertical-align: top;">
                    {{ $item->user->nama ?? '-' }}
                </td>

                <td style="text-align:left; font-size:7px; vertical-align: top;">
                    @if(count($printedChangedFields))
                        {{ collect($printedChangedFields)
                            ->map(fn($f) => ucwords(str_replace('_', ' ', $f)))
                            ->implode(', ')
                        }}
                    @else
                        -
                    @endif
                </td>

                <td style="text-align:left; font-size:7px; vertical-align: top;">
                    @foreach ($selectedFields as $field)
                        @if (array_key_exists($field, $dataLama))
                            <div>
                                <strong>{{ ucwords(str_replace('_',' ',$field)) }}:</strong>
                                {{ $dataLama[$field] }}
                            </div>
                        @endif
                    @endforeach
                </td>

                <td style="text-align:left; font-size:7px; vertical-align: top;">
                    @foreach ($selectedFields as $field)
                        @if (array_key_exists($field, $dataBaru))
                            <div>
                                <strong>{{ ucwords(str_replace('_',' ',$field)) }}:</strong>
                                {{ $dataBaru[$field] }}
                            </div>
                        @endif
                    @endforeach
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="7"
                    style="text-align:center; font-size:8px; padding:10px;">
                    Data tidak tersedia
                </td>
            </tr>
        @endforelse
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
