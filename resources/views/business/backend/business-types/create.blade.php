@extends('layout.superAdminDashboard')

@section('body')
<div class="container py-5">
    <h1 class="h4 mb-4">Create Business Type</h1>

    <form action="{{ route('business-type.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
