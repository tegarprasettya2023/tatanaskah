<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_type',
        'kop_type',
        'nomor',
        'letter_date',
        'tempat',
        // Perjanjian Kerja Sama
        'pihak1',
        'institusi1',
        'jabatan1',
        'nama1',
        'pihak2',
        'institusi2',
        'jabatan2',
        'nama2',
        'tentang',
        'pasal_data',
        // Surat Dinas
        'sifat',
        'lampiran',
        'perihal',
        'kepada',
        'kepada_tempat',
        'sehubungan_dengan',
        'isi_surat',
        'nip',
        'tembusan_data',
        // File
        'generated_file',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'pasal_data' => 'array',
        'tembusan_data' => 'array',
    ];

    public function getFormattedLetterDateAttribute()
    {
        return $this->letter_date ? Carbon::parse($this->letter_date)->translatedFormat('l, d F Y') : null;
    }

    public function scopeByTemplate($query, $template)
    {
        return $query->where('template_type', $template);
    }

    public function scopeByKop($query, $kop)
    {
        return $query->where('kop_type', $kop);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nomor', 'like', "%{$search}%")
              ->orWhere('pihak1', 'like', "%{$search}%")
              ->orWhere('pihak2', 'like', "%{$search}%")
              ->orWhere('tentang', 'like', "%{$search}%")
              ->orWhere('kepada', 'like', "%{$search}%")
              ->orWhere('perihal', 'like', "%{$search}%");
        });
    }

    public function getTotalPasal()
    {
        return count($this->pasal_data ?? []);
    }
}
