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

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
                    ->withPivot('quantity_in_grams', 'calculated_cost')
                    ->withTimestamps();
    }
}
