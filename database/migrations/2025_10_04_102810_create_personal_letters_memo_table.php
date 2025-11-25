<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_letters_memo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('template_type')->default('internal_memo');
            $table->string('kop_type'); // klinik, lab, pt
            
            // Nomor manual input
            $table->string('nomor');
            
            // Tanggal & Tempat
            $table->string('tempat_ttd');
            $table->date('letter_date');
            
            // Penerima
            $table->string('yth_nama');
            $table->string('hal');
            
            // Isi Memo (dengan HTML dari editor)
            $table->text('sehubungan_dengan');
            $table->text('alinea_isi');
            $table->text('isi_penutup')->nullable();
            
            // Penandatangan
            $table->string('jabatan_pembuat');
            $table->string('nama_pembuat');
            $table->string('nik_pembuat')->nullable();
            
            // Tembusan (JSON array)
            $table->json('tembusan')->nullable();
            
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_letters_memo');
    }
};