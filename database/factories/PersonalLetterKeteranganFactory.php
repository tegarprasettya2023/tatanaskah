<?php

namespace Database\Factories;

use App\Models\PersonalLetterKeterangan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterKeteranganFactory extends Factory
{
    protected $model = PersonalLetterKeterangan::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'template_type' => 'surat_keterangan',
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'letter_date' => $this->faker->dateTimeBetween("-1 year", "now"),
            'tempat' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta', 'Semarang']),
            
            // Data yang menerangkan
            'nama_yang_menerangkan' => $this->faker->name(),
            'nik_yang_menerangkan' => $this->faker->numerify('################'),
            'jabatan_yang_menerangkan' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Manajer HRD',
                'Kepala Bagian SDM'
            ]),
            
            // Data yang diterangkan
            'nama_yang_diterangkan' => $this->faker->name(),
            'nip_yang_diterangkan' => $this->generateNIP(),
            'jabatan_yang_diterangkan' => $this->faker->randomElement([
                'Dokter Umum',
                'Perawat',
                'Analis Laboratorium',
                'Administrasi',
                'Staff Keuangan',
                'Apoteker',
                'Radiografer'
            ]),
            
            // Isi keterangan
            'isi_keterangan' => $this->generateIsiKeterangan(),
            
            // Penandatangan
            'jabatan_pembuat' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Manajer HRD'
            ]),
            'nama_pembuat' => $this->faker->name(),
            'nik_pembuat' => $this->faker->numerify('################'),
            
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

    private function generateNIP(): string
    {
        return $this->faker->numerify('##########');
    }

    private function generateIsiKeterangan(): string
    {
        $jenis_keterangan = [
            'kerja' => [
                'Bahwa yang bersangkutan adalah karyawan tetap pada institusi kami sejak %s dan masih aktif bekerja hingga saat ini dengan jabatan sebagai %s.',
                'Bahwa nama tersebut di atas benar adalah karyawan kami yang bekerja sejak %s dengan status karyawan tetap dan memiliki kinerja yang baik.',
                'Bahwa yang bersangkutan telah bekerja di institusi kami sejak %s dengan jabatan %s dan telah menunjukkan dedikasi serta loyalitas yang tinggi.',
            ],
            'sehat' => [
                'Bahwa berdasarkan pemeriksaan kesehatan yang telah dilakukan, yang bersangkutan dinyatakan dalam kondisi sehat dan layak untuk melaksanakan tugas.',
                'Bahwa yang bersangkutan telah menjalani pemeriksaan kesehatan berkala dan dinyatakan sehat tanpa ada keluhan atau penyakit yang dapat mengganggu aktivitas kerja.',
            ],
            'pengalaman' => [
                'Bahwa yang bersangkutan telah bekerja dengan baik dan profesional selama bekerja di institusi kami.',
                'Bahwa selama bekerja, yang bersangkutan menunjukkan etos kerja yang tinggi, disiplin, dan bertanggung jawab dalam menjalankan tugas.',
            ],
        ];
        
        $kategori = $this->faker->randomElement(array_keys($jenis_keterangan));
        $template = $this->faker->randomElement($jenis_keterangan[$kategori]);
        
        if ($kategori === 'kerja') {
            $tanggal_mulai = $this->faker->date('d F Y', '-3 years');
            $jabatan = $this->faker->randomElement(['Dokter', 'Perawat', 'Analis', 'Staff Administrasi']);
            return sprintf($template, $tanggal_mulai, $jabatan);
        }
        
        return $template;
    }
}