<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterNotulen extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_notulen';

    protected $fillable = [
        'kop_type',
        'isi_notulen',
        'tanggal_rapat',
        'waktu',
        'tempat',
        'pimpinan_rapat',
        'peserta_rapat',
        'kegiatan_rapat',
        'kepala_lab',
        'nik_kepala_lab',
        'notulis',
        'nik_notulis',
        'judul_dokumentasi',
        'dokumentasi',
        'generated_file',
    ];

    protected $casts = [
        'tanggal_rapat' => 'date',
        'kegiatan_rapat' => 'array',
        'dokumentasi' => 'array',
    ];

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('isi_notulen', 'like', "%{$term}%")
              ->orWhere('pimpinan_rapat', 'like', "%{$term}%")
              ->orWhere('tempat', 'like', "%{$term}%");
        });
    }

    /**
     * Generate nomor notulen otomatis
     */
    public static function generateNomor()
    {
        $count = self::count();
        return 'NTL-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}