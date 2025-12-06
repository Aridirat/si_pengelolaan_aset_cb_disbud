<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cagar_budaya', function (Blueprint $table) {
            $table->id('id_cagar_budaya');
            $table->string('nama_cagar_budaya');
            $table->enum('kategori',['benda','bangunan','struktur','situs','kawasan']);
            $table->string('lokasi');
            $table->date('tanggal_pertama_pencatatan');
            $table->decimal('nilai_perolehan', 13, 2);
            $table->enum('status_kepemilikan',['pemerintah','pribadi']);
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat']);
            $table->string('foto');
            $table->text('deskripsi');
            $table->string('dokumen_kajian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cagar_budaya');
    }
};