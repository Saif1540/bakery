@extends('layouts.app')

@section('title', 'View All Recipes')

@section('content')
<table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
  <thead>
    <tr>
      <th scope="col">
        <div class="form-check d-flex align-items-center">
          <input class="form-check-input" type="checkbox" id="selectAll">
          <label class="form-check-label" for="selectAll">S.L</label>
        </div>
      </th>
      <th scope="col">Showcase Date</th>
      <th scope="col">Recipe Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Unit Cost</th>
      <th scope="col">Potential Cost</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <div class="form-check d-flex align-items-center">
          <input class="form-check-input" type="checkbox" id="record1">
          <label class="form-check-label" for="record1">01</label>
        </div>
      </td>
      <td>2024-01-25</td>
      <td>Chocolate Cake</td>
      <td>8</td>
      <td>$600.00</td>
      <td>$4800.00</td>
      <td>
        <a href="" class="btn btn-sm btn-outline-info" title="Manage">
          <i class="bi bi-gear">Manage</i>
        </a>
        <a href=" " class="btn btn-sm btn-outline-danger" title="Delete">
          <i class="bi bi-trash">Delete</i>
        </a>
      </td>
    </tr>
    <!-- Additional rows would be generated here dynamically -->
  </tbody>
</table>
@endsection

@section('scripts')
    <script src="assets/js/app.js"></script>
    <script>
        let table = new DataTable('#dataTable');
    </script>
@endsection
