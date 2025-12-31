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
        Schema::create('pemugaran', function (Blueprint $table) {
            $table->id('id_pemugaran');

            $table->unsignedBigInteger('id_cagar_budaya');
            $table->foreign('id_cagar_budaya')->references('id_cagar_budaya')->on('cagar_budaya')->onDelete('cascade');
            
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('kondisi', ['rusak ringan', 'rusak berat']);
            $table->date('tanggal_pengajuan');
            $table->text('deskripsi_pengajuan');
            $table->string('proposal_pengajuan');
            $table->decimal('biaya_pemugaran', 20, 2);
            $table->enum('status_pemugaran', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->enum('status_verifikasi', ['menunggu', 'ditolak', 'disetujui'])->default('menunggu');
            $table->date('tanggal_verifikasi');
            $table->string('laporan_pertanggungjawaban');
            $table->string('bukti_dokumentasi');
            $table->date('tanggal_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemugaran');
    }
};