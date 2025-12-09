<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiData extends Model
{
    protected $table = 'mutasi_data';
    protected $primaryKey = 'id_mutasi_data';
    public $timestamps = false;

    protected $fillable = [
        'id_cagar_budaya',
        'id_pengguna',
        'tanggal_mutasi_data',
        'bitmask',
        'nilai_lama',
        'nilai_baru',
    ];

    protected $casts = [
        'tanggal_mutasi_data' => 'datetime',
        'nilai_lama' => 'array',
        'nilai_baru' => 'array',
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