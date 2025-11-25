<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letters_notulen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kop_type')->default('lab'); // klinik, lab, pt
            $table->string('isi_notulen')->nullable();
            $table->date('tanggal_rapat')->nullable();
            $table->date('tanggal_ttd')->nullable(); // TAMBAHAN BARU
            $table->time('waktu')->nullable();
            $table->string('tempat')->nullable();
            $table->string('pimpinan_rapat')->nullable();
            $table->text('peserta_rapat')->nullable();
            $table->json('kegiatan_rapat')->nullable(); // Array of objects
            
            // Field penandatangan diubah
            $table->string('ttd_jabatan_1')->nullable(); // Ganti kepala_lab
            $table->string('nama_ttd_jabatan_1')->nullable(); // Nama untuk jabatan 1
            $table->string('nik_ttd_jabatan_1')->nullable(); // Ganti nik_kepala_lab
            
            $table->string('ttd_jabatan_2')->nullable(); // Ganti notulis
            $table->string('nama_ttd_jabatan_2')->nullable(); // Nama untuk jabatan 2
            $table->string('nik_ttd_jabatan_2')->nullable(); // Ganti nik_notulis
            
            $table->string('judul_dokumentasi')->nullable();
            $table->json('dokumentasi')->nullable(); // Array of image paths
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letters_notulen');
    }
};