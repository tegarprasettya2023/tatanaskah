<?php

namespace Database\Factories;

use App\Models\PersonalLetterNotulen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterNotulenFactory extends Factory
{
    protected $model = PersonalLetterNotulen::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $tanggalRapat = $this->faker->dateTimeBetween("-6 months", "now");
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'kop_type' => $kop_type,
            'isi_notulen' => $this->generateIsiNotulen(),
            'tanggal_rapat' => $tanggalRapat,
            'tanggal_ttd' => $tanggalRapat,
            'waktu' => $this->faker->randomElement(['08:00', '09:00', '10:00', '13:00', '14:00']),
            'tempat' => $this->generateTempat(),
            'pimpinan_rapat' => $this->faker->name(),
            'peserta_rapat' => $this->generatePesertaRapat(),
            'kegiatan_rapat' => $this->generateKegiatanRapat(),
            
            // Penandatangan
            'ttd_jabatan_1' => $this->faker->randomElement([
                'Direktur Utama',
                'Kepala Laboratorium',
                'Direktur',
                'Manajer Umum'
            ]),
            'nama_ttd_jabatan_1' => $this->faker->name(),
            'nik_ttd_jabatan_1' => $this->faker->boolean(70) ? $this->faker->numerify('################') : null,
            
            'ttd_jabatan_2' => 'Notulis',
            'nama_ttd_jabatan_2' => $this->faker->name(),
            'nik_ttd_jabatan_2' => $this->faker->boolean(70) ? $this->faker->numerify('################') : null,
            
            // Dokumentasi
            'judul_dokumentasi' => $this->faker->boolean(50) ? 'Dokumentasi Rapat' : null,
            'dokumentasi' => $this->faker->boolean(50) ? [] : null, // Empty array untuk dokumentasi
            
            'generated_file' => null,
        ];
    }

    private function generateIsiNotulen(): string
    {
        $topics = [
            'Rapat Koordinasi Tim',
            'Evaluasi Kinerja Triwulan',
            'Rapat Pembahasan Program Kerja',
            'Rapat Monitoring dan Evaluasi',
            'Rapat Perencanaan Anggaran',
        ];
        
        return $this->faker->randomElement($topics);
    }

    private function generateTempat(): string
    {
        $tempat = [
            'Ruang Rapat Utama Lt. 2',
            'Aula Gedung Utama',
            'Ruang Meeting Lt. 3',
            'Ruang Direktur',
            'Ruang Seminar',
        ];
        
        return $this->faker->randomElement($tempat);
    }

    private function generatePesertaRapat(): string
    {
        $jumlah = $this->faker->numberBetween(5, 12);
        $peserta = [];
        
        for ($i = 0; $i < $jumlah; $i++) {
            $peserta[] = $this->faker->name();
        }
        
        return implode(', ', $peserta);
    }

    private function generateKegiatanRapat(): array
    {
        $kegiatan_options = [
            [
                ['waktu' => '09:00 - 09:15', 'kegiatan' => 'Pembukaan dan pengantar oleh pimpinan rapat'],
                ['waktu' => '09:15 - 10:00', 'kegiatan' => 'Presentasi laporan kinerja periode sebelumnya'],
                ['waktu' => '10:00 - 10:15', 'kegiatan' => 'Coffee break'],
                ['waktu' => '10:15 - 11:30', 'kegiatan' => 'Diskusi dan pembahasan program kerja'],
                ['waktu' => '11:30 - 12:00', 'kegiatan' => 'Kesimpulan dan penutupan'],
            ],
            [
                ['waktu' => '13:00 - 13:15', 'kegiatan' => 'Registrasi peserta'],
                ['waktu' => '13:15 - 14:00', 'kegiatan' => 'Paparan materi oleh narasumber'],
                ['waktu' => '14:00 - 14:45', 'kegiatan' => 'Tanya jawab dan diskusi'],
                ['waktu' => '14:45 - 15:00', 'kegiatan' => 'Kesimpulan dan tindak lanjut'],
            ],
            [
                ['waktu' => '08:00 - 08:30', 'kegiatan' => 'Pembukaan rapat koordinasi'],
                ['waktu' => '08:30 - 09:30', 'kegiatan' => 'Review progress pekerjaan'],
                ['waktu' => '09:30 - 10:30', 'kegiatan' => 'Identifikasi kendala dan solusi'],
                ['waktu' => '10:30 - 11:00', 'kegiatan' => 'Penetapan target minggu depan'],
            ],
        ];
        
        return $this->faker->randomElement($kegiatan_options);
    }
}