<?php

namespace Database\Factories;

use App\Models\PersonalLetterDisposisi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterDisposisiFactory extends Factory
{
    protected $model = PersonalLetterDisposisi::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        $tanggalPembuatan = $this->faker->dateTimeBetween("-6 months", "now");
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'kop_type' => $kop_type,
            'logo_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'no_revisi' => $this->faker->randomElement(['00', '01', '02']),
            'halaman_dari' => 1,
            
            // Tabel Kiri
            'bagian_pembuat' => $this->faker->randomElement([
                'Bagian Umum',
                'Bagian SDM',
                'Bagian Keuangan',
                'Bagian Operasional'
            ]),
            'nomor_tanggal' => $this->generateNomorTanggal($tanggalPembuatan),
            'perihal' => $this->generatePerihal(),
            'kepada' => $this->faker->randomElement([
                'Direktur Utama',
                'Kepala Bagian',
                'Manajer Operasional',
                'Koordinator Tim'
            ]),
            'ringkasan_isi' => $this->generateRingkasanIsi(),
            'instruksi_1' => $this->generateInstruksi(),
            
            // Tabel Kanan
            'tanggal_pembuatan' => $tanggalPembuatan,
            'no_agenda' => $this->faker->numerify('###/AG/' . date('Y')),
            'signature' => null, // Signature akan diisi manual
            'diteruskan_kepada' => $this->generateDiteruskanKepada(),
            'tanggal_diserahkan' => $this->faker->dateTimeBetween($tanggalPembuatan, '+7 days'),
            'tanggal_kembali' => $this->faker->boolean(50) ? $this->faker->dateTimeBetween($tanggalPembuatan, '+14 days') : null,
            'instruksi_2' => $this->faker->boolean(70) ? $this->generateInstruksi() : null,
            
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
        return "{$number}/{$prefix}/DISP/{$month}/{$year}";
    }

private function generateNomorTanggal($tanggal): string
{
    $number = $this->faker->numerify('###');
    $date = $tanggal instanceof \DateTimeInterface
        ? $tanggal->format('d/m/Y')
        : date('d/m/Y', strtotime($tanggal));

    return "{$number}/{$date}";
}

    private function generatePerihal(): string
    {
        $perihal = [
            'Pengajuan Proposal Kegiatan',
            'Permintaan Persetujuan Anggaran',
            'Laporan Hasil Evaluasi',
            'Permohonan Izin Kegiatan',
            'Usulan Program Kerja',
            'Pemberitahuan Kegiatan',
        ];
        
        return $this->faker->randomElement($perihal);
    }

    private function generateRingkasanIsi(): string
    {
        $ringkasan = [
            'Surat berisi permohonan persetujuan untuk pelaksanaan kegiatan yang telah direncanakan sesuai dengan program kerja institusi.',
            'Laporan hasil pelaksanaan kegiatan periode sebelumnya disertai dengan dokumentasi dan evaluasi.',
            'Usulan program kerja untuk periode mendatang yang memerlukan persetujuan dari pimpinan.',
            'Permintaan alokasi anggaran untuk kegiatan operasional dan pengembangan institusi.',
        ];
        
        return $this->faker->randomElement($ringkasan);
    }

    private function generateInstruksi(): string
    {
        $instruksi = [
            'Untuk ditindaklanjuti sesuai ketentuan yang berlaku',
            'Mohon koordinasi dengan bagian terkait',
            'Untuk diproses lebih lanjut',
            'Harap segera ditindaklanjuti',
            'Untuk dipelajari dan ditindaklanjuti',
            'Mohon perhatian dan tindak lanjut',
        ];
        
        return $this->faker->randomElement($instruksi);
    }

    private function generateDiteruskanKepada(): array
    {
        $jabatan_options = [
            'Wakil Direktur',
            'Kepala Bagian Keuangan',
            'Kepala Bagian SDM',
            'Manajer Operasional',
            'Koordinator Program',
            'Supervisor',
        ];
        
        $count = $this->faker->numberBetween(2, 4);
        return $this->faker->randomElements($jabatan_options, $count);
    }
}