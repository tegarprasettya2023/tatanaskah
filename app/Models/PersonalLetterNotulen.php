<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterNotulen extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_notulen';

    protected $fillable = [
        'user_id',
        'kop_type',
        'isi_notulen',
        'tanggal_rapat',
        'tanggal_ttd', // TAMBAHAN BARU
        'waktu',
        'tempat',
        'pimpinan_rapat',
        'peserta_rapat',
        'kegiatan_rapat',
        'ttd_jabatan_1', // Ganti kepala_lab
        'nama_ttd_jabatan_1', // TAMBAHAN BARU
        'nik_ttd_jabatan_1', // Ganti nik_kepala_lab
        'ttd_jabatan_2', // Ganti notulis
        'nama_ttd_jabatan_2', // TAMBAHAN BARU
        'nik_ttd_jabatan_2', // Ganti nik_notulis
        'judul_dokumentasi',
        'dokumentasi',
        'generated_file',
    ];

    protected $casts = [
        'tanggal_rapat' => 'date',
        'tanggal_ttd' => 'date', // TAMBAHAN BARU
        'kegiatan_rapat' => 'array',
        'dokumentasi' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('isi_notulen', 'like', "%{$term}%")
              ->orWhere('pimpinan_rapat', 'like', "%{$term}%")
              ->orWhere('tempat', 'like', "%{$term}%");
        });
    }

    public static function generateNomor()
    {
        $count = self::count();
        return 'NTL-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}