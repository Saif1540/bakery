<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showcase extends Model
{
    use HasFactory;

    protected $fillable = [
        'showcase_date',
        'recipe_id',
        'quantity',
        'unit_cost',
        'potential_cost',
    ];
}
