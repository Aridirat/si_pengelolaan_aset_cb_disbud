<?php

namespace App\Http\Controllers;
use App\Models\MutasiData;
use App\Constants\CagarBudayaBitmask;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MutasiDataController extends Controller
{
    public function index(Request $request)
    {
        $query = MutasiData::with(['cagarBudaya', 'user'])
            ->orderBy('tanggal_mutasi_data', 'desc');

        // FILTER FIELD YANG DIMUTASI
        if ($request->filled('field')) {
            $field = $request->field;

            if (array_key_exists($field, CagarBudayaBitmask::FIELDS)) {
                $bit = CagarBudayaBitmask::FIELDS[$field];

                $query->whereRaw('bitmask & ? > 0', [$bit]);
            }
        }

        // SEARCH
        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $query->where(function ($q) use ($search) {

                // 1. Cari Nama Cagar Budaya
                $q->whereHas('cagarBudaya', function ($cb) use ($search) {
                    $cb->where('nama_cagar_budaya', 'like', "%{$search}%");
                });

                // 2. Cari Nama Penanggung Jawab
                $q->orWhereHas('user', function ($u) use ($search) {
                    $u->where('nama', 'like', "%{$search}%");
                });

                // 3. Cari Field yang Dimutasi (bitmask)
                foreach (\App\Constants\CagarBudayaBitmask::FIELDS as $field => $bit) {
                    if (str_contains($field, $search)) {
                        $q->orWhereRaw('bitmask & ? > 0', [$bit]);
                    }
                }
            });
        }

        $mutasiData = $query->paginate(10)->withQueryString();

        return view('pages.mutasi_data.index', [
            'mutasi_data' => $mutasiData,
            'search' => $request->search,
        ]);
    }


    public function detail($id)
    {
        $data = MutasiData::with(['cagarBudaya', 'user'])->findOrFail($id);
        return view('pages.mutasi_data.detail', compact('data'));
    }

    public function cetakPdf(Request $request)
    {
        $query = MutasiData::with(['cagarBudaya', 'user'])
            ->orderBy('tanggal_mutasi_data', 'desc');

        // Filter field
        if ($request->filled('field')) {
            $field = $request->field;
            if (array_key_exists($field, CagarBudayaBitmask::FIELDS)) {
                $bit = CagarBudayaBitmask::FIELDS[$field];
                $query->whereRaw('bitmask & ? > 0', [$bit]);
            }
        }

        // Filter search
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereHas('cagarBudaya', fn($cb) => $cb->where('nama_cagar_budaya', 'like', "%$search%"))
                ->orWhereHas('user', fn($u) => $u->where('nama', 'like', "%$search%"));

                foreach (CagarBudayaBitmask::FIELDS as $field => $bit) {
                    if (str_contains($field, $search)) {
                        $q->orWhereRaw('bitmask & ? > 0', [$bit]);
                    }
                }
            });
        }

        $mutasiData = $query->get();

        $tanggal = Carbon::now();
        $tanggalIndonesia = $tanggal->locale('id')->isoFormat('D MMMM YYYY');

        $pdf = Pdf::loadView('pages.mutasi_data.cetak_pdf', [
            'mutasiData' => $mutasiData,
            'tanggal' => $tanggalIndonesia,
            'penandatangan' => auth()->user()->id,
            'namaPenandatangan' => auth()->user()->nama,
        ])->setPaper('A4', 'landscape');

        // Bisa stream dulu
        return $pdf->stream('Mutasi_Data_' . $tanggal->format('dmy') . '.pdf');
    }

}