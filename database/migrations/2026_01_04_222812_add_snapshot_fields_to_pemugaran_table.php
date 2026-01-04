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
        Schema::table('pemugaran', function (Blueprint $table) {
            $table->string('kondisi_baru')->nullable()->after('kondisi');

            $table->decimal('nilai_perolehan_baru', 20, 2)
                ->nullable()
                ->after('biaya_pemugaran');
        });
    }

    public function down(): void
    {
        Schema::table('pemugaran', function (Blueprint $table) {
            $table->dropColumn([
                'kondisi_baru',
                'nilai_perolehan_baru',
            ]);
        });
    }

};