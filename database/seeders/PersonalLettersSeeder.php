<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonalLetter;
use App\Models\PersonalLetterDinas;
use App\Models\PersonalLetterKeterangan;
use App\Models\PersonalLetterPerintah;
use App\Models\PersonalLetterKuasa;
use App\Models\PersonalLetterUndangan;
use App\Models\PersonalLetterPanggilan;
use App\Models\PersonalLetterMemo;
use App\Models\PersonalLetterPengumuman;
use App\Models\PersonalLetterNotulen;
use App\Models\PersonalLetterBeritaAcara;
use App\Models\PersonalLetterKeputusan;
use App\Models\PersonalLetterDisposisi;
use App\Models\PersonalLetterSpo;
use App\Models\User;

class PersonalLettersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user terlebih dahulu
        if (User::count() === 0) {
            $this->command->warn('Tidak ada user yang ditemukan. Membuat user dummy...');
            User::factory(5)->create();
        }

        $this->command->info('🚀 Mulai seeding Personal Letters...');
        $this->command->newLine();

        // Seed Surat Perjanjian Kerja Sama
        $this->command->info('📝 Creating Perjanjian Kerja Sama...');
        PersonalLetter::factory()->count(15)->create();
        $this->command->info('   ✓ 15 Perjanjian Kerja Sama created');

        // Seed Surat Dinas
        $this->command->info('📝 Creating Surat Dinas...');
        PersonalLetterDinas::factory()->count(20)->create();
        $this->command->info('   ✓ 20 Surat Dinas created');

        // Seed Surat Keterangan
        $this->command->info('📝 Creating Surat Keterangan...');
        PersonalLetterKeterangan::factory()->count(15)->create();
        $this->command->info('   ✓ 15 Surat Keterangan created');

        // Seed Surat Perintah
        $this->command->info('📝 Creating Surat Perintah...');
        PersonalLetterPerintah::factory()->count(12)->create();
        $this->command->info('   ✓ 12 Surat Perintah created');

        // Seed Surat Kuasa
        $this->command->info('📝 Creating Surat Kuasa...');
        PersonalLetterKuasa::factory()->count(10)->create();
        $this->command->info('   ✓ 10 Surat Kuasa created');

        // Seed Surat Undangan
        $this->command->info('📝 Creating Surat Undangan...');
        PersonalLetterUndangan::factory()->count(18)->create();
        $this->command->info('   ✓ 18 Surat Undangan created');

        // Seed Surat Panggilan
        $this->command->info('📝 Creating Surat Panggilan...');
        PersonalLetterPanggilan::factory()->count(10)->create();
        $this->command->info('   ✓ 10 Surat Panggilan created');

        // Seed Memo Internal
        $this->command->info('📝 Creating Memo Internal...');
        PersonalLetterMemo::factory()->count(15)->create();
        $this->command->info('   ✓ 15 Memo Internal created');

        // Seed Surat Pengumuman
        $this->command->info('📝 Creating Surat Pengumuman...');
        PersonalLetterPengumuman::factory()->count(12)->create();
        $this->command->info('   ✓ 12 Surat Pengumuman created');

        // Seed Notulen Rapat
        $this->command->info('📝 Creating Notulen Rapat...');
        PersonalLetterNotulen::factory()->count(10)->create();
        $this->command->info('   ✓ 10 Notulen Rapat created');

        // Seed Berita Acara
        $this->command->info('📝 Creating Berita Acara...');
        PersonalLetterBeritaAcara::factory()->count(8)->create();
        $this->command->info('   ✓ 8 Berita Acara created');

        // Seed Surat Keputusan
        $this->command->info('📝 Creating Surat Keputusan...');
        PersonalLetterKeputusan::factory()->count(10)->create();
        $this->command->info('   ✓ 10 Surat Keputusan created');

        // Seed Lembar Disposisi
        $this->command->info('📝 Creating Lembar Disposisi...');
        PersonalLetterDisposisi::factory()->count(20)->create();
        $this->command->info('   ✓ 20 Lembar Disposisi created');

        // Seed SPO (Standar Prosedur Operasional)
        $this->command->info('📝 Creating SPO...');
        PersonalLetterSpo::factory()->count(15)->create();
        $this->command->info('   ✓ 15 SPO created');

        $this->command->newLine();
        $this->command->info('✨ Seeding completed successfully! 🎉');
        $this->command->newLine();
        
        // Summary Table
        $totalLetters = PersonalLetter::count() 
            + PersonalLetterDinas::count() 
            + PersonalLetterKeterangan::count()
            + PersonalLetterPerintah::count()
            + PersonalLetterKuasa::count()
            + PersonalLetterUndangan::count()
            + PersonalLetterPanggilan::count()
            + PersonalLetterMemo::count()
            + PersonalLetterPengumuman::count()
            + PersonalLetterNotulen::count()
            + PersonalLetterBeritaAcara::count()
            + PersonalLetterKeputusan::count()
            + PersonalLetterDisposisi::count()
            + PersonalLetterSpo::count();

        $this->command->table(
            ['Jenis Surat', 'Jumlah'],
            [
                ['Perjanjian Kerja Sama', PersonalLetter::count()],
                ['Surat Dinas', PersonalLetterDinas::count()],
                ['Surat Keterangan', PersonalLetterKeterangan::count()],
                ['Surat Perintah', PersonalLetterPerintah::count()],
                ['Surat Kuasa', PersonalLetterKuasa::count()],
                ['Surat Undangan', PersonalLetterUndangan::count()],
                ['Surat Panggilan', PersonalLetterPanggilan::count()],
                ['Memo Internal', PersonalLetterMemo::count()],
                ['Surat Pengumuman', PersonalLetterPengumuman::count()],
                ['Notulen Rapat', PersonalLetterNotulen::count()],
                ['Berita Acara', PersonalLetterBeritaAcara::count()],
                ['Surat Keputusan', PersonalLetterKeputusan::count()],
                ['Lembar Disposisi', PersonalLetterDisposisi::count()],
                ['SPO', PersonalLetterSpo::count()],
                ['---', '---'],
                ['TOTAL', $totalLetters],
            ]
        );

        $this->command->newLine();
        $this->command->info("📊 Total: {$totalLetters} surat berhasil dibuat");
    }
}