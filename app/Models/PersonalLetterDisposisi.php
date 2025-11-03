<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterDisposisi extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_disposisi';

    protected $fillable = [
        'kop_type',
        'logo_type',
        'nomor_dokumen',
        'no_revisi',
        'halaman_dari',
        'bagian_pembuat',
        'nomor_tanggal',
        'perihal',
        'kepada',
        'ringkasan_isi',
        'instruksi_1',
        'tanggal_pembuatan',
        'no_agenda',
        'signature', // Ganti dari 'paraf' ke 'signature'
        'diteruskan_kepada',
        'tanggal_diserahkan',
        'tanggal_kembali',
        'instruksi_2',
        'generated_file',
    ];

    protected $casts = [
        'tanggal_pembuatan' => 'date',
        'tanggal_diserahkan' => 'date',
        'tanggal_kembali' => 'date',
        'diteruskan_kepada' => 'array',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nomor_dokumen', 'like', "%{$search}%")
              ->orWhere('perihal', 'like', "%{$search}%")
              ->orWhere('bagian_pembuat', 'like', "%{$search}%")
              ->orWhere('kepada', 'like', "%{$search}%");
        });
    }

    public function getFormattedTanggalPembuatanAttribute()
    {
        return $this->tanggal_pembuatan 
            ? Carbon::parse($this->tanggal_pembuatan)->translatedFormat('d F Y')
            : '-';
    }

    public function getFormattedTanggalDiserahkanAttribute()
    {
        return $this->tanggal_diserahkan 
            ? Carbon::parse($this->tanggal_diserahkan)->translatedFormat('d F Y')
            : '-';
    }

    public function getFormattedTanggalKembaliAttribute()
    {
        return $this->tanggal_kembali 
            ? Carbon::parse($this->tanggal_kembali)->translatedFormat('d F Y')
            : '-';
    }
}