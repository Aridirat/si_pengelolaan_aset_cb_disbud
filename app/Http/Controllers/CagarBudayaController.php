<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\MutasiData;
use App\Constants\CagarBudayaBitmask;
use App\Constants\CagarBudayaFilter;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CagarBudayaController extends Controller
{
    /**
     * Menampilkan seluruh data cagar budaya.
     */
    // public function index()
    // {
    //     $data = CagarBudaya::all();
        
    // }
    public function index(Request $request)
{
    $query = CagarBudaya::query();
    
    // FILTER KATEGORI (ENUM)
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // FILTER KONDISI (ENUM)
    if ($request->filled('kondisi')) {
        $query->where('kondisi', $request->kondisi);
    }

    // FILTER LOKASI BERDASARKAN KECAMATAN (SUBSTRING)
    if ($request->filled('lokasi')) {
        $query->whereRaw(
            'LOWER(lokasi) LIKE ?',
            ['%' . strtolower($request->lokasi) . '%']
        );
    }

        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_cagar_budaya', 'like', '%' . $search . '%')
                ->orWhere('kategori', 'like', '%' . $search . '%')
                ->orWhere('lokasi', 'like', '%' . $search . '%')
                ->orWhere('kondisi', 'like', '%' . $search . '%')
                ->orWhere('nilai_perolehan', 'like', '%' . $search . '%');
            });
        }

        $allResults = $query->get();
        $cagar_budaya = $query->orderBy('id_cagar_budaya', 'desc')->paginate(perPage: 10);

    $kategoriList = CagarBudaya::select('kategori')->distinct()->pluck('kategori');
    $lokasiList = CagarBudaya::select('lokasi')->distinct()->pluck('lokasi');
    $kondisiList = CagarBudaya::select('kondisi')->distinct()->pluck('kondisi');

    $data = $query->paginate(10)->withQueryString();

    return view('pages.cagar_budaya.index', [
        'cagar_budaya' => $cagar_budaya,
        'data' => $data,
        'kategoriList' => CagarBudayaFilter::KATEGORI,
        'lokasiList'   => CagarBudayaFilter::KECAMATAN_BADUNG,
        'kondisiList'  => CagarBudayaFilter::KONDISI,
        "allResults" => $allResults,
        "search" => $request->input('search', '')
    ]);
    }

    
    public function create()
    {
        return view('pages.cagar_budaya.create');
    }
    /**
     * Menyimpan data cagar budaya baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cagar_budaya' => 'required|numeric|unique:cagar_budaya,id_cagar_budaya',
            'nama_cagar_budaya' => 'required|string',
            'kategori' => 'required|in:benda,bangunan,struktur,situs,kawasan',
            'lokasi' => 'required|string',
            'tanggal_pertama_pencatatan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'status_kepemilikan' => 'required|in:pemerintah,pribadi',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2 MB
            'deskripsi' => 'required|string',
            'dokumen_kajian' => 'nullable|mimes:pdf|max:5120', // 5 MB
        ]);

        // Upload FOTO
    if ($request->hasFile('foto')) {
        $fotoFile = $request->file('foto');
        $fotoName = $fotoFile->getClientOriginalName();

        $fotoPath = $fotoFile->storeAs(
            'cagar_budaya/foto',
            $fotoName,
            'public'
        );

        $validated['foto'] = $fotoPath;
    }

    // Upload DOKUMEN KAJIAN
    if ($request->hasFile('dokumen_kajian')) {
        $dokumenFile = $request->file('dokumen_kajian');
        $dokumenName = $dokumenFile->getClientOriginalName();

        $dokumenPath = $dokumenFile->storeAs(
            'dokumen_kajian',
            $dokumenName,
            'public'
        );

        $validated['dokumen_kajian'] = $dokumenPath;
    }

    CagarBudaya::create($validated);

    return redirect()
        ->route('cagar_budaya.index')
        ->with('success', 'Data cagar budaya berhasil ditambahkan.');
    }   

    /**
     * Menampilkan detail data cagar budaya.
     */
    public function detail($id)
    {
        $data = CagarBudaya::findOrFail($id);
        return view('pages.cagar_budaya.detail', compact('data'));
    }

    /**
     * Menampilkan form edit data cagar budaya.
     */
    public function edit($id)
    {
        $data = CagarBudaya::findOrFail($id);

        return view('pages.cagar_budaya.edit', compact('data'));
    }

    /**
     * Memperbarui data cagar budaya.
     */

    //Melakukan Mutasi Data

    public function update(Request $request, $id)
    {   
        $fields = [
        'nama_cagar_budaya',
        'kategori',
        'lokasi',
        'tanggal_pertama_pencatatan',
        'nilai_perolehan',
        'status_kepemilikan',
        'kondisi',
        'deskripsi',
        'foto',
        'dokumen_kajian',
        ];
        
        $data = CagarBudaya::findOrFail($id);
        $original = $data->getOriginal();

        $validated = $request->validate([
            'nama_cagar_budaya' => 'sometimes|string',
            'kategori' => 'sometimes|in:benda,bangunan,struktur,situs,kawasan',
            'lokasi' => 'sometimes|string',
            'tanggal_pertama_pencatatan' => 'sometimes|date',
            'nilai_perolehan' => 'sometimes|numeric',
            'status_kepemilikan' => 'sometimes|in:pemerintah,pribadi',
            'kondisi' => 'sometimes|in:baik,rusak ringan,rusak berat',
            'deskripsi' => 'sometimes|string',
            'foto' => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumen_kajian' => 'sometimes|mimes:pdf|max:5120',
        ]);

        $nilaiLama = [];
        $nilaiBaru = [];
        $bitmask = 0;

        if ($request->hasFile('foto')) {
            $bitmask |= CagarBudayaBitmask::FIELDS['foto'];

            $nilaiLama['foto'] = $original['foto']
                ? basename($original['foto'])
                : null;

            $nilaiBaru['foto'] = $request->file('foto')->getClientOriginalName();
        }


        if ($request->hasFile('dokumen_kajian')) {
            $bitmask |= CagarBudayaBitmask::FIELDS['dokumen_kajian'];

            $nilaiLama['dokumen_kajian'] = $original['dokumen_kajian']
                ? basename($original['dokumen_kajian'])
                : null;

            $nilaiBaru['dokumen_kajian'] = $request->file('dokumen_kajian')->getClientOriginalName();
        }


        foreach (CagarBudayaBitmask::FIELDS as $field => $bit) {

            if (in_array($field, ['foto', 'dokumen_kajian'])) {
            continue;
            }

            if (array_key_exists($field, $validated)) {

                $nilaiRequest = $validated[$field];
                $nilaiDatabase = $data->$field;

                // Normalisasi string
                if (is_string($nilaiRequest)) {
                    $nilaiRequest = trim($nilaiRequest);
                }
                if (is_string($nilaiDatabase)) {
                    $nilaiDatabase = trim($nilaiDatabase);
                }

                // Khusus tanggal
                if ($nilaiDatabase instanceof \Carbon\Carbon) {
                    $nilaiDatabase = $nilaiDatabase->format('Y-m-d');
                }

                if ($nilaiRequest != $nilaiDatabase) {
                    $bitmask |= $bit;
                    $nilaiLama[$field] = $data->$field;
                    $nilaiBaru[$field] = $validated[$field];
                }
            }
        }
        
        //Jika tidak ada perubahan
        if (empty($nilaiLama)) {
            return redirect()
                ->back()
                ->with('info', 'Tidak ada perubahan data yang disimpan.');
        }

        if ($request->hasFile('foto')) {

        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
            }

            $fotoFile = $request->file('foto');
            $fotoName = $fotoFile->getClientOriginalName();

            $validated['foto'] = $fotoFile->storeAs(
                'cagar_budaya/foto',
                $fotoName,
                'public'
            );
        }

        if ($request->hasFile('dokumen_kajian')) {

        if ($data->dokumen_kajian && Storage::disk('public')->exists($data->dokumen_kajian)) {
            Storage::disk('public')->delete($data->dokumen_kajian);
            }

            $dokumenFile = $request->file('dokumen_kajian');
            $dokumenName = $dokumenFile->getClientOriginalName();

            $validated['dokumen_kajian'] = $dokumenFile->storeAs(
                'dokumen_kajian',
                $dokumenName,
                'public'
            );
        }
        
        //Jika ada perubahan, simpan mutasi
        if (!empty($nilaiLama)) {
            MutasiData::create([
                'id_cagar_budaya'   => $data->id_cagar_budaya,
                'id'                => Auth::user()->id,
                'tanggal_mutasi_data' => now(),
                'bitmask'           => $bitmask,
                'nilai_lama'        => json_encode($nilaiLama),
                'nilai_baru'        => json_encode($nilaiBaru),
            ]);
        }
        
        // Update data utama
        $data->update($validated);

        return redirect()
            ->route('cagar_budaya.index', $data->id_cagar_budaya)
            ->with('success', 'Data berhasil diperbarui dan mutasi tercatat.');
        }


    public function cetakPdf(Request $request)
    {
        $query = CagarBudaya::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('lokasi')) {
            $query->whereRaw(
                'LOWER(lokasi) LIKE ?',
                ['%' . strtolower($request->lokasi) . '%']
            );
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_cagar_budaya', 'like', "%$search%")
                ->orWhere('kategori', 'like', "%$search%")
                ->orWhere('lokasi', 'like', "%$search%");
            });
        }

        $data = $query->orderBy('id_cagar_budaya')->get();

        // Total nilai perolehan
        $totalNilai = $data->sum('nilai_perolehan');

        $tanggal = Carbon::now();
        $tanggalFormat = $tanggal->format('dmy');

        $pdf = Pdf::loadView('pages.cagar_budaya.cetak_pdf', [
            'data' => $data,
            'totalNilai' => $totalNilai,
            'tanggal' => now()->format('d F Y'),
            'penandatangan' => Auth::user()->id,
            'namaPenandatangan' => Auth::user()->nama,
        ])->setPaper('A4', 'landscape');

        $namaFile = $tanggalFormat . '_Laporan_Pencatatan_Cagar_Budaya.pdf';

        return $pdf->stream($namaFile);
    }

    /**
     * Menghapus data cagar budaya.
     */
    public function destroy($id)
    {
        $data = CagarBudaya::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}