<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterPerintah extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_perintah';

    protected $fillable = [
        'user_id',
        'template_type',
        'kop_type',
        'nomor',
        'letter_date',
        'tempat',
        'menimbang', // sekarang array
        'dasar', // sekarang array
        'nama_penerima',
        'nik_penerima',
        'jabatan_penerima',
        'nama_nama_terlampir',
        'untuk', // sekarang array
        'tembusan', // sekarang array
        'jabatan_pembuat',
        'nama_pembuat',
        'nik_pembuat',
        'lampiran',
        'generated_file',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'menimbang' => 'array',
        'dasar' => 'array',
        'untuk' => 'array',
        'tembusan' => 'array',
        'lampiran' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getFormattedLetterDateAttribute()
    {
        return $this->letter_date ? Carbon::parse($this->letter_date)->translatedFormat('d F Y') : null;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nomor', 'like', "%{$search}%")
              ->orWhere('nama_penerima', 'like', "%{$search}%")
              ->orWhere('nama_pembuat', 'like', "%{$search}%");
        });
    }
}