<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_letter_keputusan', function (Blueprint $table) {
            $table->id();
            $table->string('kop_type')->default('lab'); // klinik, lab, pt
            $table->string('judul')->nullable();
            $table->string('nomor')->nullable();
            $table->text('tentang')->nullable();
            $table->json('menimbang')->nullable(); 
            $table->json('mengingat')->nullable(); 
            $table->text('menetapkan')->nullable();
            $table->json('isi_keputusan')->nullable(); // Array of keputusan items
            $table->date('tanggal_penetapan')->nullable();
            $table->string('tempat_penetapan')->default('Surabaya');
            $table->string('nama_pejabat')->nullable();
            $table->string('jabatan_pejabat')->nullable();
            $table->string('nik_pejabat')->nullable();
            $table->json('tembusan')->nullable(); // Array of tembusan
            $table->text('lampiran')->nullable(); // Isi lampiran jika ada
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_letter_keputusan');
    }
};