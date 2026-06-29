<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun admin tambahan
        User::create([
            'name' => 'Admin Baru',
            'email' => 'admin2@admin.com',
            'password' => 'password123', // Akan di-hash otomatis oleh model (karena attribute casts)
            'role' => 'admin',
        ]);

        $this->command->info('Akun admin baru berhasil dibuat!');
    }
}
