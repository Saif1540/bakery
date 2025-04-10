@extends('layouts.app')


@section('title')
  view all showcase recipes
@endsection
@section('content')
<div class="container">
    <h2 class="mb-4">All Recipes Showcase</h2>
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
              <th scope="col">Potential Cost</th>
              <th scope="col">Action</th>
              <th scope="col">Action</th>
          </tr>
      </thead>
      <tbody>
          @foreach($showcases as $index => $showcase)
          <tr>
              <td>
                  <div class="form-check d-flex align-items-center">
                      <input class="form-check-input" type="checkbox" id="record{{ $showcase->id }}">
                      <label class="form-check-label" for="record{{ $showcase->id }}">{{ $index + 1 }}</label>
                  </div>
              </td>
              <td>{{ $showcase->showcase_date }}</td>
              <td>{{ $showcase->recipe_name }}</td>
              <td>{{ $showcase->quantity }}</td>
              <td>${{ number_format($showcase->potential_cost, 2) }}</td>
              <td>
                  <a href="{{ route('showcase.manage', $showcase->id) }}" class="btn btn-sm btn-outline-info" title="Manage">
                      <i class="bi bi-gear">Manage</i>
                  </a>
              </td>
              <td>
                <form action="{{ route('showcase.delete', $showcase->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                      <i class="bi bi-trash">Delete</i>
                  </button>
              </form>
              
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
  
</div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        let table = new DataTable('#dataTable');
    </script>
@endsection
