<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemugaran extends Model
{
    protected $table = 'pemugaran';
    protected $primaryKey = 'id_pemugaran';
    public $timestamps = false;

    protected $fillable = [
        'id_cagar_budaya',
        'id',
        'kondisi',
        'tanggal_pengajuan',
        'deskripsi_pengajuan',
        'proposal_pengajuan',
        'biaya_pemugaran',
        'status_pemugaran',
        'status_verifikasi',
        'tanggal_verifikasi',
        'laporan_pertanggungjawaban',
        'bukti_dokumentasi',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_verifikasi' => 'date',
        'biaya_pemugaran' => 'decimal:2',
        'tanggal_selesai' => 'date',
    ];

    // Relasi
    public function cagarBudaya()
    {
        return $this->belongsTo(CagarBudaya::class, 'id_cagar_budaya');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}