<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_letters_perintah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('template_type')->default('surat_perintah');
            $table->string('kop_type'); // klinik, lab, pt
            $table->string('nomor');
            $table->date('letter_date');
            $table->string('tempat');
            
            // Menimbang - sekarang array
            $table->json('menimbang');
            
            // Dasar - sekarang array
            $table->json('dasar');
            
            // Memberi Perintah Kepada - sekarang opsional
            $table->string('nama_penerima')->nullable();
            $table->string('nik_penerima')->nullable();
            $table->string('jabatan_penerima')->nullable();
            $table->text('nama_nama_terlampir')->nullable();
            
            // Untuk - sekarang array
            $table->json('untuk');
            
            // Tembusan - sekarang array dan opsional
            $table->json('tembusan')->nullable();
            
            // Pembuat/Penandatangan
            $table->string('jabatan_pembuat');
            $table->string('nama_pembuat');
            $table->string('nik_pembuat');
            
            // Lampiran - opsional
            $table->json('lampiran')->nullable();
            
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_letters_perintah');
    }
};