@extends('layout.superAdminDashboard')

@section('body')
<div class="container py-5">
    <h1 class="mb-4 h4">Edit Business</h1>

    <form action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Business Name</label>
                <input type="text" name="name" value="{{ $business->name }}" class="form-control" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Business Type</label>
                <select name="business_type_id" class="form-select" required>
                    @foreach($businessTypes as $type)
                        <option value="{{ $type->id }}" {{ $business->business_type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('business_type_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Business Location</label>
                <select name="business_location_id" class="form-select" required>
                @foreach($businessLocations as $location)
                <option value="{{ $location->id }}" {{ $business->business_location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>

                    @endforeach
                </select>
                @error('business_location_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact No</label>
                <input type="text" name="contact_no" value="{{ $business->contact_no }}" class="form-control" >
                @error('contact_no')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $business->email }}" class="form-control" >
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Address</label>
                <input type="text" name="address" value="{{ $business->address }}" class="form-control" >
                @error('address')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Website</label>
                <input type="url" name="website" value="{{ $business->website }}" class="form-control">
                @error('website')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $business->description }}</textarea>
                @error('description')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Current Images</label>
                @if($business->images->isNotEmpty())
                    <div class="d-flex flex-wrap gap-3 mt-2">
                        @foreach($business->images as $image)
                            <div class="position-relative">
                                <img src="{{ asset($image->image_path) }}" alt="Business Image" class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
                                <a href="{{ route('business.image.delete', $image->id) }}" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="return confirm('Are you sure you want to delete this image?')">×</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No images uploaded yet.</p>
                @endif
            </div>

            <div class="col-12">
                <label class="form-label">Upload New Images</label>
                <input type="file" name="images[]" class="form-control" multiple>
                @error('images.*')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection
