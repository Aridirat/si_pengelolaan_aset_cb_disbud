<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\CagarBudaya;
use App\Models\MutasiData;
use App\Constants\CagarBudayaBitmask;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{
    public function index(Request $request)
    {
        $mutasi = Mutasi::with('cagarBudaya')
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('cagarBudaya', function ($cb) use ($search) {
                        $cb->where('nama_cagar_budaya', 'like', "%{$search}%");
                    })
                    ->orWhere('kepemilikan_asal', 'like', "%{$search}%")
                    ->orWhere('kepemilikan_tujuan', 'like', "%{$search}%")
                    ->orWhere('status_mutasi', 'like', "%{$search}%")
                    ->orWhere('status_verifikasi', 'like', "%{$search}%")
                    ->orWhere('tanggal_pengajuan', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_verifikasi', 'like', '%' . $search . '%');
                });
            })

            // FILTER TERPISAH (dropdown)
            ->when($request->kepemilikan_asal, fn ($q) =>
                $q->where('kepemilikan_asal', $request->kepemilikan_asal)
            )
            ->when($request->kepemilikan_tujuan, fn ($q) =>
                $q->where('kepemilikan_tujuan', $request->kepemilikan_tujuan)
            )
            ->when($request->status_mutasi, fn ($q) =>
                $q->where('status_mutasi', $request->status_mutasi)
            )
            ->when($request->status_verifikasi, fn ($q) =>
                $q->where('status_verifikasi', $request->status_verifikasi)
            )

            ->latest('tanggal_pengajuan')
            ->paginate(10)
            ->withQueryString();

        return view('pages.mutasi.index', compact('mutasi'));
    }


    // ================= CREATE =================
    public function create()
    {
        $cagarBudaya = CagarBudaya::whereIn('status_penetapan', ['aktif', 'mutasi keluar'])
            ->whereDoesntHave('mutasi', function ($query) {
                $query->where('status_mutasi', 'diproses')
                    ->orWhere('status_verifikasi', 'menunggu');
            })
            ->orderBy('nama_cagar_budaya')
            ->get();




        // $cagarBudaya = CagarBudaya::orderBy('nama_cagar_budaya')->get();
        $penanggungJawab = User::orderBy('nama')->get();

        return view('pages.mutasi.create', compact(
            'cagarBudaya',
            'penanggungJawab'
        ));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cagar_budaya'     => 'required',
            'id'                 => 'required',
            'kepemilikan_asal'    => 'required|in:pemerintah,pribadi',
            'kepemilikan_tujuan'  => 'required|in:pemerintah,pribadi',
            'tanggal_pengajuan'  => 'required|date',
            'keterangan'         => 'required|string',
            'dokumen_pengajuan'  => 'required|file|mimes:pdf|max:5120',
        ]);

        // Upload DOKUMEN MUTASI dengan nama asli + timestamp custom
        if ($request->hasFile('dokumen_pengajuan')) {
            $dokumenFile = $request->file('dokumen_pengajuan');

            $timestamp = Carbon::now()->format('mdyHisu');
            $dokumenName = $timestamp . '_' . $dokumenFile->getClientOriginalName();

            $dokumenPath = $dokumenFile->storeAs(
                'dokumen-mutasi',
                $dokumenName,
                'public'
            );

            $validated['dokumen_pengajuan'] = $dokumenPath;
        }

        Mutasi::create([
            'id_cagar_budaya'     => $validated['id_cagar_budaya'],
            'id'                 => $validated['id'],
            'kepemilikan_asal'    => $validated['kepemilikan_asal'],
            'kepemilikan_tujuan'  => $validated['kepemilikan_tujuan'],
            'tanggal_pengajuan'  => $validated['tanggal_pengajuan'],
            'keterangan'         => $validated['keterangan'],
            'dokumen_pengajuan'  => $validated['dokumen_pengajuan'],
            'status_mutasi'      => 'pending',
            'status_verifikasi'  => 'menunggu',
        ]);

        return redirect()
            ->route('mutasi.index')
            ->with('success', 'Pengajuan mutasi berhasil dikirim.');
    }

    public function edit($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $cagarBudaya = CagarBudaya::orderBy('nama_cagar_budaya')->get();
        $penanggungJawab = User::orderBy('nama')->get();

        return view('pages.mutasi.edit', compact(
            'mutasi',
            'cagarBudaya',
            'penanggungJawab'
        ));
    }

    public function update(Request $request, $id)
    {
        $mutasi = Mutasi::findOrFail($id);

        $validated = $request->validate([
            'id_cagar_budaya'      => 'required',
            'id'                  => 'required',
            'kepemilikan_asal'     => 'required|in:pemerintah,pribadi',
            'kepemilikan_tujuan'   => 'required|in:pemerintah,pribadi',
            'tanggal_pengajuan'   => 'required|date',
            'keterangan'          => 'required|string',
            'dokumen_pengajuan'   => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Upload ulang dokumen pengajuan (jika ada)
        if ($request->hasFile('dokumen_pengajuan')) {
            $dokumenFile = $request->file('dokumen_pengajuan');

            $timestamp = Carbon::now()->format('mdyHisu');
            $dokumenName = $timestamp . '_' . $dokumenFile->getClientOriginalName();

            $dokumenPath = $dokumenFile->storeAs(
                'dokumen-mutasi',
                $dokumenName,
                'public'
            );

            $validated['dokumen_pengajuan'] = $dokumenPath;
        }

        $mutasi->update([
            'id_cagar_budaya'     => $validated['id_cagar_budaya'],
            'id'                 => $validated['id'],
            'kepemilikan_asal'    => $validated['kepemilikan_asal'],
            'kepemilikan_tujuan'  => $validated['kepemilikan_tujuan'],
            'tanggal_pengajuan'  => $validated['tanggal_pengajuan'],
            'keterangan'         => $validated['keterangan'],
            'dokumen_pengajuan'  => $validated['dokumen_pengajuan'] ?? $mutasi->dokumen_pengajuan,
        ]);

        return redirect()
            ->route('mutasi.index')
            ->with('success', 'Data mutasi berhasil diperbarui.');
    }

    public function verifikasi($id)
    {
        $mutasi = Mutasi::findOrFail($id);

        return view('pages.mutasi.verifikasi', compact('mutasi'));
    }

    public function verifikasiUpdate(Request $request, $id)
    {
        $mutasi = Mutasi::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI DASAR
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'status_mutasi'      => 'required|in:pending,diproses,selesai',
            'status_verifikasi'  => 'required|in:menunggu,disetujui,ditolak',
            'dokumen_pengesahan' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        /*
        |--------------------------------------------------------------------------
        | TANGGAL VERIFIKASI
        |--------------------------------------------------------------------------
        */
        $tanggalVerifikasi = in_array(
            $request->status_verifikasi,
            ['disetujui', 'ditolak']
        ) ? now() : null;

        /*
        |--------------------------------------------------------------------------
        | UPLOAD DOKUMEN PENGESAHAN
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('dokumen_pengesahan')) {
            $dokumenFile = $request->file('dokumen_pengesahan');

            $timestamp   = Carbon::now()->format('mdyHisu');
            $dokumenName = $timestamp . '_' . $dokumenFile->getClientOriginalName();

            $dokumenPath = $dokumenFile->storeAs(
                'dokumen-pengesahan',
                $dokumenName,
                'public'
            );

            $validated['dokumen_pengesahan'] = $dokumenPath;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA MUTASI
        |--------------------------------------------------------------------------
        */
        $mutasi->update([
            'status_mutasi'      => $request->status_mutasi,
            'status_verifikasi'  => $request->status_verifikasi,
            'tanggal_verifikasi' => $tanggalVerifikasi,
            'dokumen_pengesahan' =>
                $validated['dokumen_pengesahan']
                ?? $mutasi->dokumen_pengesahan,
        ]);

        /*
        |--------------------------------------------------------------------------
        | JIKA VERIFIKASI DISETUJUI
        |--------------------------------------------------------------------------
        */
        if ($request->status_verifikasi === 'disetujui') {

            /*
            |--------------------------------------------------
            | VALIDASI TAMBAHAN
            |--------------------------------------------------
            */
            $request->validate([
                'status_kepemilikan' => 'required|in:pemerintah,pribadi',
            ]);

            $cagarBudaya = CagarBudaya::findOrFail($mutasi->id_cagar_budaya);

            /*
            |--------------------------------------------------
            | TENTUKAN STATUS PENETAPAN FINAL (RULE BISNIS)
            |--------------------------------------------------
            */
            $asal   = $mutasi->kepemilikan_asal;
            $tujuan = $mutasi->kepemilikan_tujuan;

            if ($asal === 'pribadi' && $tujuan === 'pemerintah') {
                // Mutasi masuk → aktif
                $statusPenetapan = 'aktif';

            } elseif ($asal === 'pemerintah' && $tujuan === 'pribadi') {
                // Mutasi keluar
                $statusPenetapan = 'mutasi keluar';

            } elseif ($asal === 'pemerintah' && $tujuan === 'pemerintah') {
                // Bisa dipilih
                $request->validate([
                    'status_penetapan' => 'required|in:aktif,mutasi keluar',
                ]);

                $statusPenetapan = $request->status_penetapan;

            } else {
                abort(400, 'Kombinasi kepemilikan tidak valid');
            }

            /*
            |--------------------------------------------------
            | SIMPAN NILAI LAMA & BARU (AUDIT TRAIL)
            |--------------------------------------------------
            */
            $nilaiLama = [
                'status_kepemilikan' => $cagarBudaya->status_kepemilikan,
                'status_penetapan'   => $cagarBudaya->status_penetapan,
            ];

            $nilaiBaru = [
                'status_kepemilikan' => $request->status_kepemilikan,
                'status_penetapan'   => $statusPenetapan,
            ];

            /*
            |--------------------------------------------------
            | UPDATE CAGAR BUDAYA
            |--------------------------------------------------
            */
            $cagarBudaya->update($nilaiBaru);

            /*
            |--------------------------------------------------
            | SIMPAN KE MUTASI DATA
            |--------------------------------------------------
            */
            MutasiData::create([
                'id_cagar_budaya'    => $cagarBudaya->id_cagar_budaya,
                'id'                 => Auth::id(),
                'tanggal_mutasi_data'=> now(),
                'bitmask'            =>
                    CagarBudayaBitmask::FIELDS['status_kepemilikan']
                    | CagarBudayaBitmask::FIELDS['status_penetapan'],
                'nilai_lama'         => json_encode($nilaiLama),
                'nilai_baru'         => json_encode($nilaiBaru),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('mutasi.index')
            ->with('success', 'Mutasi berhasil diverifikasi.');
    }


    public function detail(Mutasi $mutasi)
    {
        return view('pages.mutasi.detail', compact('mutasi'));
    }

    public function cetakPdf(Request $request)
    {
        $mutasi = Mutasi::with('cagarBudaya')
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;
                $query->whereHas('cagarBudaya', function ($q) use ($search) {
                    $q->where('nama_cagar_budaya', 'like', "%{$search}%");
                });
            })
            ->when($request->kepemilikan_asal, fn ($q) =>
                $q->where('kepemilikan_asal', $request->kepemilikan_asal)
            )
            ->when($request->kepemilikan_tujuan ?? null, fn ($q) =>
                $q->where('kepemilikan_tujuan', $request->kepemilikan_tujuan)
            )
            ->when($request->status_mutasi, fn ($q) =>
                $q->where('status_mutasi', $request->status_mutasi)
            )
            ->when($request->status_verifikasi, fn ($q) =>
                $q->where('status_verifikasi', $request->status_verifikasi)
            )
            ->get();

        // TOTAL NILAI PEROLEHAN
        $totalNilai = $mutasi->sum(function ($item) {
            return $item->cagarBudaya->nilai_perolehan ?? 0;
        });

        // DATA TTD
        $tanggalIndonesia = Carbon::now()->locale('id')->translatedFormat('d F Y');
        $namaPenandatangan = Auth::user()->nama;
        $penandatangan = Auth::user()->id;

        // JUMLAH DATA
        $totalData = $mutasi->count();

        // KEPEMILIKAN ASAL
        $asalPemerintah = $mutasi->where('kepemilikan_asal', 'pemerintah')->count();
        $asalPribadi = $mutasi->where('kepemilikan_asal', 'pribadi')->count();

        // KEPEMILIKAN TUJUAN
        $tujuanPemerintah = $mutasi->where('kepemilikan_tujuan', 'pemerintah')->count();
        $tujuanPribadi = $mutasi->where('kepemilikan_tujuan', 'pribadi')->count();

        // STATUS MUTASI
        $mutasiPending = $mutasi->where('status_mutasi', 'pending')->count();
        $mutasiDiproses = $mutasi->where('status_mutasi', 'diproses')->count();
        $mutasiSelesai = $mutasi->where('status_mutasi', 'selesai')->count();

        // STATUS VERIFIKASI
        $verifMenunggu = $mutasi->where('status_verifikasi', 'menunggu')->count();
        $verifDitolak = $mutasi->where('status_verifikasi', 'ditolak')->count();
        $verifDisetujui = $mutasi->where('status_verifikasi', 'disetujui')->count();

        
        $pdf = Pdf::loadView('pages.mutasi.cetak_pdf', compact(
            'mutasi',
            'totalNilai',
            'tanggalIndonesia',
            'namaPenandatangan',
            'penandatangan',
            'totalData',
            'asalPemerintah',
            'asalPribadi',
            'tujuanPemerintah',
            'tujuanPribadi',
            'mutasiPending',
            'mutasiDiproses',
            'mutasiSelesai',
            'verifMenunggu',
            'verifDitolak',
            'verifDisetujui'
        ))->setPaper('a4', 'landscape');


        return $pdf->stream('laporan-mutasi.pdf');
    }
}