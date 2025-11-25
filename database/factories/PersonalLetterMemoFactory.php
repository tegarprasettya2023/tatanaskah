<?php

namespace Database\Factories;

use App\Models\PersonalLetterMemo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterMemoFactory extends Factory
{
    protected $model = PersonalLetterMemo::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'template_type' => 'internal_memo',
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'tempat_ttd' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta']),
            'letter_date' => $this->faker->dateTimeBetween("-1 year", "now"),
            
            // Penerima
            'yth_nama' => $this->faker->randomElement([
                'Seluruh Staff',
                'Kepala Bagian',
                'Tim Medis',
                'Bagian Keuangan',
                'Seluruh Karyawan'
            ]),
            'hal' => $this->generateHal(),
            
            // Isi Memo
            'sehubungan_dengan' => $this->generateSehubunganDengan(),
            'alinea_isi' => $this->generateAlineaIsi(),
            'isi_penutup' => $this->generateIsiPenutup(),
            
            // Penandatangan
            'jabatan_pembuat' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Manajer HRD',
                'Kepala Bagian Umum'
            ]),
            'nama_pembuat' => $this->faker->name(),
            'nik_pembuat' => $this->faker->boolean(70) ? $this->faker->numerify('################') : null,
            
            // Tembusan
            'tembusan' => $this->faker->boolean(60) ? $this->generateTembusan() : null,
            
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
        return "{$number}/{$prefix}/MEMO/{$month}/{$year}";
    }

    private function generateHal(): string
    {
        $hal_options = [
            'Pengumuman Libur Nasional',
            'Perubahan Jadwal Operasional',
            'Pemberitahuan Pemeliharaan Sistem',
            'Himbauan Protokol Kesehatan',
            'Reminder Laporan Bulanan',
            'Update Kebijakan Institusi',
        ];
        
        return $this->faker->randomElement($hal_options);
    }

    private function generateSehubunganDengan(): string
    {
        $options = [
            'Sehubungan dengan rencana kegiatan pemeliharaan sistem informasi, kami sampaikan hal-hal sebagai berikut:',
            'Berkaitan dengan kebijakan baru yang akan diterapkan, dengan ini kami informasikan:',
            'Dalam rangka meningkatkan kualitas pelayanan, kami sampaikan beberapa hal:',
            'Terkait dengan pemberitahuan penting, bersama ini kami sampaikan:',
        ];
        
        return $this->faker->randomElement($options);
    }

    private function generateAlineaIsi(): string
    {
        $options = [
            "1. Kegiatan akan dilaksanakan pada tanggal yang akan ditentukan kemudian.\n2. Seluruh staff dimohon untuk mempersiapkan data yang diperlukan.\n3. Koordinasi lebih lanjut akan disampaikan melalui email.\n4. Mohon perhatian dan kerjasamanya.",
            
            "1. Pemberlakuan kebijakan baru mulai berlaku bulan depan.\n2. Setiap bagian diminta untuk menyesuaikan prosedur kerja.\n3. Sosialisasi akan dilakukan minggu depan.\n4. Informasi detail akan disampaikan kemudian.",
            
            "1. Sistem akan mengalami pemeliharaan pada akhir pekan.\n2. Diharapkan semua data sudah tersimpan dengan baik.\n3. Akses sistem akan dibatasi sementara.\n4. Terima kasih atas pengertiannya.",
        ];
        
        return $this->faker->randomElement($options);
    }

    private function generateIsiPenutup(): string
    {
        $options = [
            'Demikian memo ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.',
            'Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.',
            'Terima kasih atas perhatian dan kerjasamanya.',
            'Demikian untuk menjadi perhatian bersama.',
        ];
        
        return $this->faker->randomElement($options);
    }

    private function generateTembusan(): array
    {
        $tembusan_options = [
            ['Direktur Utama', 'Arsip'],
            ['Wakil Direktur', 'Pertinggal'],
            ['Kepala Bagian', 'Arsip'],
        ];
        
        return $this->faker->randomElement($tembusan_options);
    }
}