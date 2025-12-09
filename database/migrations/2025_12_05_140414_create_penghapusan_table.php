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
        Schema::create('penghapusan', function (Blueprint $table) {
            $table->id('id_penghapusan');

            // FK ke cagar_budaya
            $table->unsignedBigInteger('id_cagar_budaya');
            $table->foreign('id_cagar_budaya')
                ->references('id_cagar_budaya')
                ->on('cagar_budaya')
                ->onDelete('cascade');

            // FK ke users
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');


            $table->enum('kondisi', ['musnah', 'hilang', 'berubah wujud']);
            $table->text('alasan_penghapusan');
            $table->string('bukti_dokumentasi');
            $table->enum('status_penghapusan', ['pending', 'diproses', 'selesai'])
                ->default('pending');
            $table->enum('status_verifikasi', ['menunggu', 'ditolak', 'disetujui'])
                ->default('menunggu');
            $table->date('tanggal_verifikasi');
            $table->string('dokumen_penghapusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghapusan');
    }
};