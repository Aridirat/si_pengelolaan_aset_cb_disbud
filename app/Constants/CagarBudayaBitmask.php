<?php

namespace App\Constants;

class CagarBudayaBitmask
{
    public const FIELDS = [
        'kategori' => 1 << 1,
        'lokasi' => 1 << 2,
        'tanggal_pertama_pencatatan' => 1 << 3,
        'nilai_perolehan' => 1 << 4,
        'status_penetapan' => 1 << 5,
        'status_kepemilikan' => 1 << 6,
        'kondisi' => 1 << 7,
        'foto' => 1 << 8,
        'deskripsi' => 1 << 9,
        'dokumen_kajian' => 1 << 10,
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