<?php

namespace Database\Factories;

use App\Models\PersonalLetterPerintah;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterPerintahFactory extends Factory
{
    protected $model = PersonalLetterPerintah::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'template_type' => 'surat_perintah',
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'letter_date' => $this->faker->dateTimeBetween("-1 year", "now"),
            'tempat' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta', 'Semarang']),
            
            // Menimbang
            'menimbang' => $this->generateMenimbang(),
            
            // Dasar
            'dasar' => $this->generateDasar(),
            
            // Penerima Perintah (opsional)
            'nama_penerima' => $this->faker->boolean(60) ? $this->faker->name() : null,
            'nik_penerima' => $this->faker->boolean(60) ? $this->faker->numerify('################') : null,
            'jabatan_penerima' => $this->faker->boolean(60) ? $this->faker->randomElement([
                'Kepala Bagian Umum',
                'Manajer Operasional',
                'Supervisor',
                'Koordinator Tim',
            ]) : null,
            'nama_nama_terlampir' => $this->faker->boolean(40) ? 'Terlampir dalam lampiran surat ini' : null,
            
            // Untuk
            'untuk' => $this->generateUntuk(),
            
            // Tembusan
            'tembusan' => $this->faker->boolean(70) ? $this->generateTembusan() : null,
            
            // Pembuat/Penandatangan
            'jabatan_pembuat' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Manajer Umum'
            ]),
            'nama_pembuat' => $this->faker->name(),
            'nik_pembuat' => $this->faker->numerify('################'),
            
            // Lampiran
            'lampiran' => $this->faker->boolean(50) ? $this->generateLampiran() : null,
            
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
        return "{$number}/{$prefix}/SPRINT/{$month}/{$year}";
    }

    private function generateMenimbang(): array
    {
        $options = [
            'bahwa dalam rangka meningkatkan kualitas pelayanan kepada masyarakat, diperlukan koordinasi yang baik',
            'bahwa untuk kelancaran operasional institusi, perlu dilakukan pengaturan tugas dan tanggung jawab',
            'bahwa diperlukan penugasan khusus untuk menangani kegiatan tertentu',
            'bahwa untuk mencapai target yang telah ditetapkan, perlu adanya penugasan kepada personel yang kompeten',
        ];
        
        $count = $this->faker->numberBetween(2, 4);
        return $this->faker->randomElements($options, $count);
    }

    private function generateDasar(): array
    {
        $options = [
            'Undang-Undang Nomor 36 Tahun 2009 tentang Kesehatan',
            'Peraturan Menteri Kesehatan Nomor 9 Tahun 2014',
            'Keputusan Direktur Utama Nomor ' . $this->faker->numerify('###') . '/DIR/' . date('Y'),
            'Surat Keputusan Nomor ' . $this->faker->numerify('###') . '/SK/' . date('Y'),
            'Rapat Koordinasi tanggal ' . $this->faker->date('d F Y'),
        ];
        
        $count = $this->faker->numberBetween(2, 3);
        return $this->faker->randomElements($options, $count);
    }

    private function generateUntuk(): array
    {
        $options = [
            'Melaksanakan kegiatan koordinasi dengan pihak terkait',
            'Menyusun laporan pelaksanaan kegiatan',
            'Melakukan monitoring dan evaluasi program',
            'Mengikuti rapat koordinasi setiap hari Senin pukul 09.00 WIB',
            'Menyampaikan hasil kegiatan kepada atasan langsung',
            'Bertanggung jawab penuh terhadap pelaksanaan tugas',
        ];
        
        $count = $this->faker->numberBetween(3, 5);
        return $this->faker->randomElements($options, $count);
    }

    private function generateTembusan(): array
    {
        $options = [
            ['Direktur Utama', 'Kepala Bagian SDM', 'Arsip'],
            ['Direktur', 'Manajer HRD', 'Pertinggal'],
            ['Wakil Direktur', 'Kabag Umum', 'Arsip'],
            ['Kepala Bagian Keuangan', 'Koordinator', 'Pertinggal'],
        ];
        
        return $this->faker->randomElement($options);
    }

    private function generateLampiran(): array
    {
        return [
            'Daftar nama peserta',
            'Jadwal kegiatan',
            'Anggaran biaya',
        ];
    }
}