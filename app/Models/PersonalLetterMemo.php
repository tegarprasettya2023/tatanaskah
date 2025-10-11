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
        'template_type',
        'kop_type',
        'nomor',
        'nomor_urut',
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
        'tembusan_1',
        'tembusan_2',
        'generated_file',
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];

    public function getFormattedLetterDateAttribute()
    {
        return $this->letter_date ? Carbon::parse($this->letter_date)->translatedFormat('d F Y') : null;
    }

    // Generate nomor auto (IM/001/01/2025)
    public static function generateNomor($letterDate)
    {
        $date = Carbon::parse($letterDate);
        $bulan = $date->format('m');
        $tahun = $date->format('Y');
        
        // Cari nomor urut terakhir di bulan dan tahun yang sama
        $lastLetter = self::whereYear('letter_date', $tahun)
                          ->whereMonth('letter_date', $bulan)
                          ->orderBy('nomor_urut', 'desc')
                          ->first();
        
        $nomorUrut = $lastLetter ? $lastLetter->nomor_urut + 1 : 1;
        
        // Format: IM/001/01/2025
        $nomor = sprintf('IM/%03d/%s/%s', $nomorUrut, $bulan, $tahun);
        
        return [
            'nomor' => $nomor,
            'nomor_urut' => $nomorUrut
        ];
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