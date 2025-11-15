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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // TAMBAHAN
            $table->string('kop_type')->default('lab'); // klinik, lab, pt
            $table->string('isi_notulen')->nullable();
            $table->date('tanggal_rapat')->nullable();
            $table->time('waktu')->nullable();
            $table->string('tempat')->nullable();
            $table->string('pimpinan_rapat')->nullable();
            $table->text('peserta_rapat')->nullable();
            $table->json('kegiatan_rapat')->nullable(); // Array of objects
            $table->string('kepala_lab')->nullable();
            $table->string('nik_kepala_lab')->nullable();
            $table->string('notulis')->nullable();
            $table->string('nik_notulis')->nullable();
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