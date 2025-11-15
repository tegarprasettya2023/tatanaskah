<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterKeterangan extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_keterangan';

    protected $fillable = [
         'user_id',
        'template_type',
        'kop_type',
        'nomor',
        'letter_date',
        'tempat',
        'nama_yang_menerangkan',
        'nik_yang_menerangkan',
        'jabatan_yang_menerangkan',
        'nama_yang_diterangkan',
        'nip_yang_diterangkan',
        'jabatan_yang_diterangkan',
        'isi_keterangan',
        'jabatan_pembuat',
        'nama_pembuat',
        'nik_pembuat',
        'generated_file',
    ];

    protected $casts = [
        'letter_date' => 'date',
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
              ->orWhere('nama_yang_diterangkan', 'like', "%{$search}%")
              ->orWhere('nama_yang_menerangkan', 'like', "%{$search}%");
        });
    }
}