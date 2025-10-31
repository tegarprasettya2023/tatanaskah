<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letter_instruksi_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('logo_kiri'); // klinik, lab, pt
            $table->string('logo_kanan'); // klinik, lab, pt
            $table->string('kop_type'); // klinik, lab, pt (untuk header/footer)
            $table->string('judul_ik'); // Judul Instruksi Kerja
            $table->string('no_dokumen'); // No. Dokumen
            $table->string('no_revisi')->default('00'); // No. Revisi
            $table->date('tanggal_terbit'); // Tanggal Terbit
            $table->string('halaman')->default('1/1'); // Halaman
            
            // Ditetapkan Oleh
            $table->string('jabatan_menetapkan')->nullable();
            $table->string('nama_menetapkan')->nullable();
            $table->string('nip_menetapkan')->nullable();
            
            // Isi Tabel
            $table->text('pengertian')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('kebijakan')->nullable();
            $table->text('pelaksana')->nullable();
            
            // Prosedur Kerja/Langkah-langkah Kerja
            $table->json('prosedur_kerja')->nullable(); // Array of steps
            
            $table->text('hal_hal_perlu_diperhatikan')->nullable();
            $table->text('unit_terkait')->nullable();
            $table->text('dokumen_terkait')->nullable();
            $table->text('referensi')->nullable();
            
            // Rekaman Histori Perubahan
            $table->json('rekaman_histori')->nullable(); // Array of history records
            
            // Dibuat oleh & Direview oleh
            $table->string('dibuat_jabatan')->nullable();
            $table->string('dibuat_nama')->nullable();
            $table->date('dibuat_tanggal')->nullable();
            $table->string('direview_jabatan')->nullable();
            $table->string('direview_nama')->nullable();
            $table->date('direview_tanggal')->nullable();
            
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letter_instruksi_kerja');
    }
};