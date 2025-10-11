<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_letters_perintah', function (Blueprint $table) {
            $table->id();
            $table->string('template_type')->default('surat_perintah');
            $table->string('kop_type'); // klinik, lab, pt
            $table->string('nomor');
            $table->date('letter_date');
            $table->string('tempat');
            
            // Menimbang
            $table->text('menimbang_1');
            $table->text('menimbang_2');
            
            // Dasar
            $table->text('dasar_a');
            $table->text('dasar_b');
            
            // Memberi Perintah Kepada
            $table->string('nama_penerima');
            $table->string('nik_penerima');
            $table->string('jabatan_penerima');
            $table->text('nama_nama_terlampir')->nullable(); // Jika ada nama-nama terlampir
            
            // Untuk (tujuan/keperluan)
            $table->text('untuk_1');
            $table->text('untuk_2');
            
            // Tembusan
            $table->text('tembusan_1')->nullable();
            $table->text('tembusan_2')->nullable();
            
            // Pembuat/Penandatangan
            $table->string('jabatan_pembuat');
            $table->string('nama_pembuat');
            $table->string('nik_pembuat');
            
        $table->json('lampiran')->nullable();

            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_letters_perintah');
    }
};