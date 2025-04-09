@extends('layouts.app')

@section('title')
    Add recipe
@endsection


@section('links')
@endsection



@section('content')
    <div class="row justify-content-center py-4">
        <div class="col-xl-10 col-lg-11">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0 text-white">Add Recipe</h5>
                </div>
                <div class="card-body">
                    <form id="ingredientForm" class="p-2" method="POST" action="{{ route('recipes.store') }}">
                        @csrf
                    
                        <!-- Recipe Info -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Recipe Name</label>
                                <input type="text" class="form-control" name="recipe_name" placeholder="Enter recipe name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" placeholder="Enter category">
                            </div>
                        </div>
                    
                        <!-- Ingredients Section -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">Ingredients</h6>
                            </div>
                            <div class="card-body">
                                <div id="ingredientsContainer">
                                    <div class="row g-3 mb-3 align-items-end ingredient-row">
                                        <div class="col-md-5">
                                            <label class="form-label">Ingredient</label>
                                            <select class="form-select ingredient-select" name="ingredients[0][id]">
                                                <option value="">Select ingredient</option>
                                                @foreach ($ingredients as $ingredient)
                                                    <option value="{{ $ingredient->id }}"
                                                        data-cost="{{ $ingredient->price_per_kg }}">
                                                        {{ $ingredient->ingredient_name }} (${{ $ingredient->price_per_kg }}/kg)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Quantity</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control quantity" name="ingredients[0][quantity]" min="0" step="1" value="0">
                                                <span class="input-group-text">grams</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Cost</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control item-cost" readonly value="0.00">
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-outline-danger remove-btn">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm mt-2" id="addIngredientBtn">
                                    <i class="bi bi-plus-circle"></i> Add Another Ingredient
                                </button>
                            </div>
                            <div class="text-end mt-3">
                                <strong>Total Ingredient Cost: </strong>
                                <span id="totalCost">$0.00</span>
                            </div>
                        </div>
                    
                        <!-- Pricing Section -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">Pricing Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Selling Price per kg</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="selling_price_per_kg" id="sellingPricePerKg" step="0.01" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Labour Time</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="labour_time" id="labourTime" min="0">
                                            <span class="input-group-text">minutes</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <label class="form-label">Recipe Weight per kg</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="recipe_weight" class="form-control" id="Weightperrecipe" >
                                    </div>
                                    </div>


                                    

                                   

                                    <div class="col-md-6">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" id="weightToggle">
                                            <label class="form-check-label" for="weightToggle">
                                           Sell by piece?
                                            </label>
                                        </div>
                                        <div class="mt-3 d-none" id="weightInputContainer">
                                            <label class="form-label">Weight per piece (grams)</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="weight_per_piece" id="pieceWeight" placeholder="e.g. 120">
                                                <span class="input-group-text">g</span>
                                            </div>


                                            <label class="form-label mt-2">Selling Price per Piece</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control" id="pricePerPiece" readonly>
                                            </div>




                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-info px-4"> Submit Recipe
                            </button>
                        </div>
                    </form>
                    

                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Script -->
    <script>
        document.getElementById("weightToggle").addEventListener("change", function() {
            document.getElementById("weightInputContainer").classList.toggle("d-none", !this.checked);
        });
    </script>
@endsection




@section('scripts')
<script> 
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("ingredientsContainer");
    let ingredientIndex = document.querySelectorAll('.ingredient-row').length;

    // --- Ingredient cost calculation ---
    function calculateCost(row) {
        const ingredientSelect = row.querySelector(".ingredient-select");
        const quantityInput = row.querySelector(".quantity");
        const costInput = row.querySelector(".item-cost");

        const pricePerKg = parseFloat(ingredientSelect.selectedOptions[0]?.dataset.cost || 0);
        const quantity = parseFloat(quantityInput.value || 0);

        const pricePerGram = pricePerKg / 1000;
        const totalCost = pricePerGram * quantity;

        costInput.value = totalCost.toFixed(2);
        updateTotalCost();
    }

    function updateTotalCost() {
        let total = 0;
        document.querySelectorAll(".item-cost").forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById("totalCost").textContent = "$" + total.toFixed(2);
    }

    // --- Add new ingredient row ---
    document.getElementById("addIngredientBtn").addEventListener("click", function () {
        const firstRow = container.querySelector(".ingredient-row");
        const newRow = firstRow.cloneNode(true);

        // Reset values
        newRow.querySelector(".ingredient-select").selectedIndex = 0;
        newRow.querySelector(".quantity").value = 0;
        newRow.querySelector(".item-cost").value = "0.00";

        // Update name attributes
        newRow.querySelector(".ingredient-select").setAttribute("name", `ingredients[${ingredientIndex}][id]`);
        newRow.querySelector(".quantity").setAttribute("name", `ingredients[${ingredientIndex}][quantity]`);
        ingredientIndex++;

        container.appendChild(newRow);

        // Update total cost after adding new ingredient
        updateTotalCost();
    });

    // --- Remove ingredient row ---
    container.addEventListener("click", function (e) {
        if (e.target.closest(".remove-btn")) {
            const rows = container.querySelectorAll(".ingredient-row");
            if (rows.length > 1) {
                e.target.closest(".ingredient-row").remove();
                updateTotalCost();
            }
        }
    });

    // --- Recalculate cost on ingredient or quantity change ---
    container.addEventListener("input", function (e) {
        const row = e.target.closest(".ingredient-row");
        if (row && (e.target.classList.contains("ingredient-select") || e.target.classList.contains("quantity"))) {
            calculateCost(row);
        }
    });

    // --- Toggle weight per piece section ---
    document.getElementById("weightToggle").addEventListener("change", function () {
        const weightInputContainer = document.getElementById("weightInputContainer");
        if (this.checked) {
            weightInputContainer.classList.remove("d-none");
        } else {
            weightInputContainer.classList.add("d-none");
            document.getElementById("pricePerPiece").value = '';
        }
    });

    // --- Calculate price per piece based on weight and price per kg ---
    function calculatePiecePrice() {
        const weight = parseFloat(document.getElementById("pieceWeight").value || 0);
        const pricePerKg = parseFloat(document.getElementById("sellingPricePerKg").value || 0);
        const pricePerGram = pricePerKg / 1000;
        const piecePrice = weight * pricePerGram;
        document.getElementById("pricePerPiece").value = piecePrice.toFixed(2);
    }

    document.getElementById("pieceWeight").addEventListener("input", calculatePiecePrice);
    document.getElementById("sellingPricePerKg").addEventListener("input", calculatePiecePrice);
});

</script>

@endsection
