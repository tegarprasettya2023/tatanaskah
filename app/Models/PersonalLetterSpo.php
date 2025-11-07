<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterSpo extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_spo';

    protected $fillable = [
        'logo_kiri',
        'logo_kanan',
        'kop_type',
        'judul_spo',
        'no_dokumen',
        'no_revisi',
        'tanggal_terbit',
        'halaman',
        'jabatan_menetapkan',
        'nama_menetapkan',
        'nip_menetapkan',
        'label_1', 'content_1',
        'label_2', 'content_2',
        'label_3', 'content_3',
        'label_4', 'content_4',
        'label_5', 'bagan_alir_image',
        'label_6', 'content_6',
        'label_7', 'content_7',
        'label_8', 'content_8',
        'label_9', 'content_9',
        'label_10', 'rekaman_historis',
        'dibuat_jabatan',
        'dibuat_nama',
        'dibuat_tanggal',
        'direview_jabatan',
        'direview_nama',
        'direview_tanggal',
        'generated_file',
        'letter_date',
        'nomor',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'dibuat_tanggal' => 'date',
        'direview_tanggal' => 'date',
        'letter_date' => 'date',
        'rekaman_historis' => 'array',
    ];

    public function getFormattedTanggalTerbitAttribute()
    {
        return $this->tanggal_terbit ? $this->tanggal_terbit->format('d/m/Y') : '-';
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('judul_spo', 'like', "%{$search}%")
              ->orWhere('no_dokumen', 'like', "%{$search}%")
              ->orWhere('nomor', 'like', "%{$search}%");
        });
    }
}