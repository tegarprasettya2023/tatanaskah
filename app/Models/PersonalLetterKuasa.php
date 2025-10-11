<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalLetterKuasa extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_kuasa';

    protected $fillable = [
        'kop_type','nomor','letter_date','tempat',
        'nama_pemberi','nip_pemberi','jabatan_pemberi','alamat_pemberi',
        'nama_penerima','nip_penerima','jabatan_penerima','alamat_penerima',
        'isi'
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];

    public function getFormattedLetterDateAttribute()
    {
        return $this->letter_date ? Carbon::parse($this->letter_date)->translatedFormat('d F Y') : null;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nomor', 'like', "%{$search}%")
              ->orWhere('nama_pemberi', 'like', "%{$search}%")
              ->orWhere('nama_penerima', 'like', "%{$search}%");
        });
    }
}
