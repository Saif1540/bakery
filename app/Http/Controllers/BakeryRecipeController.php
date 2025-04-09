<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;

class BakeryRecipeController extends Controller
{



    public function calculateCost(Request $request)
    {
        $ingredient = Ingredient::find($request->ingredient_id);

        if ($ingredient) {
            // Calculate the cost per gram
            $pricePerKg = $ingredient->price_per_kg;
            $quantityInGrams = $request->quantity;
            $pricePerGram = $pricePerKg / 1000;

            // Calculate the total cost
            $totalCost = $pricePerGram * $quantityInGrams;

            // Return the calculated cost as JSON response
            return response()->json(['cost' => number_format($totalCost, 2)]);
        }

        return response()->json(['cost' => 0.00]); // Return 0 if ingredient not found
    }






    public function create()
    {
        $ingredients = \App\Models\Ingredient::all();
        return view('frontend.addrecipe', compact('ingredients'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request, including the new recipe_weight field
        $data = $request->validate([
            'recipe_name'          => 'required|string',
            'category'             => 'required|string',
            'selling_price_per_kg' => 'required|numeric',
            'labour_time'          => 'required|numeric',
            'weight_per_piece'     => 'nullable|numeric',
            'recipe_weight'        => 'nullable|numeric',
            'ingredients'          => 'required|array',
            'ingredients.*.id'     => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric',
        ]);
    
        // Initialize separate arrays for ingredient IDs, quantities, and cost
        $ingredientsArray = [];
        $quantitiesArray  = [];
        $costArray        = [];
    
        // Loop through each ingredient provided from the request
        foreach ($data['ingredients'] as $ingredient) {
            // Retrieve the ingredient model to get its price per kg
            $ingredientModel = \App\Models\Ingredient::find($ingredient['id']);
            $pricePerKg = $ingredientModel->price_per_kg;
            $quantityInGrams = $ingredient['quantity'];
    
            // Calculate cost based on price per kg and given quantity (in grams)
            $cost = ($pricePerKg / 1000) * $quantityInGrams;
    
            // Store the ingredient id directly
            $ingredientsArray[] = $ingredient['id'];
    
            // Store the corresponding quantity
            $quantitiesArray[] = $quantityInGrams;
    
            // Store the calculated cost
            $costArray[] = $cost;
        }
    
        // Calculate the total cost of all ingredients
        $ingredientsTotalCost = array_sum($costArray);
    
        // Create the recipe record.
        // No manual JSON encoding is needed as the model casts these attributes as arrays.
        $recipe = \App\Models\Recipe::create([
            'recipe_name'          => $data['recipe_name'],
            'category'             => $data['category'],
            'selling_price_per_kg' => $data['selling_price_per_kg'],
            'labour_time'          => $data['labour_time'],
            'weight_per_piece'     => $data['weight_per_piece'] ?? null,
            'recipe_weight'        => $data['recipe_weight'] ?? null,
            'ingredients'          => $ingredientsArray,   // Plain array of ingredient IDs
            'quantity'             => $quantitiesArray,    // Array of quantities
            'cost'                 => $costArray,          // Array of individual cost values
        ]);
    
        // Redirect back to the recipe creation page with a success message
        return redirect()->route('recipes.create')->with('success', 'Recipe created successfully!');
    }
    
    

    
    

}
