<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_letters', function (Blueprint $table) {
            // Tambah kolom pasal_data jika belum ada
            if (!Schema::hasColumn('personal_letters', 'pasal_data')) {
                $table->json('pasal_data')->nullable()->after('tentang');
            }
        });
    }

    public function down(): void
    {
        Schema::table('personal_letters', function (Blueprint $table) {
            if (Schema::hasColumn('personal_letters', 'pasal_data')) {
                $table->dropColumn('pasal_data');
            }
        });
    }
};