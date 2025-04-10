<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageRecipesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('manage_recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id'); // to reference the recipe being managed
            $table->integer('display_quantity');       // pieces on display
            $table->integer('sold_pieces');            // sold pieces (user input)
            $table->decimal('sold_kg', 10, 2);           // sold weight (Kg) directly entered
            $table->decimal('total_sold_kg', 10, 2);     // calculated sold weight (Kg)
            $table->integer('waste_pieces');            // waste pieces (user input)
            $table->decimal('waste_kg', 10, 2);          // waste weight (Kg) entered directly
            $table->decimal('total_waste_kg', 10, 2);      // calculated waste weight (Kg)
            $table->decimal('reuse_total_kg', 10, 2);      // calculated reuse total (Kg)
            $table->timestamps();
            
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('manage_recipes');
    }
}
