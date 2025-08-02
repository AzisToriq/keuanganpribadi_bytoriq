<?php

namespace App\Listeners;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class CreateDefaultCategories
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $defaultCategories = [
            'Makanan & Minuman',
            'Transportasi',
            'Tagihan & Utilitas',
            'Hiburan',
            'Gaji',
            'Investasi',
            'Kesehatan',
            'Belanja',
            'Pendidikan',
        ];

        foreach ($defaultCategories as $name) {
            Category::firstOrCreate([
                'name' => $name,
                'user_id' => $user->id,
            ]);
        }
    }
}
