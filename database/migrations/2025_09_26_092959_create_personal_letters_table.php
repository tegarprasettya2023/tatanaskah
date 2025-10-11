<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_letters', function (Blueprint $table) {
            $table->id();
            
            // Template info
            $table->string('template_type')->default('perjanjian_kerjasama');
            $table->enum('kop_type', ['klinik', 'lab', 'pt'])->default('klinik');
            
            // Basic info
            $table->string('nomor');
            $table->date('letter_date');
            $table->string('tempat');
            
            // Pihak I
            $table->string('pihak1');
            $table->string('institusi1');
            $table->string('jabatan1');
            $table->string('nama1');
            
            // Pihak II
            $table->string('pihak2');
            $table->string('institusi2');
            $table->string('jabatan2');
            $table->string('nama2');
            
            // Objek kerja sama
            $table->text('tentang');
            
            // Pasal-pasal (hapus pasal individual, diganti dengan JSON)
            $table->json('pasal_data')->nullable(); // Menyimpan semua pasal dalam format JSON
            
            // File management
            $table->string('generated_file')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_letters');
    }
};