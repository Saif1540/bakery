<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('recipe_name');
            $table->string('category');
            $table->decimal('selling_price_per_kg', 10, 2);
            $table->integer('labour_time');
            $table->integer('weight_per_piece')->nullable(); 
            $table->decimal('recipe_weight', 10, 2)->nullable();
            $table->decimal('ingredients_total_cost', 10, 2)->nullable();            
            $table->json('ingredients');
            $table->json('quantity');
            $table->json('cost');
            $table->timestamps();
        });
    }
    
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
