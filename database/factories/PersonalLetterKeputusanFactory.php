<?php

namespace Database\Factories;

use App\Models\PersonalLetterKeputusan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterKeputusanFactory extends Factory
{
    protected $model = PersonalLetterKeputusan::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'kop_type' => $kop_type,
            'judul' => $this->generateJudul(),
            'judul_2' => $this->faker->boolean(60) ? $this->generateJudul2() : null,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'tentang' => $this->generateTentang(),
            'menimbang' => $this->generateMenimbang(),
            'mengingat' => $this->generateMengingat(),
            'menetapkan' => 'MEMUTUSKAN',
            'isi_keputusan' => $this->generateIsiKeputusan(),
            'tanggal_penetapan' => $this->faker->dateTimeBetween("-1 year", "now"),
            'tempat_penetapan' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta']),
            'nama_pejabat' => $this->faker->name(),
            'jabatan_pejabat' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Kepala Laboratorium'
            ]),
            'nik_pejabat' => $this->faker->boolean(70) ? $this->faker->numerify('################') : null,
            'tembusan' => $this->faker->boolean(70) ? $this->generateTembusan() : null,
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
        return "{$number}/{$prefix}/SK/{$month}/{$year}";
    }

    private function generateJudul(): string
    {
        $judul = [
            'SURAT KEPUTUSAN',
            'KEPUTUSAN DIREKTUR',
            'KEPUTUSAN KEPALA KLINIK',
            'KEPUTUSAN KEPALA LABORATORIUM',
        ];
        
        return $this->faker->randomElement($judul);
    }

    private function generateJudul2(): string
    {
        return $this->faker->company();
    }

    private function generateTentang(): string
    {
        $tentang = [
            'Pembentukan Tim Kerja Pengembangan Sistem Informasi',
            'Penetapan Standar Operasional Prosedur Pelayanan',
            'Pengangkatan Koordinator Program Mutu',
            'Pemberlakuan Kebijakan Baru Jam Operasional',
            'Pembentukan Panitia Evaluasi Kinerja',
            'Penetapan Tim Audit Internal',
        ];
        
        return $this->faker->randomElement($tentang);
    }

    private function generateMenimbang(): array
    {
        $options = [
            'bahwa dalam rangka meningkatkan kualitas pelayanan kepada masyarakat, diperlukan pengaturan yang jelas dan sistematis',
            'bahwa untuk mencapai visi dan misi institusi, perlu dibentuk tim yang solid dan profesional',
            'bahwa berdasarkan hasil rapat koordinasi, diperlukan penetapan kebijakan baru',
            'bahwa untuk kelancaran operasional, perlu ditetapkan struktur organisasi yang efektif',
        ];
        
        $count = $this->faker->numberBetween(2, 4);
        return array_map(fn($i, $text) => ['huruf' => chr(97 + $i), 'isi' => $text], 
            array_keys($selected = $this->faker->randomElements($options, $count)), 
            $selected
        );
    }

    private function generateMengingat(): array
    {
        $options = [
            'Undang-Undang Nomor 36 Tahun 2009 tentang Kesehatan',
            'Peraturan Menteri Kesehatan Nomor 9 Tahun 2014',
            'Keputusan Direktur Utama Nomor ' . $this->faker->numerify('###') . '/DIR/' . date('Y'),
            'Surat Keputusan Nomor ' . $this->faker->numerify('###') . '/SK/' . date('Y'),
        ];
        
        $count = $this->faker->numberBetween(2, 4);
        return array_map(fn($i, $text) => ['nomor' => $i + 1, 'isi' => $text], 
            array_keys($selected = $this->faker->randomElements($options, $count)), 
            $selected
        );
    }

    private function generateIsiKeputusan(): array
    {
        return [
            [
                'pasal' => 'KESATU',
                'isi' => 'Membentuk Tim Kerja dengan susunan dan tugas sebagaimana tercantum dalam lampiran keputusan ini.'
            ],
            [
                'pasal' => 'KEDUA',
                'isi' => 'Tim sebagaimana dimaksud dalam diktum KESATU bertugas melaksanakan koordinasi, monitoring, dan evaluasi program sesuai dengan bidang tugasnya.'
            ],
            [
                'pasal' => 'KETIGA',
                'isi' => 'Keputusan ini berlaku sejak tanggal ditetapkan dan akan ditinjau kembali sesuai kebutuhan.'
            ],
            [
                'pasal' => 'KEEMPAT',
                'isi' => 'Apabila terdapat kekeliruan dalam keputusan ini, akan diadakan perbaikan sebagaimana mestinya.'
            ],
        ];
    }

    private function generateTembusan(): array
    {
        $tembusan_options = [
            ['Direktur Utama', 'Kepala Bagian Terkait', 'Arsip'],
            ['Wakil Direktur', 'Manajer Operasional', 'Pertinggal'],
            ['Kepala Bagian SDM', 'Koordinator Tim', 'Arsip'],
        ];
        
        return $this->faker->randomElement($tembusan_options);
    }

    private function generateLampiran(): array
    {
        return [
            'Susunan Tim Kerja',
            'Uraian Tugas dan Tanggung Jawab',
            'Jadwal Pelaksanaan Kegiatan',
        ];
    }
}