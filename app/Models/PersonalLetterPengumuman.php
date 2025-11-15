<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterPengumuman extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_pengumuman';

    protected $fillable = [
        'user_id',
        'kop_type',
        'nomor',
        'tentang',
        'tanggal_surat',
        'isi_pembuka',
        'isi_penutup',
        'tempat_ttd',
        'tanggal_ttd',
        'nama_pembuat',
        'nik_pegawai',
        'jabatan_pembuat',
        'generated_file',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_ttd' => 'date',
    ];
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nomor', 'like', "%{$term}%")
              ->orWhere('isi_pembuka', 'like', "%{$term}%")
              ->orWhere('nama_pembuat', 'like', "%{$term}%");
        });
    }

    /**
     * Generate nomor surat otomatis: UM/001/bulan/tahun
     */
    public static function generateNomor($tanggalSurat = null)
    {
        $date = $tanggalSurat ? Carbon::parse($tanggalSurat) : now();
        $bulanRomawi = self::getRomanMonth($date->month);
        $tahun = $date->year;

        // Hitung jumlah surat di bulan dan tahun yang sama
        $count = self::whereYear('tanggal_surat', $tahun)
                     ->whereMonth('tanggal_surat', $date->month)
                     ->count();

        $urutan = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return "UM/{$urutan}/{$bulanRomawi}/{$tahun}";
    }

    /**
     * Konversi bulan ke angka Romawi
     */
    private static function getRomanMonth($month)
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romans[$month] ?? 'I';
    }
}