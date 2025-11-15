<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tables = [
            'personal_letters',
            'personal_letters_dinas',
            'personal_letters_keterangan',
            'personal_letters_perintah',
            'personal_letter_kuasa',
            'personal_letters_undangan',
            'personal_letters_panggilan',
            'personal_letters_memo',
            'personal_letters_pengumuman',
            'personal_letters_notulen',
            'personal_letters_berita_acara',
            'personal_letters_disposisi',
            'personal_letters_keputusan',
            'personal_letters_spo',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'user_id')) {
                    $table->foreignId('user_id')
                        ->nullable()
                        ->after('id')
                        ->constrained()
                        ->onDelete('cascade');
                }
            });
        }
    }

    public function down()
    {
        $tables = [
            'personal_letters',
            'personal_letters_dinas',
            'personal_letters_keterangan',
            'personal_letters_perintah',
            'personal_letter_kuasa',
            'personal_letters_undangan',
            'personal_letters_panggilan',
            'personal_letters_memo',
            'personal_letters_pengumuman',
            'personal_letters_notulen',
            'personal_letters_berita_acara',
            'personal_letters_disposisi',
            'personal_letters_keputusan',
            'personal_letters_spo',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'user_id')) {
                    $table->dropForeign([$tableName . '_user_id_foreign']);
                    $table->dropColumn('user_id');
                }
            });
        }
    }
};
