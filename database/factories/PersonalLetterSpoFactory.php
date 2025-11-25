<?php

namespace Database\Factories;

use App\Models\PersonalLetterSpo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterSpoFactory extends Factory
{
    protected $model = PersonalLetterSpo::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $tanggalTerbit = $this->faker->dateTimeBetween("-2 years", "now");
        $year = $tanggalTerbit->format('Y'); // FIXED

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'logo_kiri' => $kop_type,
            'logo_kanan' => $kop_type,
            'kop_type' => $kop_type,

            // Header Info
            'judul_spo' => $this->generateJudulSpo(),
            'no_dokumen' => $this->generateNoDokumen($kop_type, $year),
            'no_revisi' => $this->faker->randomElement(['00', '01', '02', '03']),
            'tanggal_terbit' => $tanggalTerbit,
            'halaman' => $this->faker->randomElement(['1/1', '1/2', '1/3']),

            // Ditetapkan Oleh
            'jabatan_menetapkan' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Kepala Laboratorium'
            ]),
            'nama_menetapkan' => $this->faker->name(),
            'nip_menetapkan' => $this->faker->boolean(70) ? $this->faker->numerify('##########') : null,

            // Content Sections
            'label_1' => 'Pengertian',
            'content_1' => $this->generatePengertian(),

            'label_2' => 'Tujuan',
            'content_2' => $this->generateTujuan(),

            'label_3' => 'Kebijakan',
            'content_3' => $this->generateKebijakan(),

            'label_4' => 'Prosedur',
            'content_4' => $this->generateProsedur(),

            'label_5' => 'Bagan Alir',
            'bagan_alir_image' => null, // Image akan diupload manual

            'label_6' => 'Hal-hal Yang Perlu Diperhatikan',
            'content_6' => $this->generateHalPerluDiperhatikan(),

            'label_7' => 'Unit Terkait',
            'content_7' => $this->generateUnitTerkait(),

            'label_8' => 'Dokumen Terkait',
            'content_8' => $this->generateDokumenTerkait(),

            'label_9' => 'Referensi',
            'content_9' => $this->generateReferensi(),

            'label_10' => 'Rekaman Historis Perubahan',
            'rekaman_historis' => $this->generateRekamanHistoris($tanggalTerbit),

            // Footer - Persetujuan
            'dibuat_jabatan' => 'Manajer Mutu',
            'dibuat_nama' => $this->faker->name(),
            'dibuat_tanggal' => $tanggalTerbit,

            'direview_jabatan' => 'Wakil Direktur',
            'direview_nama' => $this->faker->name(),
            'direview_tanggal' => $tanggalTerbit,

            'generated_file' => null,
            'letter_date' => $tanggalTerbit,
            'nomor' => $this->generateNoDokumen($kop_type, $year),
        ];
    }

    private function generateNoDokumen($kop_type, $year): string
    {
        $prefix = match($kop_type) {
            'klinik' => 'KLN',
            'lab' => 'LAB',
            'pt' => 'PT',
            default => 'DOC'
        };

        $number = str_pad($this->faker->numberBetween(1, 99), 2, '0', STR_PAD_LEFT);
        return "SPO/{$prefix}/{$number}/{$year}";
    }

    private function generateJudulSpo(): string
    {
        $judul = [
            'PROSEDUR PELAYANAN PASIEN',
            'PROSEDUR PEMERIKSAAN LABORATORIUM',
            'PROSEDUR STERILISASI ALAT MEDIS',
            'PROSEDUR PELAPORAN INSIDEN',
            'PROSEDUR PENGELOLAAN LIMBAH MEDIS',
            'PROSEDUR PEMELIHARAAN ALAT',
            'PROSEDUR PENERIMAAN PASIEN BARU',
            'PROSEDUR ADMINISTRASI KEUANGAN',
        ];

        return $this->faker->randomElement($judul);
    }

    private function generatePengertian(): string
    {
        return 'Standar Operasional Prosedur ini mengatur tentang tata cara pelaksanaan kegiatan yang harus diikuti oleh seluruh personel terkait untuk memastikan konsistensi dan kualitas pelayanan.';
    }

    private function generateTujuan(): string
    {
        return "1. Memberikan panduan yang jelas dalam pelaksanaan kegiatan\n2. Memastikan standar kualitas pelayanan terpenuhi\n3. Meningkatkan efisiensi dan efektivitas kerja\n4. Meminimalkan kesalahan dan risiko dalam pelaksanaan tugas";
    }

    private function generateKebijakan(): string
    {
        return "1. Setiap personel wajib mengikuti prosedur yang telah ditetapkan\n2. Dilakukan monitoring dan evaluasi secara berkala\n3. Setiap penyimpangan harus dilaporkan dan dicatat\n4. Prosedur dapat direvisi sesuai kebutuhan dan perkembangan";
    }

    private function generateProsedur(): string
    {
        return "1. Persiapan: Memastikan semua peralatan dan dokumen siap\n2. Pelaksanaan: Mengikuti langkah-langkah yang telah ditetapkan\n3. Dokumentasi: Mencatat semua kegiatan yang dilakukan\n4. Evaluasi: Melakukan evaluasi hasil dan tindak lanjut";
    }

    private function generateHalPerluDiperhatikan(): string
    {
        return "1. Pastikan mengikuti protokol keselamatan\n2. Gunakan alat pelindung diri yang sesuai\n3. Laporkan segera jika terjadi kendala\n4. Dokumentasikan setiap tahapan kegiatan";
    }

    private function generateUnitTerkait(): string
    {
        return "1. Bagian Pelayanan\n2. Bagian Administrasi\n3. Bagian Mutu\n4. Bagian Keperawatan";
    }

    private function generateDokumenTerkait(): string
    {
        return "1. Formulir Pemeriksaan\n2. Checklist Kegiatan\n3. Laporan Hasil\n4. Rekam Medis";
    }

    private function generateReferensi(): string
    {
        return "1. Peraturan Menteri Kesehatan RI\n2. Standar Akreditasi Rumah Sakit\n3. Pedoman Praktik Klinis\n4. Kebijakan Internal Institusi";
    }

    private function generateRekamanHistoris($tanggalTerbit): array
    {
        return [
            [
                'no_revisi' => '00',
                'tanggal' => $tanggalTerbit->format('d/m/Y'), // FIXED
                'perubahan' => 'Dokumen pertama kali diterbitkan',
                'halaman' => 'Semua'
            ]
        ];
    }
}
