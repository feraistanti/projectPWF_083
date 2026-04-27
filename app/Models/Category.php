<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'categories'; 

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = ['name'];

    /**
     * Relasi ke model Product.
     * Menggunakan 'kategori_id' karena itu adalah nama kolom foreign key 
     * yang ada di tabel 'products' kamu.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id');
    }
}