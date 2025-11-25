<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterMemo extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_memo';

    protected $fillable = [
        'user_id',
        'template_type',
        'kop_type',
        'nomor',
        'tempat_ttd',
        'letter_date',
        'yth_nama',
        'hal',
        'sehubungan_dengan',
        'alinea_isi',
        'isi_penutup',
        'jabatan_pembuat',
        'nama_pembuat',
        'nik_pembuat',
        'tembusan',
        'generated_file',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'tembusan' => 'array',
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
              ->orWhere('hal', 'like', "%{$search}%")
              ->orWhere('yth_nama', 'like', "%{$search}%");
        });
    }
}