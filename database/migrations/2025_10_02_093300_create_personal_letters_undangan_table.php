<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_letters_undangan', function (Blueprint $table) {
            $table->id();
            $table->string('template_type')->default('surat_undangan');
            $table->string('kop_type'); // klinik, lab, pt
            
            // Header Surat
            $table->string('nomor');
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('perihal');
            
            // Penerima
            $table->string('yth_nama');
            $table->text('yth_alamat');
            
            // Isi Undangan
            $table->text('isi_pembuka');
            $table->date('hari_tanggal');            
            $table->string('pukul');
            $table->string('tempat_acara');
            $table->string('acara');

            // Penandatangan
            $table->string('tempat_ttd');   
            $table->date('tanggal_ttd')->nullable();             
            $table->string('jabatan_pembuat');
            $table->string('nama_pembuat');

            
            // Tembusan
            $table->text('tembusan_1')->nullable();
            $table->text('tembusan_2')->nullable();
            
            // Lampiran Daftar Undangan (JSON)
            $table->json('daftar_undangan')->nullable();
            
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_letters_undangan');
    }
};