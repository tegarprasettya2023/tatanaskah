<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_letters_dinas', function (Blueprint $table) {
    $table->id();
    $table->string('template_type');
    $table->string('kop_type');
    $table->string('nomor');
    $table->date('letter_date');
    $table->string('tempat');
    $table->string('sifat')->nullable();
    $table->string('lampiran')->nullable();
    $table->string('perihal');
    $table->string('kepada');
    $table->string('kepada_tempat');
    $table->text('sehubungan_dengan')->nullable();
    $table->text('isi_surat')->nullable();
    $table->string('nama1');
    $table->string('jabatan1');
    $table->string('nip')->nullable();
    $table->json('tembusan_data')->nullable();
    $table->string('generated_file')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_letters_dinas');
    }
};
