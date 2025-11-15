<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letters_berita_acara', function (Blueprint $table) {
            $table->id();
            $table->string('kop_type')->default('klinik');
            $table->string('nomor')->nullable();
            $table->date('tanggal_acara')->nullable();
            $table->string('nama_pihak_pertama')->nullable();
            $table->string('nip_pihak_pertama')->nullable();
            $table->string('jabatan_pihak_pertama')->nullable();
            $table->string('pihak_kedua')->nullable();
            $table->string('nik_pihak_kedua')->nullable();
            $table->text('telah_melaksanakan')->nullable();
            $table->json('kegiatan')->nullable(); 
            $table->text('dibuat_berdasarkan')->nullable();
            $table->string('tempat_ttd')->default('Surabaya');
            $table->date('tanggal_ttd')->nullable();
            $table->string('nama_mengetahui')->nullable();
            $table->string('jabatan_mengetahui')->nullable();
            $table->string('nik_mengetahui')->nullable();
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letters_berita_acara');
    }
};