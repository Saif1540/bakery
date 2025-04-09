@extends('layouts.app')

@section('title', 'Create Showcase')

@section('content')
<div class="row justify-content-center py-4">
  <div class="col-xl-10 col-lg-11">
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white">
         <h5 class="card-title mb-0 text-white">Create Showcase</h5>
      </div>
      <div class="card-body">
         <form id="showcaseForm" method="POST" action="{{ route('showcase.store') }}">
             @csrf

             <!-- Showcase Info -->
             <div class="mb-3">
                <label class="form-label">Showcase Date</label>
                <input type="date" name="showcase_date" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
             </div>

             <!-- Recipe Entries Container -->
             <div id="recipesContainer">
                <div class="row g-3 mb-3 recipe-row">
                  <div class="col-md-5">
                     <label class="form-label">Recipe</label>
                     <select class="form-select recipe-select" name="items[0][recipe_id]" required>
                        <option value="">Select Recipe</option>
                        @foreach ($recipes as $recipe)
                          <option value="{{ $recipe->id }}"
                                  data-weight="{{ $recipe->recipe_weight }}"
                                  data-price="{{ $recipe->selling_price_per_kg }}">
                             {{ $recipe->recipe_name }} (Weight: {{ $recipe->recipe_weight }} grams, Price: ${{ $recipe->selling_price_per_kg }}/kg)
                          </option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">Quantity</label>
                     <div class="input-group">
                        <input type="number" class="form-control quantity" name="items[0][quantity]" min="1" value="1" required>
                        <span class="input-group-text">unit(s)</span>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">Potential Cost</label>
                     <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control item-cost" name="items[0][potential_cost]" readonly value="0.00">
                     </div>
                  </div>
                  <div class="col-md-1 d-flex align-items-end">
                     <button type="button" class="btn btn-outline-danger remove-btn"><i class="bi bi-trash"></i></button>
                  </div>
                </div>
             </div>

             <!-- Add More Recipe Button -->
             <div class="mb-3 text-center">
                <button type="button" id="addRowBtn" class="btn btn-success btn-lg rounded-pill shadow">
                    <i class="bi bi-plus-circle-fill me-2"></i> Add More Recipe
                </button>
             </div>

             <!-- Total Cost Display (for visual feedback only) -->
             <div class="text-end mb-3">
                <strong>Total Potential Cost: </strong>
                <span id="totalCost">$0.00</span>
             </div>
             
             <!-- Submit Button -->
             <div class="text-end">
                <button type="submit" class="btn btn-info px-4">Submit Showcase</button>
             </div>
         </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
  const recipesContainer = document.getElementById("recipesContainer");
  const addRowBtn = document.getElementById("addRowBtn");
  const totalCostDisplay = document.getElementById("totalCost");

  // Function to calculate potential cost for a given row.
  function calculateRowCost(row) {
    const recipeSelect = row.querySelector('.recipe-select');
    const quantityInput = row.querySelector('.quantity');
    const costInput = row.querySelector('.item-cost');

    const selectedOption = recipeSelect.options[recipeSelect.selectedIndex];
    if (!selectedOption || selectedOption.value === "") {
      costInput.value = "0.00";
      return;
    }

    // Convert weight (in grams) to kilograms.
    const weightGrams = parseFloat(selectedOption.getAttribute("data-weight")) || 0;
    const weightKg = weightGrams / 1000;
    const price = parseFloat(selectedOption.getAttribute("data-price")) || 0;
    const quantity = parseFloat(quantityInput.value) || 0;
    const cost = weightKg * price * quantity;
    costInput.value = cost.toFixed(2);
  }

  // Update overall total cost for visual feedback.
  function updateTotalCost() {
    let total = 0;
    const costInputs = recipesContainer.querySelectorAll('.item-cost');
    costInputs.forEach(input => {
      total += parseFloat(input.value) || 0;
    });
    totalCostDisplay.textContent = "$" + total.toFixed(2);
  }

  // Attach event listeners for dynamic recalculation.
  recipesContainer.addEventListener("input", function(e) {
    const row = e.target.closest('.recipe-row');
    if (row && (e.target.classList.contains("recipe-select") || e.target.classList.contains("quantity"))) {
      calculateRowCost(row);
      updateTotalCost();
    }
  });

  // Clone and append a new recipe row.
  addRowBtn.addEventListener("click", function() {
    const firstRow = recipesContainer.querySelector('.recipe-row');
    const newRow = firstRow.cloneNode(true);
    
    // Update index in name attributes.
    const rowCount = recipesContainer.querySelectorAll('.recipe-row').length;
    newRow.querySelector('.recipe-select').setAttribute('name', `items[${rowCount}][recipe_id]`);
    newRow.querySelector('.quantity').setAttribute('name', `items[${rowCount}][quantity]`);
    newRow.querySelector('.item-cost').setAttribute('name', `items[${rowCount}][potential_cost]`);
    
    // Reset new row values.
    newRow.querySelector('.recipe-select').selectedIndex = 0;
    newRow.querySelector('.quantity').value = 1;
    newRow.querySelector('.item-cost').value = "0.00";

    recipesContainer.appendChild(newRow);
  });

  // Remove a recipe row when clicking its remove button.
  recipesContainer.addEventListener("click", function(e) {
    if (e.target.closest('.remove-btn')) {
      const rows = recipesContainer.querySelectorAll('.recipe-row');
      if (rows.length > 1) { // Ensure at least one row remains.
        e.target.closest('.recipe-row').remove();
        updateTotalCost();
      }
    }
  });
});
</script>
@endsection
