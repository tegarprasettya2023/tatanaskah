<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letter_disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kop & Logo
            $table->enum('kop_type', ['klinik', 'lab', 'pt'])->default('lab');
            $table->string('logo')->nullable();
            
            // Nomor Dokumen
            $table->string('nomor_ld')->nullable(); // 001, 002, dst
            $table->date('tanggal_dokumen')->nullable();
            
            // Revisi & Tanggal Pembuatan
            $table->string('no_revisi')->default('00');
            $table->date('tanggal_pembuatan')->nullable();
            
            // Halaman dari
            $table->string('halaman')->default('1');
            
            // Dari (Bagian Pembuat)
            $table->string('dari')->nullable();
            $table->date('tanggal_dari')->nullable();
            
            // Nomor/Tanggal (Membaca)
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_membaca')->nullable();
            
            // No. Agenda
            $table->string('no_agenda')->nullable();
            
            // Perihal & Paraf
            $table->text('perihal')->nullable();
            $table->string('paraf')->nullable();
            
            // Kepada
            $table->string('kepada')->nullable();
            
            // Diteruskan Kepada (JSON array)
            $table->json('diteruskan_kepada')->nullable();
            
            // Tanggal Diserahkan & Kembali
            $table->date('tanggal_diserahkan')->nullable();
            $table->date('tanggal_kembali')->nullable();
            
            // Ringkasan Isi
            $table->text('ringkasan_isi')->nullable();
            
            // Catatan (2 kolom)
            $table->text('catatan_1')->nullable();
            $table->text('catatan_2')->nullable();
            
            // File PDF
            $table->string('generated_file')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letter_disposisi');
    }
};