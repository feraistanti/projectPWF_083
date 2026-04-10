<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory; // <-- Tambahkan ini di dalam class

    protected $fillable = ['product_id', 'name'];
}