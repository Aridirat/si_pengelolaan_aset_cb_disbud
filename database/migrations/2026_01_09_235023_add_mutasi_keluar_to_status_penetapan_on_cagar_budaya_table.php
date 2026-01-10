<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE cagar_budaya 
            MODIFY status_penetapan 
            ENUM('aktif', 'terhapus', 'mutasi keluar')
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE cagar_budaya 
            MODIFY status_penetapan 
            ENUM('aktif', 'terhapus')
        ");
    }
};