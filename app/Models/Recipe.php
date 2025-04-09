<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_name',
        'category',
        'selling_price_per_kg',
        'labour_time',
        'weight_per_piece',
        'ingredients',
    ];

    protected $casts = [
        'ingredients' => 'array',
    ];
}
