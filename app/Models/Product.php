<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Membuat Has Factories
    use HasFactory;
    /**
    * fillable
    *
    * @var array
    */
    // membuat properti $fillable digunakan untuk menentukan field/kolom mana saja yang boleh diisi
    protected $fillable = [
        'image',
        'title',
        'description',
        'price',
        'stock'
    ];
}
