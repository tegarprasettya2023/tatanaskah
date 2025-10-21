<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_letter_surat_keputusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kop
            $table->enum('kop_type', ['klinik', 'lab', 'pt'])->default('lab');
            
            // Header Surat
            $table->string('judul_setelah_sk')->nullable(); // KEPALA LABORATORIUM...
            $table->string('nomor_sk')->nullable(); // untuk SK/nomor/bulan/tahun
            $table->date('tanggal_sk')->nullable(); // untuk bulan romawi & tahun
            
            // Tentang
            $table->text('tentang')->nullable(); // DENGAN RAHMAT TUHAN YANG MAHA KUASA
            $table->text('jabatan_pembuat')->nullable(); // KEPALA LABORATORIUM... (fleksibel)
            
            // Menimbang (JSON array - bisa ditambah/hapus)
            $table->json('menimbang')->nullable(); // [{uruf: 'a', isi: '...'}, ...]
            
            // Mengingat (JSON array - bisa ditambah/hapus)
            $table->json('mengingat')->nullable(); // [{uruf: 'a', isi: '...'}, ...]
            
            // Memutuskan - Menetapkan
            $table->text('menetapkan')->nullable(); // Isi dari menetapkan
            
            // Keputusan (JSON array - Kesatu, Kedua, dst)
            $table->json('keputusan')->nullable(); // ['Kesatu': '...', 'Kedua': '...']
            
            // Penutup
            $table->string('ditetapkan_di')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->string('nama_jabatan')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('nik_kepegawaian')->nullable();
            
            // Lampiran (Halaman 2)
            $table->text('keputusan_dari')->nullable(); // Keputusan Kepala Lab...
            $table->text('lampiran_tentang')->nullable();
            
            // Tembusan (JSON array)
            $table->json('tembusan')->nullable();
            
            // File PDF
            $table->string('generated_file')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_letter_surat_keputusan');
    }
};