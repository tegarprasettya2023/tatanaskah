<?php

namespace Database\Factories;

use App\Models\PersonalLetter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterFactory extends Factory
{
    protected $model = PersonalLetter::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'template_type' => 'perjanjian_kerjasama',
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'letter_date' => $this->faker->dateTimeBetween("-1 year", "now"),
            'tempat' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta', 'Semarang']),
            
            // Pihak I
            'pihak1' => $this->faker->randomElement(['PIHAK PERTAMA', 'PIHAK KESATU']),
            'institusi1' => $this->generateInstitusi($kop_type),
            'jabatan1' => $this->faker->randomElement(['Direktur Utama', 'Direktur', 'Kepala Klinik', 'Kepala Laboratorium']),
            'nama1' => $this->faker->name(),
            
            // Pihak II
            'pihak2' => $this->faker->randomElement(['PIHAK KEDUA', 'PIHAK KEDUA']),
            'institusi2' => $this->faker->company(),
            'jabatan2' => $this->faker->randomElement(['Direktur', 'Manajer', 'Kepala Divisi', 'General Manager']),
            'nama2' => $this->faker->name(),
            
            // Objek kerja sama
            'tentang' => $this->generateTentang(),
            
            // Pasal-pasal
            'pasal_data' => $this->generatePasalData(),
            
            'generated_file' => null,
        ];
    }

    private function generateNomorSurat($kop_type, $year, $month): string
    {
        $prefix = match($kop_type) {
            'klinik' => 'KLN',
            'lab' => 'LAB',
            'pt' => 'DIR',
            default => 'DOC'
        };
        
        $number = str_pad($this->faker->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);
        return "{$number}/{$prefix}/PKS/{$month}/{$year}";
    }

    private function generateInstitusi($kop_type): string
    {
        return match($kop_type) {
            'klinik' => 'Klinik ' . $this->faker->randomElement(['Sehat Sentosa', 'Harapan Medika', 'Pratama Husada', 'Bina Sehat']),
            'lab' => 'Laboratorium ' . $this->faker->randomElement(['Medis Utama', 'Diagnosa Prima', 'Klinik Pratama', 'Kesehatan Sentosa']),
            'pt' => 'PT ' . $this->faker->company(),
            default => $this->faker->company()
        };
    }

    private function generateTentang(): string
    {
        $topics = [
            'Kerja Sama Pelayanan Kesehatan dan Pemeriksaan Laboratorium',
            'Kerja Sama Pengelolaan Sistem Informasi Kesehatan',
            'Kerja Sama Pengadaan Alat Kesehatan dan Bahan Medis',
            'Kerja Sama Pelatihan dan Pengembangan SDM Kesehatan',
            'Kerja Sama Pelayanan Medical Check Up Karyawan',
            'Kerja Sama Rujukan Pasien dan Konsultasi Medis',
        ];
        
        return $this->faker->randomElement($topics);
    }

    private function generatePasalData(): array
    {
        $pasalCount = $this->faker->numberBetween(5, 8);
        $pasal = [];
        
        $templates = [
            ['judul' => 'RUANG LINGKUP', 'isi' => 'Ruang lingkup kerja sama ini meliputi pelayanan kesehatan, pemeriksaan laboratorium, dan konsultasi medis sesuai dengan kebutuhan PIHAK KEDUA.'],
            ['judul' => 'JANGKA WAKTU', 'isi' => 'Perjanjian ini berlaku selama 1 (satu) tahun terhitung sejak tanggal ditandatangani dan dapat diperpanjang atas kesepakatan kedua belah pihak.'],
            ['judul' => 'HAK DAN KEWAJIBAN', 'isi' => 'PIHAK PERTAMA berhak menerima pembayaran sesuai kesepakatan dan berkewajiban memberikan pelayanan sesuai standar. PIHAK KEDUA berkewajiban melakukan pembayaran tepat waktu.'],
            ['judul' => 'BIAYA DAN PEMBAYARAN', 'isi' => 'Biaya pelayanan akan ditagihkan setiap akhir bulan dengan termin pembayaran 14 hari kerja setelah invoice diterima.'],
            ['judul' => 'KERAHASIAAN', 'isi' => 'Kedua belah pihak wajib menjaga kerahasiaan data dan informasi yang diperoleh selama kerja sama berlangsung.'],
            ['judul' => 'PENYELESAIAN PERSELISIHAN', 'isi' => 'Apabila terjadi perselisihan, akan diselesaikan secara musyawarah. Jika tidak tercapai kesepakatan, akan diselesaikan melalui Pengadilan Negeri yang berwenang.'],
            ['judul' => 'FORCE MAJEURE', 'isi' => 'Keadaan memaksa (force majeure) yang mengakibatkan salah satu pihak tidak dapat melaksanakan kewajibannya akan dimusyawarahkan oleh kedua belah pihak.'],
            ['judul' => 'PENUTUP', 'isi' => 'Perjanjian ini dibuat dalam rangkap 2 (dua), bermaterai cukup, dan masing-masing mempunyai kekuatan hukum yang sama.'],
        ];
        
        for ($i = 0; $i < $pasalCount; $i++) {
            $pasal[] = $templates[$i % count($templates)];
        }
        
        return $pasal;
    }
}