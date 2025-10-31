<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterInstruksiKerja extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_instruksi_kerja';

    protected $fillable = [
        'logo_kiri',
        'logo_kanan',
        'kop_type',
        'judul_ik',
        'no_dokumen',
        'no_revisi',
        'tanggal_terbit',
        'halaman',
        'jabatan_menetapkan',
        'nama_menetapkan',
        'nip_menetapkan',
        'pengertian',
        'tujuan',
        'kebijakan',
        'pelaksana',
        'prosedur_kerja',
        'hal_hal_perlu_diperhatikan',
        'unit_terkait',
        'dokumen_terkait',
        'referensi',
        'rekaman_histori',
        'dibuat_jabatan',
        'dibuat_nama',
        'dibuat_tanggal',
        'direview_jabatan',
        'direview_nama',
        'direview_tanggal',
        'generated_file',
    ];

    /**
     * Kolom yang otomatis dikonversi ke array saat diambil dari database.
     */
    protected $casts = [
        'prosedur_kerja' => 'array',
        'rekaman_histori' => 'array',
        'tanggal_terbit' => 'date',
        'dibuat_tanggal' => 'date',
        'direview_tanggal' => 'date',
    ];
}
