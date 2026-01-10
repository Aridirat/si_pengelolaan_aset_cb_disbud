<?php

namespace App\Http\Controllers;
use App\Models\MutasiData;
use App\Constants\CagarBudayaBitmask;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                foreach (CagarBudayaBitmask::FIELDS as $field => $bit) {
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
        $fields = $request->input('fields', []);

        $query = MutasiData::with(['cagarBudaya','user'])
            ->orderBy('tanggal_mutasi_data','desc');

        if (!empty($fields)) {
            $query->where(function ($q) use ($fields) {
                foreach ($fields as $field) {
                    if (isset(CagarBudayaBitmask::FIELDS[$field])) {
                        $bit = CagarBudayaBitmask::FIELDS[$field];
                        $q->orWhereRaw('bitmask & ? > 0', [$bit]);
                    }
                }
            });
        }

        $mutasiData = $query->get();

        /* ===============================
        HITUNG JUMLAH PER FIELD
        =============================== */
        $fieldCounts = [];

        foreach ($mutasiData as $item) {
            $changedFields = CagarBudayaBitmask::decodeBitmask($item->bitmask);

            foreach ($changedFields as $field) {
                // jika user memilih field tertentu
                if (!empty($fields) && !in_array($field, $fields)) {
                    continue;
                }

                $fieldCounts[$field] = ($fieldCounts[$field] ?? 0) + 1;
            }
        }

        return Pdf::loadView('pages.mutasi_data.cetak_pdf', [
            'mutasiData' => $mutasiData,
            'selectedFields' => $fields,
            'fieldCounts' => $fieldCounts, // <<< KIRIM KE VIEW
            'tanggal' => now()->locale('id')->isoFormat('D MMMM YYYY'),
            'penandatangan' => Auth::user()->id,
            'namaPenandatangan' => Auth::user()->nama,
        ])->setPaper('A4','landscape')
        ->stream();
    }



}