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
            $table->string('kop_type')->default('klinik'); // klinik, lab, pt
            $table->string('logo_type')->default('klinik'); // untuk logo
            $table->string('nomor_dokumen')->nullable();
            $table->string('no_revisi')->nullable();
            $table->integer('halaman_dari')->default(1);
            
            // Tabel Kiri
            $table->string('bagian_pembuat')->nullable();
            $table->string('nomor_tanggal')->nullable(); // input manual
            $table->string('perihal')->nullable();
            $table->string('kepada')->nullable();
            $table->text('ringkasan_isi')->nullable();
            $table->text('instruksi_1')->nullable();
            
            // Tabel Kanan
            $table->date('tanggal_pembuatan')->nullable();
            $table->string('no_agenda')->nullable();
            $table->text('signature')->nullable();;
            $table->json('diteruskan_kepada')->nullable(); // array
            $table->date('tanggal_diserahkan')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->text('instruksi_2')->nullable();
            
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letter_disposisi');
    }
};