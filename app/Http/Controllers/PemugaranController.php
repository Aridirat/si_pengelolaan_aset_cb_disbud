<?php

namespace App\Http\Controllers;

use App\Models\Pemugaran;
use App\Models\CagarBudaya;
use App\Models\User;   
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemugaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemugaran::with('cagarBudaya');

        // Filter pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('cagarBudaya', function ($cb) use ($searchTerm) {
                    $cb->where('nama_cagar_budaya', 'like', '%' . $searchTerm . '%');
                })->orWhere('kondisi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('status_pemugaran', 'like', '%' . $searchTerm . '%')
                  ->orWhere('status_verifikasi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('biaya_pemugaran', 'like', '%' . $searchTerm . '%')
                  ->orWhere('tanggal_pengajuan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('tanggal_selesai', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter status pemugaran
        if ($request->filled('status_pemugaran')) {
            $query->where('status_pemugaran', $request->status_pemugaran);
        }

        $pemugaran = $query
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(10)
            ->withQueryString(); // agar filter tidak hilang saat pagination

        return view('pages.pemugaran.index', [
            'pemugaran' => $pemugaran,
            'search'    => $request->search
        ]);
    }

    public function create()
    {
        $cagarBudaya = CagarBudaya::orderBy('nama_cagar_budaya')->get();
        $penanggungJawab = User::orderBy('nama')->get();

        return view('pages.pemugaran.create', compact(
            'cagarBudaya',
            'penanggungJawab'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cagar_budaya' => 'required',
            'id' => 'required',
            'kondisi' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'deskripsi_pengajuan' => 'required|string',
            'biaya_pemugaran' => 'required|numeric',
            'proposal_pengajuan' => 'required|file|mimes:pdf|max:5120',
        ]);

        // Upload PROPOSAL PEMUGARAN dengan nama asli
        if ($request->hasFile('proposal_pengajuan')) {
            $proposalFile = $request->file('proposal_pengajuan');

            $timestamp = Carbon::now()->format('mdyHisu');
            $proposalName = $timestamp . '_' . $proposalFile->getClientOriginalName();

            $proposalPath = $proposalFile->storeAs(
                'proposal-pemugaran',
                $proposalName,
                'public'
            );

            $validated['proposal_pengajuan'] = $proposalPath;
        }

        Pemugaran::create([
            'id_cagar_budaya' => $validated['id_cagar_budaya'],
            'id' => $validated['id'],
            'kondisi' => $validated['kondisi'],
            'tanggal_pengajuan' => $validated['tanggal_pengajuan'],
            'deskripsi_pengajuan' => $validated['deskripsi_pengajuan'],
            'biaya_pemugaran' => $validated['biaya_pemugaran'],
            'proposal_pengajuan' => $validated['proposal_pengajuan'],
            'status_pemugaran' => 'pending',
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()
            ->route('pemugaran.index')
            ->with('success', 'Pengajuan pemugaran berhasil dikirim.');
    }


    public function edit(Pemugaran $pemugaran)
    {
        $cagarBudaya = CagarBudaya::orderBy('nama_cagar_budaya')->get();
        $penanggungJawab = User::orderBy('nama')->get();

        return view('pages.pemugaran.edit', compact(
            'pemugaran',
            'cagarBudaya',
            'penanggungJawab'
        ));
    }

    public function update(Request $request, Pemugaran $pemugaran)
    {
        $request->validate([
            'id_cagar_budaya' => 'required',
            'id' => 'required',
            'kondisi' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'deskripsi_pengajuan' => 'required|string',
            'biaya_pemugaran' => 'required|numeric',
            'proposal_pengajuan' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Jika upload file baru
        if ($request->hasFile('proposal_pengajuan')) {
            $proposalPath = $request->file('proposal_pengajuan')
                ->store('proposal-pemugaran', 'public');

            $pemugaran->proposal_pengajuan = $proposalPath;
        }

        $pemugaran->update([
            'id_cagar_budaya' => $request->id_cagar_budaya,
            'id' => $request->id,
            'kondisi' => $request->kondisi,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'deskripsi_pengajuan' => $request->deskripsi_pengajuan,
            'biaya_pemugaran' => $request->biaya_pemugaran,
        ]);

        return redirect()
            ->route('pemugaran.index')
            ->with('success', 'Data pemugaran berhasil diperbarui.');
    }

    //Verifikasi pemugaran
    public function verifikasi(Pemugaran $pemugaran)
    {
        return view('pages.pemugaran.verifikasi', compact('pemugaran'));
    }

    public function verifikasiUpdate(Request $request, Pemugaran $pemugaran)
    {
        $validated = $request->validate([
            'status_pemugaran' => 'required|string',
            'status_verifikasi' => 'required|string',
            'tanggal_verifikasi' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_verifikasi',
            'bukti_dokumentasi' => 'nullable|url',
            'laporan_pertanggungjawaban' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Upload LAPORAN PERTANGGUNGJAWABAN dengan nama asli + timestamp custom
        if ($request->hasFile('laporan_pertanggungjawaban')) {
            $laporanFile = $request->file('laporan_pertanggungjawaban');

            $timestamp = Carbon::now()->format('mdyHisu');
            $laporanName = $timestamp . '_' . $laporanFile->getClientOriginalName();

            $laporanPath = $laporanFile->storeAs(
                'laporan-pemugaran',
                $laporanName,
                'public'
            );

            $validated['laporan_pertanggungjawaban'] = $laporanPath;
        }

        $pemugaran->update([
            'status_pemugaran' => $validated['status_pemugaran'],
            'status_verifikasi' => $validated['status_verifikasi'],
            'tanggal_verifikasi' => $validated['tanggal_verifikasi'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'bukti_dokumentasi' => $validated['bukti_dokumentasi'],
            'laporan_pertanggungjawaban' => $validated['laporan_pertanggungjawaban'] ?? $pemugaran->laporan_pertanggungjawaban,
        ]);

        return redirect()
            ->route('pemugaran.index')
            ->with('success', 'Data verifikasi pemugaran berhasil disimpan.');
    }

    public function detail(Pemugaran $pemugaran)
    {
        return view('pages.pemugaran.detail', compact('pemugaran'));
    }

    public function cetakPdf(Request $request)
    {
        $query = Pemugaran::with(['cagarBudaya']);

        /* ======================
        | SEARCH
        ====================== */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('cagarBudaya', function ($cb) use ($search) {
                    $cb->where('nama_cagar_budaya', 'like', "%{$search}%");
                })
                ->orWhere('kondisi', 'like', "%{$search}%")
                ->orWhere('status_pemugaran', 'like', "%{$search}%")
                ->orWhere('status_verifikasi', 'like', "%{$search}%");
            });
        }

        /* ======================
        | FILTER KONDISI
        ====================== */
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        /* ======================
        | FILTER STATUS PEMUGARAN
        ====================== */
        if ($request->filled('status_pemugaran')) {
            $query->where('status_pemugaran', $request->status_pemugaran);
        }

        $pemugaran = $query
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        /* ======================
        | TOTAL BIAYA PEMUGARAN
        ====================== */
        $totalBiaya = $pemugaran->sum('biaya_pemugaran');

        /* ======================
        | DATA TANDA TANGAN
        ====================== */

        $pdf = Pdf::loadView('pages.pemugaran.cetak_pdf', [
            'pemugaran' => $pemugaran,
            'totalBiaya' => $totalBiaya,
            'tanggal' => now()->format('d F Y'),
            'penandatangan' => Auth::user()->id,
            'namaPenandatangan' => Auth::user()->nama,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('laporan-pemugaran.pdf');
    }

}