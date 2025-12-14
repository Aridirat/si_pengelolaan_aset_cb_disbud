<?php

namespace App\Constants;

class CagarBudayaBitmask
{
    public const FIELDS = [
        'nama_cagar_budaya' => 1 << 0,
        'kategori' => 1 << 1,
        'lokasi' => 1 << 2,
        'tanggal_pertama_pencatatan' => 1 << 3,
        'nilai_perolehan' => 1 << 4,
        'status_kepemilikan' => 1 << 5,
        'kondisi' => 1 << 6,
        'foto' => 1 << 7,
        'deskripsi' => 1 << 8,
        'dokumen_kajian' => 1 << 9,
    ];

    public static function decodeBitmask(int $bitmask): array
    {
        $changedFields = [];

        foreach (CagarBudayaBitmask::FIELDS as $field => $bit) {
            if (($bitmask & $bit) === $bit) {
                $changedFields[] = $field;
            }
        }

        return $changedFields;
    }

}