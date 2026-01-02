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
        Schema::create('mutasi', function (Blueprint $table) {
            $table->id('id_mutasi');

            // Foreign Key ke tabel cagar_budaya
            $table->unsignedBigInteger('id_cagar_budaya');
            $table->foreign('id_cagar_budaya')
                ->references('id_cagar_budaya')
                ->on('cagar_budaya')
                ->onDelete('cascade');

            // Foreign Key ke tabel users
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('kepemilikan_asal', ['pemerintah', 'pribadi']);
            $table->enum('kepemilikan_tujuan', ['pemerintah', 'pribadi']);
            $table->date('tanggal_pengajuan');
            $table->text('keterangan');
            $table->string('dokumen_pengajuan');
            $table->enum('status_mutasi', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->enum('status_verifikasi', ['menunggu', 'ditolak', 'disetujui'])->default('menunggu');
            $table->date('tanggal_verifikasi')->nullable();
            $table->string('dokumen_pengesahan')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi');
    }
};