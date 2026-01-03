<?php

namespace App\Http\Controllers;

use App\Models\Penghapusan;
use App\Models\CagarBudaya;
use App\Models\MutasiData;
use App\Constants\CagarBudayaBitmask;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenghapusanController extends Controller
{
    /**
     * INDEX
     */
    public function index(Request $request)
    {
        $penghapusan = Penghapusan::with('cagarBudaya')
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Nama Cagar Budaya
                    $q->whereHas('cagarBudaya', function ($cb) use ($search) {
                        $cb->where('nama_cagar_budaya', 'like', "%{$search}%");
                    })

                    // Kondisi
                    ->orWhere('kondisi', 'like', "%{$search}%")

                    // Status Penghapusan
                    ->orWhere('status_penghapusan', 'like', "%{$search}%")

                    // Status Verifikasi
                    ->orWhere('status_verifikasi', 'like', "%{$search}%")

                    // Tanggal Verifikasi
                    ->orWhere('tanggal_verifikasi', 'like', '%' . $search . '%');
                });
            })
            ->when($request->kondisi, fn ($q) =>
                $q->where('kondisi', $request->kondisi)
            )
            ->when($request->status_penghapusan, fn ($q) =>
                $q->where('status_penghapusan', $request->status_penghapusan)
            )
            ->when($request->status_verifikasi, fn ($q) =>
                $q->where('status_verifikasi', $request->status_verifikasi)
            )
            ->latest('id_penghapusan')
            ->paginate(10)
            ->withQueryString();

        return view('pages.penghapusan.index', compact('penghapusan'));
    }


    /**
     * CREATE
     */
    public function create()
    {
        $cagarBudaya = CagarBudaya::where('status_penetapan', 'aktif')
            ->orderBy('nama_cagar_budaya')
            ->get();
        $penanggungJawab = User::orderBy('nama')->get();

        return view('pages.penghapusan.create', compact(
            'cagarBudaya',
            'penanggungJawab'
        ));
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_cagar_budaya'    => 'required|exists:cagar_budaya,id_cagar_budaya',
            'id'                 => 'required|exists:users,id',
            'kondisi'            => 'required|in:musnah,hilang,berubah wujud',
            'alasan_penghapusan' => 'required|string',
            'bukti_dokumentasi'  => 'nullable|url',
        ]);

        Penghapusan::create([
            'id_cagar_budaya'     => $request->id_cagar_budaya,
            'id'                  => $request->id,
            'kondisi'             => $request->kondisi,
            'alasan_penghapusan'  => $request->alasan_penghapusan,
            'bukti_dokumentasi'   => $request->bukti_dokumentasi,
            'status_penghapusan'  => 'pending',
            'status_verifikasi'   => 'menunggu',
            'tanggal_verifikasi'  => null,
            'dokumen_penghapusan' => null,
        ]);

        return redirect()
            ->route('penghapusan.index')
            ->with('success', 'Pengajuan penghapusan berhasil dikirim.');
    }

    /**
     * EDIT
     */
    public function edit(Penghapusan $penghapusan)
    {
        $cagarBudaya = CagarBudaya::orderBy('nama_cagar_budaya')->get();
        $penanggungJawab = User::orderBy('nama')->get();
        return view('pages.penghapusan.edit', compact(
            'penghapusan',
            'cagarBudaya',
            'penanggungJawab'
        ));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Penghapusan $penghapusan)
    {
        $request->validate([
            'id_cagar_budaya'    => 'required|exists:cagar_budaya,id_cagar_budaya',
            'id'                 => 'required|exists:users,id',
            'kondisi'            => 'required|in:musnah,hilang,berubah wujud',
            'alasan_penghapusan' => 'required|string',
            'bukti_dokumentasi'  => 'nullable|url',
        ]);

        $penghapusan->update([
            'id_cagar_budaya'    => $request->id_cagar_budaya,
            'id'                 => $request->id,
            'kondisi'            => $request->kondisi,
            'alasan_penghapusan' => $request->alasan_penghapusan,
            'bukti_dokumentasi'  => $request->bukti_dokumentasi,
        ]);

        return redirect()
            ->route('penghapusan.index')
            ->with('success', 'Data penghapusan berhasil diperbarui.');
    }

    public function verifikasi($id)
    {
        $penghapusan = Penghapusan::findOrFail($id);
        return view('pages.penghapusan.verifikasi', compact('penghapusan'));
    }

    public function verifikasiUpdate(Request $request, $id)
    {
        $penghapusan = Penghapusan::findOrFail($id);

        $validated = $request->validate([
            'status_penghapusan'  => 'required|in:pending,diproses,selesai',
            'status_verifikasi'   => 'required|in:menunggu,disetujui,ditolak',
            'dokumen_penghapusan' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $tanggalVerifikasi = in_array(
            $request->status_verifikasi,
            ['disetujui','ditolak']
        ) ? now() : null;

        // Upload DOKUMEN PENGHAPUSAN dengan nama asli + timestamp custom
        if ($request->hasFile('dokumen_penghapusan')) {
            $dokumenFile = $request->file('dokumen_penghapusan');

            $timestamp = Carbon::now()->format('mdyHisu');
            $dokumenName = $timestamp . '_' . $dokumenFile->getClientOriginalName();

            $dokumenPath = $dokumenFile->storeAs(
                'dokumen-penghapusan',
                $dokumenName,
                'public'
            );

            $validated['dokumen_penghapusan'] = $dokumenPath;
        }

        $penghapusan->update([
            'status_penghapusan' => $validated['status_penghapusan'],
            'status_verifikasi'  => $validated['status_verifikasi'],
            'tanggal_verifikasi' => $tanggalVerifikasi,
            'dokumen_penghapusan'=> $validated['dokumen_penghapusan'] ?? $penghapusan->dokumen_penghapusan,
        ]);

        // JIKA DISETUJUI → UPDATE CAGAR BUDAYA + MUTASI
        if ($request->status_verifikasi === 'disetujui') {

            $request->validate([
                'status_penetapan' => 'required|string',
            ]);

            $cagarBudaya = CagarBudaya::findOrFail($penghapusan->id_cagar_budaya);

            $nilaiLama = [
                'status_penetapan' => $cagarBudaya->status_penetapan,
            ];

            $nilaiBaru = [
                'status_penetapan' => $request->status_penetapan,
            ];

            $cagarBudaya->update($nilaiBaru);

            MutasiData::create([
                'id_cagar_budaya' => $cagarBudaya->id_cagar_budaya,
                'id' => Auth::id(),
                'tanggal_mutasi_data' => now(),
                'bitmask' =>
                    CagarBudayaBitmask::FIELDS['status_penetapan'],
                'nilai_lama' => json_encode($nilaiLama),
                'nilai_baru' => json_encode($nilaiBaru),
            ]);
        }

        return redirect()
            ->route('penghapusan.index')
            ->with('success', 'Data penghapusan berhasil diverifikasi.');
    }


    public function detail(Penghapusan $penghapusan)
    {
        return view('pages.penghapusan.detail', compact('penghapusan'));
    }

    public function cetakPdf(Request $request)
    {
        $penghapusan = Penghapusan::with('cagarBudaya')
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('cagarBudaya', function ($cb) use ($search) {
                        $cb->where('nama_cagar_budaya', 'like', "%{$search}%");
                    })
                    ->orWhere('kondisi', 'like', "%{$search}%")
                    ->orWhere('status_penghapusan', 'like', "%{$search}%")
                    ->orWhere('status_verifikasi', 'like', "%{$search}%")
                    ->orWhereDate('tanggal_verifikasi', $search);
                });
            })
            ->when($request->kondisi, fn ($q) =>
                $q->where('kondisi', $request->kondisi)
            )
            ->when($request->status_penghapusan, fn ($q) =>
                $q->where('status_penghapusan', $request->status_penghapusan)
            )
            ->when($request->status_verifikasi, fn ($q) =>
                $q->where('status_verifikasi', $request->status_verifikasi)
            )
            ->get();

        // TOTAL NILAI PEROLEHAN
        $totalNilai = $penghapusan->sum(function ($item) {
            return $item->cagarBudaya->nilai_perolehan ?? 0;
        });

        // DATA TTD
        $tanggalIndonesia = Carbon::now()
            ->locale('id')
            ->translatedFormat('d F Y');

        $namaPenandatangan = Auth::user()->nama;
        $penandatangan     = Auth::user()->id;

        $pdf = Pdf::loadView(
            'pages.penghapusan.cetak_pdf',
            compact(
                'penghapusan',
                'totalNilai',
                'tanggalIndonesia',
                'namaPenandatangan',
                'penandatangan'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-penghapusan.pdf');
    }
}