<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personal_letter_kuasa', function (Blueprint $table) {
            $table->id();
            $table->string('kop_type')->default('klinik');
            $table->string('nomor')->nullable();
            $table->date('letter_date')->nullable();
            $table->string('tempat')->nullable();

            // Pemberi
            $table->string('nama_pemberi')->nullable();
            $table->string('nip_pemberi')->nullable();
            $table->string('jabatan_pemberi')->nullable();
            $table->string('alamat_pemberi')->nullable();

            // Penerima
            $table->string('nama_penerima')->nullable();
            $table->string('nip_penerima')->nullable();
            $table->string('jabatan_penerima')->nullable();
            $table->string('alamat_penerima')->nullable();

            $table->text('isi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_letter_kuasa');
    }
};
