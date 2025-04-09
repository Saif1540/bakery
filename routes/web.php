<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\BakeryRecipeController;

Route::get('/', function () {
    return view('Auth.register');
})->name('register');


Route::get('/login', function () {
    return view('Auth.login');
})->name('login');


Route::get('/app', function () {
    return view('layouts.app');
})->name('login');


Route::get('/add', function () {
    return view('frontend.ingredients');
})->name('login');



Route::get('/recipe', function () {
    return view('frontend.addrecipe');
})->name('recipe');

Route::get('/add-ingredient', [IngredientController::class, 'create'])->name('ingredient.create');
Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');



Route::get('/add-recipe', [BakeryRecipeController::class, 'create'])->name('recipes.create');
Route::post('/add-recipse', [BakeryRecipeController::class, 'store'])->name('recipes.store');

Route::post('/recipes/calculate-cost', [BakeryRecipeController::class, 'calculateCost'])->name('recipes.calculateCost');



