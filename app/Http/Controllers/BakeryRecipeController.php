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
    // Validate the incoming request
    $data = $request->validate([
        'recipe_name' => 'required|string',
        'category' => 'required|string',
        'selling_price_per_kg' => 'required|numeric',
        'labour_time' => 'required|numeric',
        'weight_per_piece' => 'nullable|numeric',
        'ingredients' => 'required|array',
        'ingredients.*.id' => 'required|exists:ingredients,id',
        'ingredients.*.quantity' => 'required|numeric',
    ]);

    // Prepare the ingredients array with ID, quantity, and cost (if needed)
    $ingredients = collect($data['ingredients'])->map(function ($ingredient) {
        $ingredientData = \App\Models\Ingredient::find($ingredient['id']);
        $pricePerKg = $ingredientData->price_per_kg;
        $quantityInGrams = $ingredient['quantity'];
        $cost = ($pricePerKg / 1000) * $quantityInGrams; // Calculate cost based on price per kg and quantity in grams

        return [
            'id' => $ingredient['id'],
            'quantity' => $ingredient['quantity'],
            'cost' => $cost, // Store the calculated cost for this ingredient
        ];
    });

    // Create the new recipe entry
    $recipe = \App\Models\Recipe::create([
        'recipe_name' => $data['recipe_name'],
        'category' => $data['category'],
        'selling_price_per_kg' => $data['selling_price_per_kg'],
        'labour_time' => $data['labour_time'],
        'weight_per_piece' => $data['weight_per_piece'] ?? null,
        'ingredients' => json_encode($ingredients), // Store ingredients as JSON
    ]);

    // Return to the recipe list page or another page
    return redirect()->route('recipes.create')->with('success', 'Recipe created successfully!');
}

    
    

}
