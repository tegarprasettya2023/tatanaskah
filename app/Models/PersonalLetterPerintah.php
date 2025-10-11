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
    'template_type',
    'kop_type',
    'nomor',
    'letter_date',
    'tempat',
    'menimbang_1',
    'menimbang_2',
    'dasar_a',
    'dasar_b',
    'nama_penerima',
    'nik_penerima',
    'jabatan_penerima',
    'nama_nama_terlampir',
    'untuk_1',
    'untuk_2',
    'tembusan_1',
    'tembusan_2',
    'jabatan_pembuat',
    'nama_pembuat',
    'nik_pembuat',
    'lampiran', // <--- baru
    'generated_file',
];

protected $casts = [
    'letter_date' => 'date',
    'lampiran' => 'array', // <--- agar bisa diakses sebagai array
];


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