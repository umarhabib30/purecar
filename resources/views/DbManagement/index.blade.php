@extends('layout.superAdminDashboard')
@section('body')
<h2>DB Management</h2>

<form method="GET" class="mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label for="make" class="form-label">Make</label>
            <input type="text" name="make" id="make" class="form-control" placeholder="Make" value="{{ request('make') }}">
        </div>
        <div class="col-md-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" placeholder="Model" value="{{ request('model') }}">
        </div>
        <div class="col-md-3">
            <label for="variant" class="form-label">Variant</label>
            <input type="text" name="variant" id="variant" class="form-control" placeholder="Variant" value="{{ request('variant') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </div>
</form>


@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>Car ID</th>
            <th>Advert ID</th>
            <th>Make</th>
            <th>Model</th>
            <th>Variant</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cars as $car)
        <tr>
            <td>{{ $car->car_id }}</td>
            <td>{{ $car->advert_id }}</td>
            <td>{{ $car->make }}</td>
            <td>{{ $car->model }}</td>
            <td>{{ $car->variant }}</td>
            <td>
                <a href="{{ route('admin.car.edit', $car->car_id) }}" class="btn btn-sm btn-warning">Edit</a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

@endsection
