<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letters_keterangan', function (Blueprint $table) {
            $table->id();
            $table->string('template_type')->default('surat_keterangan');
            $table->enum('kop_type', ['klinik', 'lab', 'pt'])->default('klinik');
            $table->string('nomor');
            $table->date('letter_date');
            $table->string('tempat');
            
            // Data yang menerangkan
            $table->string('nama_yang_menerangkan');
            $table->string('nik_yang_menerangkan');
            $table->string('jabatan_yang_menerangkan');
            
            // Data yang diterangkan
            $table->string('nama_yang_diterangkan');
            $table->string('nip_yang_diterangkan');
            $table->string('jabatan_yang_diterangkan');
            
            // Isi keterangan
            $table->text('isi_keterangan');
            
            // Penandatangan
            $table->string('jabatan_pembuat');
            $table->string('nama_pembuat');
            $table->string('nik_pembuat');
            
            $table->string('generated_file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letters_keterangan');
    }
};