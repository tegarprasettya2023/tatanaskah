<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'phone' => '081234567890',
            'password' => Hash::make('adminhrd'),
            'role' => Role::ADMIN->status(),
        ]);

        // direkktur
        // User::create([
        //     'name' => 'Direktur',
        //     'email' => 'direktur@gmail.com',
        //     'phone' => '082345678901',
        //     'password' => Hash::make('ptgm'),
        //     'role' => Role::STAFF->status(),
        // ]);

        // // Staff Pengawas
        // User::create([
        //     'name' => 'Staff Pengawas',
        //     'email' => 'pengawas@gmail.com',
        //     'phone' => '083456789012',
        //     'password' => Hash::make('ptgm'),
        //     'role' => Role::STAFF_PENGAWAS->status(),
        // ]);
    }
}
