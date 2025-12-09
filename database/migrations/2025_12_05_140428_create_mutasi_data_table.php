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
        Schema::create('mutasi_data', function (Blueprint $table) {
            $table->id('id_mutasi_data');

            // FK ke cagar_budaya
            $table->unsignedBigInteger('id_cagar_budaya');
            $table->foreign('id_cagar_budaya')
                ->references('id_cagar_budaya')
                ->on('cagar_budaya')
                ->onDelete('cascade');

            // FK ke users
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->dateTime('tanggal_mutasi_data');
            $table->bigInteger('bitmask');
            $table->json('nilai_lama')->nullable();
            $table->json('nilai_baru')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_data');
    }
};