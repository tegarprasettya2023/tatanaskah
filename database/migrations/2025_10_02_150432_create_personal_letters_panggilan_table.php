<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letters_panggilan', function (Blueprint $table) {
            $table->id();
            $table->string('template_type')->default('surat_panggilan');
            $table->string('kop_type'); // klinik, lab, pt
            $table->string('nomor');
            $table->date('letter_date');
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('perihal');
            $table->string('kepada');
            $table->text('isi_pembuka');
            $table->date('hari_tanggal');
            $table->string('waktu');
            $table->string('tempat');
            $table->string('menghadap');
            $table->text('alamat_pemanggil');
            $table->string('jabatan');
            $table->string('nama_pejabat');
            $table->string('nik');
            $table->string('tembusan_1')->nullable();
            $table->string('tembusan_2')->nullable();
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letters_panggilan');
    }
};