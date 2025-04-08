<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient_name', 'price_per_kg'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)
                    ->withPivot('quantity_in_grams', 'calculated_cost')
                    ->withTimestamps();
    }
}
