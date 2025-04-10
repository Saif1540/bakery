<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\BakeryRecipeController;
use App\Http\Controllers\ShowcaseController;

Route::get('/', function () {
    return view('Auth.register');
})->name('register');


Route::get('/login', function () {
    return view('Auth.login');
})->name('login');


 

Route::get('/add-ingredient', [IngredientController::class, 'create'])->name('ingredient.create');
Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');



Route::get('/add-recipe', [BakeryRecipeController::class, 'create'])->name('recipes.create');
Route::post('/add-recipse', [BakeryRecipeController::class, 'store'])->name('recipes.store');

Route::post('/recipes/calculate-cost', [BakeryRecipeController::class, 'calculateCost'])->name('recipes.calculateCost');


Route::get('/add-showcase', [ShowcaseController::class, 'create'])->name('showcase.create');

// Route to process the showcase form submission.
Route::post('/showcase', [ShowcaseController::class, 'store'])->name('showcase.store');





Route::get('/viewshowcases', [ShowcaseController::class, 'index'])->name('viewshowcases');


Route::get('/showcases/manage/{id}', [ShowcaseController::class, 'manage'])->name('showcase.manage');
Route::delete('/showcases/delete/{id}', [ShowcaseController::class, 'destroy'])->name('showcase.delete');
