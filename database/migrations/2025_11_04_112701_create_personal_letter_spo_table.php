<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letters_spo', function (Blueprint $table) {
            $table->id();
            $table->string('logo_kiri')->nullable(); // klinik, lab, pt
            $table->string('logo_kanan')->nullable(); // klinik, lab, pt
            $table->string('kop_type')->nullable(); // klinik, lab, pt
            
            // Header Info
            $table->string('judul_spo')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->string('no_revisi')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->string('halaman')->nullable();
            
            // Ditetapkan Oleh
            $table->string('jabatan_menetapkan')->nullable();
            $table->string('nama_menetapkan')->nullable();
            $table->string('nip_menetapkan')->nullable();
            
            // Content (1-10) - Editable Labels
            $table->string('label_1')->default('Pengertian');
            $table->text('content_1')->nullable();
            
            $table->string('label_2')->default('Tujuan');
            $table->text('content_2')->nullable();
            
            $table->string('label_3')->default('Kebijakan');
            $table->text('content_3')->nullable();
            
            $table->string('label_4')->default('Prosedur');
            $table->text('content_4')->nullable();
            
            $table->string('label_5')->default('Bagan Alir');
            $table->string('bagan_alir_image')->nullable(); // path gambar
            
            $table->string('label_6')->default('Hal-hal Yang Perlu Diperhatikan');
            $table->text('content_6')->nullable();
            
            $table->string('label_7')->default('Unit terkait');
            $table->text('content_7')->nullable();
            
            $table->string('label_8')->default('Dokumen terkait');
            $table->text('content_8')->nullable();
            
            $table->string('label_9')->default('Referensi');
            $table->text('content_9')->nullable();
            
            $table->string('label_10')->default('Rekaman Historis Perubahan');
            $table->json('rekaman_historis')->nullable(); // array of changes
            
            // Footer - Persetujuan
            $table->string('dibuat_jabatan')->nullable();
            $table->string('dibuat_nama')->nullable();
            $table->date('dibuat_tanggal')->nullable();
            
            $table->string('direview_jabatan')->nullable();
            $table->string('direview_nama')->nullable();
            $table->date('direview_tanggal')->nullable();
            
            // Generated File
            $table->string('generated_file')->nullable();
            $table->date('letter_date')->nullable(); // for sorting/filtering
            $table->string('nomor')->nullable(); // for index display
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letters_spo');
    }
};