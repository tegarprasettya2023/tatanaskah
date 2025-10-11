<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterBeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_berita_acara';

    protected $fillable = [
        'kop_type',
        'nomor',
        'tanggal_acara',
        'nama_pihak_pertama',
        'nip_pihak_pertama',
        'jabatan_pihak_pertama',
        'pihak_kedua',
        'nik_pihak_kedua',
        'telah_melaksanakan',
        'kegiatan',
        'dibuat_berdasarkan',
        'tempat_ttd',
        'tanggal_ttd',
        'nama_mengetahui',
        'jabatan_mengetahui',
        'nik_mengetahui',
        'generated_file',
    ];

    protected $casts = [
        'tanggal_acara' => 'date',
        'tanggal_ttd' => 'date',
        'kegiatan' => 'array',
    ];

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nomor', 'like', "%{$term}%")
              ->orWhere('nama_pihak_pertama', 'like', "%{$term}%")
              ->orWhere('pihak_kedua', 'like', "%{$term}%");
        });
    }
}