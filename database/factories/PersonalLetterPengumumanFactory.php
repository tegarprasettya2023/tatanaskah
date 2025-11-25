<?php

namespace Database\Factories;

use App\Models\PersonalLetterPengumuman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PersonalLetterPengumumanFactory extends Factory
{
    protected $model = PersonalLetterPengumuman::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $tanggalTtd = $this->faker->dateTimeBetween("-1 year", "now");
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomor($tanggalTtd),
            'tentang' => $this->generateTentang(),
            'isi_pembuka' => $this->generateIsiPembuka(),
            'isi_penutup' => $this->generateIsiPenutup(),
            'tempat_ttd' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta']),
            'tanggal_ttd' => $tanggalTtd,
            'nama_pembuat' => $this->faker->name(),
            'nik_pegawai' => $this->faker->boolean(70) ? $this->faker->numerify('################') : null,
            'jabatan_pembuat' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Manajer HRD',
                'Kepala Bagian Umum'
            ]),
            'generated_file' => null,
        ];
    }

    private function generateNomor($tanggal): string
    {
        $date = Carbon::parse($tanggal);
        $bulanRomawi = $this->getRomanMonth($date->month);
        $tahun = $date->year;
        $urutan = str_pad($this->faker->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);
        
        return "UM/{$urutan}/{$bulanRomawi}/{$tahun}";
    }

    private function getRomanMonth($month): string
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romans[$month] ?? 'I';
    }

    private function generateTentang(): string
    {
        $topics = [
            'Libur Hari Raya',
            'Perubahan Jam Operasional',
            'Rekrutmen Pegawai Baru',
            'Pemeliharaan Sistem',
            'Pelatihan Karyawan',
            'Evaluasi Kinerja',
            'Penerimaan Magang',
            'Update Kebijakan Cuti',
        ];
        
        return $this->faker->randomElement($topics);
    }

    private function generateIsiPembuka(): string
    {
        $options = [
            "Dengan hormat, bersama ini kami sampaikan pengumuman sebagai berikut:\n\n1. Dalam rangka perayaan hari besar nasional, institusi akan tutup selama 3 hari.\n2. Pelayanan akan kembali normal setelah libur berakhir.\n3. Untuk keperluan darurat dapat menghubungi nomor yang tertera.\n\nDemikian pengumuman ini kami sampaikan untuk diketahui dan dimaklumi.",
            
            "Kepada seluruh karyawan dan mitra kerja,\n\nDiberitahukan bahwa:\n\n1. Akan dilaksanakan pemeliharaan sistem pada akhir pekan ini.\n2. Seluruh sistem akan offline sementara waktu.\n3. Mohon menyimpan semua data penting sebelum waktu yang ditentukan.\n\nAtas perhatian dan kerjasamanya kami ucapkan terima kasih.",
            
            "Pengumuman penting untuk seluruh staff:\n\n1. Institusi akan melakukan rekrutmen pegawai baru bulan depan.\n2. Lowongan tersedia untuk berbagai posisi.\n3. Informasi lengkap dapat dilihat di papan pengumuman.\n4. Pendaftaran dibuka mulai minggu depan.\n\nTerima kasih atas perhatiannya.",
        ];
        
        return $this->faker->randomElement($options);
    }

    private function generateIsiPenutup(): string
    {
        $options = [
            'Demikian pengumuman ini disampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.',
            'Atas perhatian dan kerjasamanya, kami sampaikan terima kasih.',
            'Demikian untuk diketahui dan dilaksanakan sebagaimana mestinya.',
            'Terima kasih atas perhatian dan kerjasamanya.',
        ];
        
        return $this->faker->randomElement($options);
    }
}