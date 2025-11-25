<?php

namespace Database\Factories;

use App\Models\PersonalLetterUndangan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalLetterUndanganFactory extends Factory
{
    protected $model = PersonalLetterUndangan::class;

    public function definition(): array
    {
        $kop_type = $this->faker->randomElement(['klinik', 'lab', 'pt']);
        $year = $this->faker->numberBetween(2023, 2025);
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        $tanggalAcara = $this->faker->dateTimeBetween('now', '+2 months');
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'template_type' => 'surat_undangan',
            'kop_type' => $kop_type,
            'nomor' => $this->generateNomorSurat($kop_type, $year, $month),
            'sifat' => $this->faker->randomElement(['Biasa', 'Segera', 'Penting']),
            'lampiran' => $this->faker->randomElement(['1 (satu) berkas', '2 (dua) lembar', '-']),
            'perihal' => $this->generatePerihal(),
            
            // Penerima
            'yth_nama' => $this->faker->randomElement([
                'Yth. Bapak/Ibu Direktur',
                'Yth. Kepala Dinas Kesehatan',
                'Yth. Manajer',
                'Yth. Seluruh Staff'
            ]),
            'yth_alamat' => $this->faker->address(),
            
            // Isi Undangan
            'isi_pembuka' => $this->generateIsiPembuka(),
            'hari_tanggal' => $tanggalAcara,
            'pukul' => $this->faker->randomElement(['08.00', '09.00', '10.00', '13.00', '14.00']) . ' WIB',
            'tempat_acara' => $this->generateTempatAcara(),
            'acara' => $this->generateAcara(),
            
            // Penandatangan
            'tempat_ttd' => $this->faker->randomElement(['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta']),
            'tanggal_ttd' => $this->faker->dateTimeBetween("-1 month", "now"),
            'jabatan_pembuat' => $this->faker->randomElement([
                'Direktur Utama',
                'Direktur',
                'Kepala Klinik',
                'Manajer Umum'
            ]),
            'nama_pembuat' => $this->faker->name(),
            
            // Tembusan
            'tembusan_1' => $this->faker->boolean(70) ? 'Direktur Utama (sebagai laporan)' : null,
            'tembusan_2' => $this->faker->boolean(50) ? 'Arsip' : null,
            
            // Daftar Undangan
            'daftar_undangan' => $this->generateDaftarUndangan(),
            
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
        return "{$number}/{$prefix}/UND/{$month}/{$year}";
    }

    private function generatePerihal(): string
    {
        $perihal = [
            'Undangan Rapat Koordinasi',
            'Undangan Sosialisasi Program',
            'Undangan Pelatihan SDM',
            'Undangan Rapat Evaluasi',
            'Undangan Workshop',
            'Undangan Seminar Kesehatan',
        ];
        
        return $this->faker->randomElement($perihal);
    }

    private function generateIsiPembuka(): string
    {
        $pembuka = [
            'Sehubungan dengan rencana kegiatan yang akan dilaksanakan, dengan hormat kami mengundang Bapak/Ibu untuk dapat hadir pada:',
            'Dalam rangka meningkatkan koordinasi dan kerjasama, kami mengundang Bapak/Ibu untuk menghadiri acara:',
            'Bersama ini kami mengundang Bapak/Ibu untuk hadir dalam kegiatan:',
            'Dengan hormat, kami mengharapkan kehadiran Bapak/Ibu dalam acara:',
        ];
        
        return $this->faker->randomElement($pembuka);
    }

    private function generateTempatAcara(): string
    {
        $tempat = [
            'Ruang Rapat Utama Lantai 2',
            'Aula Gedung Utama',
            'Ruang Meeting Lt. 3',
            'Auditorium',
            'Ruang Seminar',
            'Ballroom Hotel Grand Indonesia',
        ];
        
        return $this->faker->randomElement($tempat);
    }

    private function generateAcara(): string
    {
        $acara = [
            'Rapat Koordinasi Program Kerja Tahun 2025',
            'Sosialisasi Sistem Informasi Kesehatan',
            'Pelatihan Peningkatan Kompetensi SDM',
            'Workshop Manajemen Mutu',
            'Evaluasi Kinerja Triwulan',
            'Seminar Kesehatan dan Keselamatan Kerja',
        ];
        
        return $this->faker->randomElement($acara);
    }

    private function generateDaftarUndangan(): array
    {
        $count = $this->faker->numberBetween(5, 15);
        $undangan = [];
        
        for ($i = 1; $i <= $count; $i++) {
            $undangan[] = [
                'no' => $i,
                'nama' => $this->faker->name(),
                'jabatan' => $this->faker->randomElement([
                    'Direktur',
                    'Manajer',
                    'Kepala Bagian',
                    'Supervisor',
                    'Staff',
                    'Koordinator',
                ]),
                'instansi' => $this->faker->company(),
            ];
        }
        
        return $undangan;
    }
}