<?php

namespace Database\Factories;

use App\Models\PersonalLetterDinas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterDinasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PersonalLetterDinas::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'template_type' => 'surat_dinas',
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'letter_date' => $this->faker->dateTimeBetween("-1 year", "now"),
            'tempat' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta', 'Semarang']),
            'sifat' => $this->faker->randomElement(['Biasa', 'Segera', 'Sangat Segera', 'Rahasia']),
            'lampiran' => $this->faker->randomElement(['1 (satu) berkas', '2 (dua) lembar', '-', 'Terlampir']),
            'perihal' => $this->generatePerihal(),
            'kepada' => $this->generateKepada(),
            'kepada_tempat' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'di tempat', 'Semarang']),
            'sehubungan_dengan' => $this->generateSehubunganDengan(),
            'isi_surat' => $this->generateIsiSurat(),
            'nama1' => $this->faker->name(),
            'jabatan1' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Manajer Operasional',
                'Kepala Bagian Umum'
            ]),
            'nip' => $this->generateNIP(),
            'tembusan_data' => $this->generateTembusanData(),
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
        return "{$number}/{$prefix}/SD/{$month}/{$year}";
    }

    private function generatePerihal(): string
    {
        $perihal = [
            'Undangan Rapat Koordinasi',
            'Permohonan Izin Kegiatan',
            'Pemberitahuan Jadwal Kegiatan',
            'Permintaan Data dan Informasi',
            'Permohonan Kerja Sama',
            'Konfirmasi Kehadiran',
            'Pemberitahuan Libur Nasional',
            'Pengajuan Proposal Kegiatan',
        ];
        
        return $this->faker->randomElement($perihal);
    }

    private function generateKepada(): string
    {
        $jabatan = [
            'Yth. Direktur RS Umum Daerah',
            'Yth. Kepala Dinas Kesehatan Kota',
            'Yth. Direktur Utama PT',
            'Yth. Manajer HRD',
            'Yth. Kepala Bagian Keuangan',
            'Yth. Direktur Rumah Sakit',
        ];
        
        return $this->faker->randomElement($jabatan);
    }

    private function generateSehubunganDengan(): string
    {
        $topics = [
            'rencana pelaksanaan kegiatan kerja sama di bidang kesehatan',
            'permohonan data jumlah pasien periode bulan lalu',
            'undangan rapat koordinasi terkait pengembangan sistem',
            'pemberitahuan jadwal pemeliharaan sistem informasi',
            'permintaan konfirmasi kehadiran dalam acara',
        ];
        
        return 'Sehubungan dengan ' . $this->faker->randomElement($topics) . ', bersama ini kami sampaikan hal-hal sebagai berikut:';
    }

    private function generateIsiSurat(): string
    {
        $isi = [
            "1. Kegiatan akan dilaksanakan pada tanggal yang akan ditentukan kemudian.\n2. Peserta diharapkan hadir tepat waktu.\n3. Konfirmasi kehadiran dapat disampaikan melalui email atau telepon.\n4. Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.",
            
            "1. Kami memerlukan data terkait untuk keperluan pelaporan.\n2. Data dapat dikirimkan paling lambat 7 hari kerja.\n3. Format data disesuaikan dengan template yang terlampir.\n4. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.",
            
            "1. Rapat akan dilaksanakan pada hari dan tanggal yang akan ditentukan.\n2. Tempat pelaksanaan di Ruang Rapat Utama.\n3. Agenda rapat terlampir.\n4. Demikian undangan ini kami sampaikan, atas perhatian dan kehadirannya kami ucapkan terima kasih.",
        ];
        
        return $this->faker->randomElement($isi);
    }

    private function generateNIP(): ?string
    {
        return $this->faker->boolean(70) 
            ? $this->faker->numerify('##########') 
            : null;
    }

    private function generateTembusanData(): array
    {
        $tembusan_options = [
            ['Direktur Utama', 'Kepala Bagian SDM', 'Arsip'],
            ['Direktur', 'Manajer Operasional', 'Pertinggal'],
            ['Kepala Klinik', 'Koordinator Medis', 'Arsip'],
            ['Direktur Keuangan', 'Kepala Bagian Umum'],
        ];
        
        return $this->faker->randomElement($tembusan_options);
    }
}