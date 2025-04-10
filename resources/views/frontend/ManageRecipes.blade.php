@extends('layouts.app')

@section('title', 'Manage Recipes')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-xl-10 col-lg-11">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0 text-white">Manage Recipes</h5>
            </div>
            <div class="card-body">
                <form id="manageRecipesForm" method="POST" action=" ">
                    @csrf
                    <!-- Recipe Info Section -->
        

                    <!-- Total Sold Section -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Total Sold</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="soldPieces" class="form-label">Sold (Pieces)</label>
                                    <input type="number" class="form-control" id="soldPieces" name="sold_pieces" placeholder="Enter sold pieces" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="soldKg" class="form-label">Sold (Kg)</label>
                                    <input type="number" class="form-control" id="soldKg" name="sold_kg" placeholder="Enter sold in Kg" step="0.01" required>
                                </div>


                                <div class="col-md-6">
                                    <label for="soldKg" class="form-label">TotalSold (Kg)</label>
                                    <input type="number" class="form-control" id="soldKg" name="total sold_kg" placeholder="Total sold in Kg" step="0.01" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Waste Section -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Waste</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="wastePieces" class="form-label">Waste (Pieces)</label>
                                    <input type="number" class="form-control" id="wastePieces" name="waste_pieces" placeholder="Enter waste pieces" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="wasteKg" class="form-label">Waste (Kg)</label>
                                    <input type="number" class="form-control" id="wasteKg" name="waste_kg" placeholder="Enter waste in Kg" step="0.01" required>
                                </div>


                                <div class="col-md-6">
                                    <label for="soldKg" class="form-label">Total wasteKg (Kg)</label>
                                    <input type="number" class="form-control" id="wasteKg" name="total wasteKg" placeholder="Total waste in Kg" step="0.01" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reuse Total (Calculated) -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="reuseTotalKg" class="form-label">Reuse Total (Kg)</label>
                            <input type="number" class="form-control" id="reuseTotalKg" name="reuse_total_kg" placeholder="Calculated reuse total" readonly>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-info px-4">Submit</button>
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
    const displayQuantity = document.getElementById("displayQuantity");
    const pieceWeight = document.getElementById("pieceWeight");
    const soldKg = document.getElementById("soldKg");
    const wasteKg = document.getElementById("wasteKg");
    const reuseTotalKg = document.getElementById("reuseTotalKg");

    function calculateReuseTotal() {
        // Calculate total available in Kg: Display Quantity × (Piece Weight in grams ÷ 1000)
        const totalAvailableKg = (parseFloat(displayQuantity.value) || 0) * ((parseFloat(pieceWeight.value) || 0) / 1000);
        const soldTotalKg = parseFloat(soldKg.value) || 0;
        const wasteTotalKg = parseFloat(wasteKg.value) || 0;
        // Reuse = total available – (sold + waste)
        const reuse = totalAvailableKg - (soldTotalKg + wasteTotalKg);
        reuseTotalKg.value = reuse.toFixed(2);
    }

    displayQuantity.addEventListener("input", calculateReuseTotal);
    pieceWeight.addEventListener("input", calculateReuseTotal);
    soldKg.addEventListener("input", calculateReuseTotal);
    wasteKg.addEventListener("input", calculateReuseTotal);
});
</script>
@endsection
