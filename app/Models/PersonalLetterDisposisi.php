<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterDisposisi extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_disposisi';

protected $fillable = [
    'user_id',
    'kop_type',
    'logo',
    'nomor_ld',
    'tanggal_dokumen',
    'no_revisi',
    'tanggal_pembuatan',
    'nomor_membaca',
    'tanggal_membaca',
    'perihal',
    'paraf',
    'diteruskan_kepada',
    'tanggal_diserahkan',
    'tanggal_kembali',
    'catatan_1',
    'catatan_2',
    'generated_file',
];


    protected $casts = [
        'diteruskan_kepada' => 'array',
        'tanggal_dokumen' => 'date',
        'tanggal_pembuatan' => 'date',
        'tanggal_membaca' => 'date',
        'tanggal_diserahkan' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function generateNomorMembaca()
    {
        $bulan = date('m', strtotime($this->tanggal_pembuatan ?? now()));
        $tahun = date('Y', strtotime($this->tanggal_pembuatan ?? now()));
        $this->nomor_membaca = "LD/{$this->nomor_ld}/{$bulan}/{$tahun}";
    }
}