<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letters_pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('kop_type')->default('klinik');
            $table->string('nomor')->nullable();
            $table->string('tentang')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->text('isi_pembuka')->nullable();
            $table->text('isi_penutup')->nullable();
            $table->string('tempat_ttd')->default('Surabaya');
            $table->date('tanggal_ttd')->nullable();
            $table->string('nama_pembuat')->nullable();
            $table->string('nik_pegawai')->nullable();
            $table->string('jabatan_pembuat')->nullable();
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letters_pengumuman');
    }
};
