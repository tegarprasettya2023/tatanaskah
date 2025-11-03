<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterKeputusan extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_keputusan';

    protected $fillable = [
        'judul',
        'judul_2', // BARU
        'kop_type',
        'nomor',
        'tentang',
        'menimbang',
        'mengingat',
        'menetapkan',
        'isi_keputusan',
        'tanggal_penetapan',
        'tempat_penetapan',
        'nama_pejabat',
        'jabatan_pejabat',
        'nik_pejabat',
        'tembusan',
        'lampiran',
        'generated_file',
    ];

    protected $casts = [
        'tanggal_penetapan' => 'date',
        'menimbang' => 'array',
        'mengingat' => 'array',
        'isi_keputusan' => 'array',
        'tembusan' => 'array',
        'lampiran' => 'array', // DIUBAH: dari text ke array
    ];

    public function scopeSearch($query, $keyword)
    {
        return $query->where('nomor', 'like', "%{$keyword}%")
                     ->orWhere('tentang', 'like', "%{$keyword}%")
                     ->orWhere('nama_pejabat', 'like', "%{$keyword}%")
                     ->orWhere('jabatan_pejabat', 'like', "%{$keyword}%")
                     ->orWhere('tempat_penetapan', 'like', "%{$keyword}%");
    }
}