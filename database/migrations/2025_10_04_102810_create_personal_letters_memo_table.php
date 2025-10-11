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
            $table->string('template_type')->default('internal_memo');
            $table->string('kop_type'); // klinik, lab, pt
            
            // Nomor auto-generate (IM/001/bulan/tahun)
            $table->string('nomor')->unique();
            $table->integer('nomor_urut');
            
            // Tanggal & Tempat
            $table->string('tempat_ttd');
            $table->date('letter_date');
            
            // Penerima
            $table->string('yth_nama');
            $table->string('hal');
            
            // Isi Memo
            $table->text('sehubungan_dengan');
            $table->text('alinea_isi');
            $table->text('isi_penutup')->default('Atas perhatian dan perkenan Bapak/Ibu/Saudara/I, kami mengucapkan terima kasih.');
            
            // Penandatangan
            $table->string('jabatan_pembuat');
            $table->string('nama_pembuat');
            $table->string('nik_pembuat');
            
            // Tembusan
            $table->text('tembusan_1')->nullable();
            $table->text('tembusan_2')->nullable();
            
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_letters_memo');
    }
};