<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Config::insert([
            [
                'code' => 'default_password',
                'value' => 'ptgm',
            ],
            [
                'code' => 'page_size',
                'value' => '5',
            ],
            [
                'code' => 'app_name',
                'value' => 'Aplikasi Surat Menyurat',
            ],
            [
                'code' => 'institution_name',
                'value' => 'PTGM',
            ],
            [
                'code' => 'institution_address',
                'value' => 'Jl. Dr. Wahidin Sudirohusodo No.708, Kembangan, Kec. Kebomas, Kabupaten Gresik, Jawa Timur 61161',
            ],
            [
                'code' => 'institution_phone',
                'value' => '085839797927',
            ],
            [
                'code' => 'institution_email',
                'value' => 'admin@gmail.com',
            ],
            [
                'code' => 'language',
                'value' => 'id',
            ],
            [
                'code' => 'pic',
                'value' => 'Annisa Maya',
            ],
        ]);
    }
}
