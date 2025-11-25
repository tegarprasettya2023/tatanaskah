<?php

namespace Database\Factories;

use App\Models\PersonalLetterPanggilan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterPanggilanFactory extends Factory
{
    protected $model = PersonalLetterPanggilan::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        $tanggalPanggilan = $this->faker->dateTimeBetween('now', '+1 month');
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'template_type' => 'surat_panggilan',
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'letter_date' => $this->faker->dateTimeBetween("-1 month", "now"),
            'sifat' => $this->faker->randomElement(['Biasa', 'Segera', 'Sangat Segera', 'Penting']),
            'lampiran' => $this->faker->randomElement(['-', '1 (satu) berkas']),
            'perihal' => $this->generatePerihal(),
            'kepada' => $this->generateKepada(),
            
            // Isi
            'isi_pembuka' => $this->generateIsiPembuka(),
            
            // Detail Panggilan
            'hari_tanggal' => $tanggalPanggilan,
            'waktu' => $this->faker->randomElement(['08.00', '09.00', '10.00', '13.00', '14.00']) . ' WIB',
            'tempat' => $this->generateTempat(),
            'menghadap' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Bagian SDM',
                'Manajer HRD',
                'Tim Investigasi'
            ]),
            
            // Alamat Pemanggil
            'alamat_pemanggil' => $this->faker->address(),
            
            // Penandatangan
            'jabatan' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Bagian SDM',
                'Manajer HRD'
            ]),
            'nama_pejabat' => $this->faker->name(),
            'nik' => $this->faker->numerify('################'),
            
            // Tembusan
            'tembusan' => $this->faker->boolean(70) ? $this->generateTembusan() : null,
            
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
        return "{$number}/{$prefix}/PANGGIL/{$month}/{$year}";
    }

    private function generatePerihal(): string
    {
        $perihal = [
            'Panggilan Klarifikasi',
            'Panggilan Konfirmasi Data',
            'Panggilan Pembinaan',
            'Panggilan Pemeriksaan',
            'Panggilan Konseling',
            'Panggilan Wawancara',
        ];
        
        return $this->faker->randomElement($perihal);
    }

    private function generateKepada(): string
    {
        return $this->faker->name();
    }

    private function generateIsiPembuka(): string
    {
        $pembuka = [
            'Sehubungan dengan adanya beberapa hal yang perlu kami klarifikasi, dengan ini kami memanggil Saudara untuk hadir pada:',
            'Berkaitan dengan keperluan institusi, bersama ini kami meminta Saudara untuk hadir menghadap pada:',
            'Dalam rangka pelaksanaan kegiatan institusi, kami mengharapkan kehadiran Saudara pada:',
            'Terkait dengan beberapa hal yang perlu dibahas, dengan hormat kami memanggil Saudara untuk hadir pada:',
        ];
        
        return $this->faker->randomElement($pembuka);
    }

    private function generateTempat(): string
    {
        $tempat = [
            'Ruang Direktur Utama',
            'Ruang Rapat Lt. 2',
            'Ruang HRD',
            'Ruang Kepala Bagian',
            'Kantor Administrasi',
        ];
        
        return $this->faker->randomElement($tempat);
    }

    private function generateTembusan(): array
    {
        $tembusan_options = [
            ['Direktur Utama', 'Kepala Bagian SDM', 'Arsip'],
            ['Direktur', 'Manajer HRD', 'Pertinggal'],
            ['Wakil Direktur', 'Koordinator', 'Arsip'],
        ];
        
        return $this->faker->randomElement($tembusan_options);
    }
}