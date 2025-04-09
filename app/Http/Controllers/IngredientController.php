<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('frontend.addrecipe', compact('ingredients'));
    }

    public function create()
    {
        return view('frontend.ingredients');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredient_name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
        ]);

        Ingredient::create($request->all());

        return redirect()->back()->with('success', 'Ingredient added successfully!');
    }






}

