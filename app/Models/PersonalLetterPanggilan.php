<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterPanggilan extends Model
{
    use HasFactory;

    protected $table = 'personal_letters_panggilan';

    protected $fillable = [
        'template_type',
        'kop_type',
        'nomor',
        'letter_date',
        'sifat',
        'lampiran',
        'perihal',
        'kepada',
        'isi_pembuka',
        'hari_tanggal',
        'waktu',
        'tempat',
        'menghadap',
        'alamat_pemanggil',
        'jabatan',
        'nama_pejabat',
        'nik',
        'tembusan_1',
        'tembusan_2',
        'generated_file',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'hari_tanggal' => 'date',
    ];
}
