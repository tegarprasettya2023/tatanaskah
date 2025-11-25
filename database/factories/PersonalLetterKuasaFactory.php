<?php

namespace Database\Factories;

use App\Models\PersonalLetterKuasa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterKuasaFactory extends Factory
{
    protected $model = PersonalLetterKuasa::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'letter_date' => $this->faker->dateTimeBetween("-1 year", "now"),
            'tempat' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta', 'Semarang']),
            
            // Pemberi Kuasa
            'nama_pemberi' => $this->faker->name(),
            'nip_pemberi' => $this->faker->numerify('##########'),
            'jabatan_pemberi' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Manajer Umum'
            ]),
            'alamat_pemberi' => $this->faker->address(),
            
            // Penerima Kuasa
            'nama_penerima' => $this->faker->name(),
            'nip_penerima' => $this->faker->numerify('##########'),
            'jabatan_penerima' => $this->faker->randomElement([
                'Wakil Direktur',
                'Kepala Bagian',
                'Manajer',
                'Supervisor'
            ]),
            'alamat_penerima' => $this->faker->address(),
            
            // Isi
            'isi' => $this->generateIsi(),
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
        return "{$number}/{$prefix}/KUASA/{$month}/{$year}";
    }

    private function generateIsi(): string
    {
        $isiOptions = [
            "Untuk dan atas nama pemberi kuasa, mewakili pemberi kuasa dalam menghadiri rapat koordinasi, menandatangani dokumen-dokumen yang diperlukan, serta melakukan tindakan-tindakan lain yang diperlukan sehubungan dengan pelaksanaan tugas dan tanggung jawab pemberi kuasa.",
            
            "Untuk bertindak mewakili pemberi kuasa dalam segala hal yang berkaitan dengan pengelolaan administrasi, keuangan, dan operasional, termasuk namun tidak terbatas pada penandatanganan dokumen, surat-menyurat, dan mengambil keputusan yang diperlukan.",
            
            "Untuk mewakili pemberi kuasa dalam menghadiri pertemuan, rapat, dan acara resmi lainnya, serta membuat dan menandatangani perjanjian, kontrak, atau dokumen lain yang diperlukan dalam menjalankan tugas dan wewenang pemberi kuasa.",
            
            "Untuk mengurus segala keperluan administrasi dan operasional terkait dengan kegiatan institusi, termasuk menghadiri rapat, menandatangani dokumen, dan melakukan koordinasi dengan pihak-pihak terkait atas nama pemberi kuasa.",
        ];
        
        return $this->faker->randomElement($isiOptions);
    }
}