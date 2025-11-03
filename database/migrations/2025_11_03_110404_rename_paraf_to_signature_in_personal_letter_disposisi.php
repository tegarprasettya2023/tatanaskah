<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah kolom 'paraf' ada
        $hasParaf = Schema::hasColumn('personal_letter_disposisi', 'paraf');
        $hasSignature = Schema::hasColumn('personal_letter_disposisi', 'signature');

        if ($hasParaf && !$hasSignature) {
            // Rename kolom 'paraf' menjadi 'signature' dan ubah tipe ke TEXT
            DB::statement('ALTER TABLE personal_letter_disposisi CHANGE COLUMN paraf signature TEXT NULL');
        } elseif (!$hasParaf && !$hasSignature) {
            // Jika belum ada kedua kolom, buat kolom signature baru
            Schema::table('personal_letter_disposisi', function (Blueprint $table) {
                $table->text('signature')->nullable()->after('no_agenda');
            });
        }
        // Jika sudah ada kolom signature, skip
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $hasSignature = Schema::hasColumn('personal_letter_disposisi', 'signature');

        if ($hasSignature) {
            // Kembalikan ke paraf dengan tipe VARCHAR
            DB::statement('ALTER TABLE personal_letter_disposisi CHANGE COLUMN signature paraf VARCHAR(255) NULL');
        }
    }
};