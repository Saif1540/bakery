@extends('layouts.app')

@section('title')
    Add Ingradients
@endsection


@section('links')
@endsection



@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add Ingredient</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ingredients.store') }}" method="POST" class="row gy-3 needs-validation"
                        novalidate>
                        @csrf

                        <div class="col-md-6">
                            <label class="form-label">Ingredient Name</label>
                            <input type="text" name="ingredient_name" class="form-control"
                                placeholder="Enter ingredient name" required>
                            <div class="invalid-feedback">
                                Please provide ingredient name.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cost/Price per kg</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price_per_kg" class="form-control" placeholder="0.00"
                                    step="0.01" required>
                                <span class="input-group-text">per kg</span>
                                <div class="invalid-feedback">
                                    Please provide valid price.
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary-600" type="submit">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endsection
