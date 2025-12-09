<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 'mutasi';
    protected $primaryKey = 'id_mutasi';
    public $timestamps = false;

    protected $fillable = [
        'id_cagar_budaya',
        'id_pengguna',
        'kepemilikan_asal',
        'kepemilikan_tujuan',
        'tanggal_pengajuan',
        'keterangan',
        'dokumen_pengajuan',
        'status_mutasi',
        'status_verifikasi',
        'tanggal_verifikasi',
        'dokumen_pengesahan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_verifikasi' => 'date',
    ];

    // Relasi
    public function cagarBudaya()
    {
        return $this->belongsTo(CagarBudaya::class, 'id_cagar_budaya');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}