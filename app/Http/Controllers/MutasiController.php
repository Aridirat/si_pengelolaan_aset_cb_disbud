<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\CagarBudaya;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $cagarBudaya = CagarBudaya::orderBy('nama_cagar_budaya')->get();
        $penanggungJawab = User::orderBy('nama')->get();

        return view('pages.mutasi.create', compact(
            'cagarBudaya',
            'penanggungJawab'
        ));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'id_cagar_budaya'     => 'required',
            'id'                 => 'required',
            'kepemilikan_asal'       => 'required|in:pemerintah,pribadi',
            'kepemilikan_tujuan'     => 'required|in:pemerintah,pribadi',
            'tanggal_pengajuan'  => 'required|date',
            'keterangan'=> 'required|string',
            'dokumen_pengajuan'  => 'required|file|mimes:pdf|max:5120',
        ]);

        $dokumenPath = $request->file('dokumen_pengajuan')
            ->store('dokumen-mutasi', 'public');

        Mutasi::create([
            'id_cagar_budaya'      => $request->id_cagar_budaya,
            'id'                  => $request->id,
            'kepemilikan_asal'        => $request->kepemilikan_asal,
            'kepemilikan_tujuan'      => $request->kepemilikan_tujuan,
            'tanggal_pengajuan'   => $request->tanggal_pengajuan,
            'keterangan' => $request->keterangan,
            'dokumen_pengajuan'   => $dokumenPath,
            'status_mutasi'       => 'pending',
            'status_verifikasi'   => 'menunggu',
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

        $request->validate([
            'id_cagar_budaya'      => 'required',
            'id'                  => 'required',
            'kepemilikan_asal'     => 'required|in:pemerintah,pribadi',
            'kepemilikan_tujuan'   => 'required|in:pemerintah,pribadi',
            'tanggal_pengajuan'    => 'required|date',
            'keterangan'           => 'required|string',
            'dokumen_pengajuan'    => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('dokumen_pengajuan')) {
            $path = $request->file('dokumen_pengajuan')
                ->store('dokumen-mutasi', 'public');
            $mutasi->dokumen_pengajuan = $path;
        }

        $mutasi->update([
            'id_cagar_budaya'     => $request->id_cagar_budaya,
            'id'                 => $request->id,
            'kepemilikan_asal'    => $request->kepemilikan_asal,
            'kepemilikan_tujuan'  => $request->kepemilikan_tujuan,
            'tanggal_pengajuan'   => $request->tanggal_pengajuan,
            'keterangan'          => $request->keterangan,
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

        $request->validate([
            'status_mutasi'        => 'required|in:pending,diproses,selesai',
            'status_verifikasi'    => 'required|in:menunggu,disetujui,ditolak',
            'tanggal_verifikasi'   => 'required|date',
            'dokumen_pengesahan'   => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('dokumen_pengesahan')) {
            $path = $request->file('dokumen_pengesahan')
                ->store('dokumen-pengesahan', 'public');
            $mutasi->dokumen_pengesahan = $path;
        }

        $mutasi->update([
            'status_mutasi'       => $request->status_mutasi,
            'status_verifikasi'   => $request->status_verifikasi,
            'tanggal_verifikasi'  => $request->tanggal_verifikasi,
        ]);

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
            ->when($request->kepemilikanikan_tujuan ?? null, fn ($q) =>
                $q->where('kepemilikan_tujuan', $request->kepemilikan_tujuan)
            )
            ->when($request->status_mutasi, fn ($q) =>
                $q->where('status_mutasi', $request->status_mutasi)
            )
            ->get();

        // TOTAL NILAI PEROLEHAN
        $totalNilai = $mutasi->sum(function ($item) {
            return $item->cagarBudaya->nilai_perolehan ?? 0;
        });

        // DATA TTD
        $tanggalIndonesia = Carbon::now()->locale('id')->translatedFormat('d F Y');
        $namaPenandatangan = auth()->user()->nama;
        $penandatangan = auth()->user()->id;

        $pdf = Pdf::loadView('pages.mutasi.cetak_pdf', compact(
            'mutasi',
            'totalNilai',
            'tanggalIndonesia',
            'namaPenandatangan',
            'penandatangan'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-mutasi.pdf');
    }
}