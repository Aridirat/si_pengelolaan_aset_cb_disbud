<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\Pemugaran;
use App\Models\Penghapusan;
use App\Models\Mutasi;
use App\Models\MutasiData;
use App\Constants\CagarBudayaBitmask;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        /* =========================
         * CAGAR BUDAYA (KONDISI)
         * ========================= */
        $cagarBudaya = [
            'baik' => CagarBudaya::where('kondisi', 'baik')->count(),
            'rusak_ringan' => CagarBudaya::where('kondisi', 'rusak ringan')->count(),
            'rusak_berat' => CagarBudaya::where('kondisi', 'rusak berat')->count(),
            'aktif' => CagarBudaya::where('status_penetapan', 'aktif')->count(),
            'terhapus' => CagarBudaya::where('status_penetapan', 'terhapus')->count(),
        ];

        /* =========================
         * PEMUGARAN (STATUS)
         * ========================= */
        $pemugaranProses = Pemugaran::selectRaw('status_pemugaran, COUNT(*) as total')
            ->groupBy('status_pemugaran')
            ->pluck('total', 'status_pemugaran');

        $pemugaranVerifikasi = Pemugaran::selectRaw('status_verifikasi, COUNT(*) as total')
            ->groupBy('status_verifikasi')
            ->pluck('total', 'status_verifikasi');

        $pemugaran = $pemugaranProses->merge($pemugaranVerifikasi);



        /* =========================
         * PENGHAPUSAN (STATUS)
         * ========================= */
        $penghapusanProses = Penghapusan::selectRaw('status_penghapusan, COUNT(*) as total')
            ->groupBy('status_penghapusan')
            ->pluck('total', 'status_penghapusan');

        $penghapusanVerifikasi = Penghapusan::selectRaw('status_verifikasi, COUNT(*) as total')
            ->groupBy('status_verifikasi')
            ->pluck('total', 'status_verifikasi');

        $penghapusan = $penghapusanProses->merge($penghapusanVerifikasi);



        /* =========================
         * MUTASI (STATUS)
         * ========================= */
        $mutasiProses = Mutasi::selectRaw('status_mutasi, COUNT(*) as total')
            ->groupBy('status_mutasi')
            ->pluck('total', 'status_mutasi');

        $mutasiVerifikasi = Mutasi::selectRaw('status_verifikasi, COUNT(*) as total')
            ->groupBy('status_verifikasi')
            ->pluck('total', 'status_verifikasi');

        $mutasiStatus = $mutasiProses->merge($mutasiVerifikasi);



        /* =========================
        * MUTASI DATA - FIELD YANG DIUBAH (BITMASK)
        * ========================= */
        $mutasiFieldCount = [];
        $totalMutasiData = MutasiData::count();
        
        foreach (CagarBudayaBitmask::FIELDS as $field => $bit) {
            $mutasiFieldCount[$field] = MutasiData::whereRaw(
                '(bitmask & ?) != 0',
                [$bit]
            )->count();
        }


        return view('pages.dashboard.index', compact(
            'cagarBudaya',
            'pemugaran',
            'penghapusan',
            'mutasiStatus',
            'mutasiFieldCount',
            'totalMutasiData'
        ));
    }
}