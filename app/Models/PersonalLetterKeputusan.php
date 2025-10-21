<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLetterKeputusan extends Model
{
    use HasFactory;

    protected $table = 'personal_letter_surat_keputusan';

    protected $fillable = [
        'user_id',
        'kop_type',
        'judul_setelah_sk',
        'nomor_sk',
        'tanggal_sk',
        'tentang',
        'jabatan_pembuat',
        'menimbang',
        'mengingat',
        'menetapkan',
        'keputusan',
        'ditetapkan_di',
        'tanggal_ditetapkan',
        'nama_jabatan',
        'nama_lengkap',
        'nik_kepegawaian',
        'keputusan_dari',
        'lampiran_tentang',
        'tembusan',
        'generated_file',
    ];

    protected $casts = [
        'menimbang' => 'array',
        'mengingat' => 'array',
        'keputusan' => 'array',
        'tembusan' => 'array',
        'tanggal_sk' => 'date',
        'tanggal_ditetapkan' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function generateNomorSK()
{
    // Kalau nomor_sk sudah ada di database, pakai itu
    if (!empty($this->nomor_sk)) {
        return $this->nomor_sk;
    }

    // Kalau belum ada, buat format otomatis: SK/{ID}/LAB/{BULAN_ROMAWI}/{TAHUN}
    $bulanRomawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    $bulan = $this->tanggal_sk ? $bulanRomawi[$this->tanggal_sk->format('n')] : $bulanRomawi[now()->format('n')];
    $tahun = $this->tanggal_sk ? $this->tanggal_sk->format('Y') : now()->format('Y');

    return sprintf('SK/%03d/LAB/%s/%s', $this->id ?? 0, $bulan, $tahun);
}

    public function getFormattedTanggalSK()
    {
        // Format tanggal seperti: 17 Oktober 2025
        return $this->tanggal_sk ? $this->tanggal_sk->translatedFormat('d F Y') : '........................................';
    }
}
