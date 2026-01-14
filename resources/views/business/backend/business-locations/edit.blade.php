@extends('layout.superAdminDashboard')

@section('body')
    <div class="container py-5">
        <h1 class="h4 mb-4">Edit Business Location</h1>
        <form action="{{ route('business-location.update', $business_location->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ $business_location->name }}" class="form-control" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
