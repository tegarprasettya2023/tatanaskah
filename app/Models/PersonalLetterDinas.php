<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterDinas extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_dinas'; // tabel khusus surat dinas

    protected $fillable = [
        'template_type',
        'kop_type',
        'nomor',
        'letter_date',
        'tempat',
        'sifat',
        'lampiran',
        'perihal',
        'kepada',
        'kepada_tempat',
        'sehubungan_dengan',
        'isi_surat',
        'nama1',
        'jabatan1',
        'nip',
        'tembusan_data',
        'generated_file',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'tembusan_data' => 'array',
    ];

    public function getFormattedLetterDateAttribute()
    {
        return $this->letter_date ? Carbon::parse($this->letter_date)->translatedFormat('l, d F Y') : null;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nomor', 'like', "%{$search}%")
              ->orWhere('kepada', 'like', "%{$search}%")
              ->orWhere('perihal', 'like', "%{$search}%");
        });
    }
}
