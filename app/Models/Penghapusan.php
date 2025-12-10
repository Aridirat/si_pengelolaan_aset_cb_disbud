<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghapusan extends Model
{
    protected $table = 'penghapusan';
    protected $primaryKey = 'id_penghapusan';
    public $timestamps = false;

    protected $fillable = [
        'id_cagar_budaya',
        'id',
        'kondisi',
        'alasan_penghapusan',
        'bukti_dokumentasi',
        'status_penghapusan',
        'status_verifikasi',
        'tanggal_verifikasi',
        'dokumen_penghapusan'
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'date',
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