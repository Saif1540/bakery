<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageRecipe extends Model
{
    // Specify the table name if it does not follow the naming conventions
    protected $table = 'recipes';

    // Define fillable fields
    protected $fillable = [
        'display_quantity', 
        'sold_pieces', 
        'sold_kg', 
        'total_sold_kg', 
        'waste_pieces', 
        'waste_kg', 
        'total_waste_kg', 
        'reuse_total_kg',
        'piece_weight',    // weight per piece stored in grams
        'recipe_weight',   // total recipe weight in kg
    ];
}
