<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    protected $table = 'pengguna';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama',
        'username',
        'password',
        'role',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function mutasi()
    {
        return $this->hasMany(Mutasi::class, 'id');
    }

    public function penghapusan()
    {
        return $this->hasMany(Penghapusan::class, 'id');
    }

    public function mutasiData()
    {
        return $this->hasMany(MutasiData::class, 'id');
    }

    public function pemugaran()
    {
        return $this->hasMany(Pemugaran::class, 'id');
    }

}