<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Mass Assignment
     * Pastikan 'kategori_id' masuk di sini agar bisa disimpan lewat Controller.
     */
    protected $fillable = [
        'name', 
        'quantity', 
        'price', 
        'user_id', 
        'kategori_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Category.
     * Menggunakan 'kategori_id' sesuai dengan nama kolom di tabel products kamu.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}