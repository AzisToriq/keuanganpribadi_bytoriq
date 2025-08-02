<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use App\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // Relasi: Satu kategori memiliki banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi: Kategori milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
