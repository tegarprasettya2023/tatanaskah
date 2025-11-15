<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterUndangan extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_undangan';

    protected $fillable = [
        'user_id', // ← Tambahkan
        'template_type',
        'kop_type',
        'nomor',
        'sifat',
        'lampiran',
        'perihal',
        'yth_nama',
        'yth_alamat',
        'isi_pembuka',
        'hari_tanggal',
        'pukul',
        'tempat_acara',   
        'acara',
        'tempat_ttd',
        'tanggal_ttd',     
        'jabatan_pembuat',
        'nama_pembuat',
        'tembusan_1',
        'tembusan_2',
        'daftar_undangan',
        'generated_file',
    ];

    protected $casts = [
        'hari_tanggal' => 'date',
        'tanggal_ttd' => 'date',
        'daftar_undangan' => 'array',
    ];

    // ← Tambahkan relasi
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getFormattedLetterDateAttribute()
    {
        return $this->tanggal_ttd ? Carbon::parse($this->tanggal_ttd)->translatedFormat('d F Y') : null;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nomor', 'like', "%{$search}%")
              ->orWhere('perihal', 'like', "%{$search}%")
              ->orWhere('yth_nama', 'like', "%{$search}%");
        });
    }
}