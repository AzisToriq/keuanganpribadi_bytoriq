<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama (pastikan sudah ada user sebelumnya)
        $user = User::first();

        // Kalau belum ada user, kasih warning
        if (!$user) {
            $this->command->warn('No users found. Please run UserSeeder or create a user first.');
            return;
        }

        $defaultCategories = [
            'Makanan & Minuman',
            'Transportasi',
            'Tagihan & Utilitas',
            'Hiburan',
            'Gaji',
            'Investasi',
            'Kesehatan',
            'Belanja',
            'Pendidikan'
        ];

        foreach ($defaultCategories as $name) {
            Category::firstOrCreate([
                'name' => $name,
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('Default categories seeded for user: ' . $user->email);
    }
}
