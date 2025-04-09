<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showcase;
use App\Models\Recipe;

class ShowcaseController extends Controller
{
    /**
     * Display the form to create a new showcase.
     */
    public function create()
    {
        // Fetch recipes to display in the select options.
        $recipes = Recipe::all();
        return view('frontend.RecipeShowcase', compact('recipes'));
    }

    /**
     * Store new showcase records — one per recipe entry.
     */
    public function store(Request $request)
    {
        // Validate incoming data.
        $data = $request->validate([
            'showcase_date'          => 'required|date',
            'items'                  => 'required|array',
            'items.*.recipe_id'      => 'required|exists:recipes,id',
            'items.*.quantity'       => 'required|numeric',
            'items.*.potential_cost' => 'required|numeric', // This field will be recalculated.
        ]);

        // Loop through each submitted item and create a Showcase record.
        foreach ($data['items'] as $item) {
            $recipe = Recipe::find($item['recipe_id']);
            if ($recipe) {
                // Convert recipe weight (in grams) to kilograms.
                $weightInKg = $recipe->recipe_weight / 1000;
                // Calculate unit cost: (weight in kg) × selling_price_per_kg.
                $singleRecipeCost = $weightInKg * $recipe->selling_price_per_kg;
                // Calculate potential cost: unit_cost × quantity.
                $calculatedCost = $singleRecipeCost * $item['quantity'];

                // Use round() to round values to 2 decimals.
                $unitCost = round($singleRecipeCost, 2);
                $potentialCost = round($calculatedCost, 2);

                Showcase::create([
                    'showcase_date'   => $data['showcase_date'],
                    'recipe_name'     => $recipe->recipe_name,
                    'quantity'        => $item['quantity'],
                    'potential_cost'  => $potentialCost,
                ]);
            }
        }

        return redirect()->route('showcase.create')->with('success', 'Showcase created successfully!');
    }
}
