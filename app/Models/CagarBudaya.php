<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CagarBudaya extends Model
{
    protected $table = 'cagar_budaya';
    protected $primaryKey = 'id_cagar_budaya';
    public $timestamps = false;

    protected $fillable = [
        'id_cagar_budaya',
        'nama_cagar_budaya',
        'kategori',
        'lokasi',
        'tanggal_pertama_pencatatan',
        'nilai_perolehan',
        'status_kepemilikan',
        'kondisi',
        'foto',
        'deskripsi',
        'dokumen_kajian',
    ];

    protected $casts = [
        'tanggal_pertama_pencatatan' => 'date',
        'nilai_perolehan' => 'decimal:2',
    ];

    // Relasi
    public function pemugaran()
    {
        return $this->hasMany(Pemugaran::class, 'id_cagar_budaya');
    }
    
    public function mutasi()
    {
        return $this->hasMany(Mutasi::class, 'id_cagar_budaya');
    }

    public function penghapusan()
    {
        return $this->hasMany(Penghapusan::class, 'id_cagar_budaya');
    }

    public function mutasiData()
    {
        return $this->hasMany(MutasiData::class, 'id_cagar_budaya');
    }
}