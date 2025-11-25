<?php

namespace Database\Factories;

use App\Models\PersonalLetterBeritaAcara;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterBeritaAcaraFactory extends Factory
{
    protected $model = PersonalLetterBeritaAcara::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        $tanggalAcara = $this->faker->dateTimeBetween("-1 year", "now");
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'tanggal_acara' => $tanggalAcara,
            
            // Pihak Pertama
            'nama_pihak_pertama' => $this->faker->name(),
            'nip_pihak_pertama' => $this->faker->boolean(70) ? $this->faker->numerify('##########') : null,
            'jabatan_pihak_pertama' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Manajer Umum'
            ]),
            
            // Pihak Kedua
            'pihak_kedua' => $this->faker->name(),
            'nik_pihak_kedua' => $this->faker->boolean(70) ? $this->faker->numerify('################') : null,
            
            // Isi
            'telah_melaksanakan' => $this->generateTelahMelaksanakan(),
            'kegiatan' => $this->generateKegiatan(),
            'dibuat_berdasarkan' => $this->generateDibuatBerdasarkan(),
            
            // TTD
            'tempat_ttd' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta']),
            'tanggal_ttd' => $tanggalAcara,
            
            // Mengetahui
            'nama_mengetahui' => $this->faker->name(),
            'jabatan_mengetahui' => $this->faker->randomElement([
                'Direktur Utama',
                'Wakil Direktur',
                'Kepala Bagian'
            ]),
            'nik_mengetahui' => $this->faker->boolean(70) ? $this->faker->numerify('################') : null,
            
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
        return "{$number}/{$prefix}/BA/{$month}/{$year}";
    }

    private function generateTelahMelaksanakan(): string
    {
        $options = [
            'serah terima barang inventaris kantor',
            'pemeriksaan dan verifikasi dokumen administrasi',
            'evaluasi kinerja karyawan periode triwulan',
            'audit internal terhadap sistem keuangan',
            'penerimaan dan instalasi peralatan medis',
            'rapat koordinasi dengan vendor',
        ];
        
        return $this->faker->randomElement($options);
    }

    private function generateKegiatan(): array
    {
        $kegiatan_options = [
            [
                ['item' => 'Pemeriksaan kelengkapan dokumen', 'keterangan' => 'Sesuai dan lengkap'],
                ['item' => 'Verifikasi kondisi barang', 'keterangan' => 'Dalam keadaan baik'],
                ['item' => 'Penandatanganan berita acara', 'keterangan' => 'Disetujui kedua belah pihak'],
            ],
            [
                ['item' => 'Pembukaan acara', 'keterangan' => 'Pukul 09.00 WIB'],
                ['item' => 'Presentasi hasil kerja', 'keterangan' => 'Selesai sesuai target'],
                ['item' => 'Tanya jawab', 'keterangan' => 'Berjalan lancar'],
                ['item' => 'Penutupan', 'keterangan' => 'Pukul 12.00 WIB'],
            ],
            [
                ['item' => 'Penerimaan barang', 'keterangan' => 'Jumlah sesuai PO'],
                ['item' => 'Inspeksi kualitas', 'keterangan' => 'Memenuhi standar'],
                ['item' => 'Dokumentasi', 'keterangan' => 'Foto terlampir'],
            ],
        ];
        
        return $this->faker->randomElement($kegiatan_options);
    }

    private function generateDibuatBerdasarkan(): string
    {
        $options = [
            'Berita acara ini dibuat dengan sebenarnya dan ditandatangani oleh kedua belah pihak dalam keadaan sadar dan tanpa paksaan.',
            'Demikian berita acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya.',
            'Berita acara ini dibuat dalam rangkap 2 (dua) yang masing-masing mempunyai kekuatan hukum yang sama.',
            'Dibuat dengan sebenar-benarnya untuk keperluan administrasi dan dapat dipergunakan sebagaimana mestinya.',
        ];
        
        return $this->faker->randomElement($options);
    }
}