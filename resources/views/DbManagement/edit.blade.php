@extends('layout.superAdminDashboard')
@section('body')
<h2>Edit API details</h2>

<form method="POST" action="{{ route('admin.car.update', $car->car_id) }}" class="container mt-4">
    @csrf
    <div class="row">
        @php
            $fields = [
                'make', 'model', 'variant', 'Trim', 'Range', 'fuel_type', 'transmission_type', 'body_type',
                'engine_size', 'doors', 'seats', 'colors', 'gear_box', 
                'Rpm', 'RigidArtic',  'NumberOfAxles', 'FuelTankCapacity',
                'GrossVehicleWeight',  'Bhp', 'Kph', 'Transmission', 'EngineCapacity',
                'NumberOfCylinders', 'DriveType',
                'ExtraUrban', 'UrbanCold', 'Combined'
            ];
        @endphp

        @foreach($fields as $field)
            <div class="col-md-4 mb-3">
                <label for="{{ $field }}" class="form-label text-capitalize">{{ str_replace('_', ' ', $field) }}</label>
                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $car->$field) }}">
            </div>
        @endforeach
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</form>

@endsection
