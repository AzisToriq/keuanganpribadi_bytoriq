<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;

class Transaction extends Model
{
    // Kolom-kolom yang boleh diisi
    protected $fillable = [
        'title',
        'amount',
        'type',
        'category_id',
        'date',
        'user_id',
        'receipt', // ← penting untuk menyimpan path file bukti
    ];

    // Otomatis casting 'date' ke instance Carbon
    protected $casts = [
        'date' => 'date',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke user (setiap transaksi milik satu user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
