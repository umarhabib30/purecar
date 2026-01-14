@extends('layout.superAdminDashboard')

@section('body')
<div class="container py-4">
    <h1 class="h4 mb-4">Business details</h1>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Business Name</th>
                        <td>{{ $business->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Business Type</th>
                        <td>{{ $business->businessType->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Business Location</th>
                        <td>{{ $business->businessLocation->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Contact No</th>
                        <td>{{ $business->contact_no }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{ $business->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Address</th>
                        <td>{{ $business->address }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Website</th>
                        <td>
                            @if($business->website)
                                <a href="{{ $business->website }}" class="text-primary" target="_blank">{{ $business->website }}</a>
                            @else
                                Not provided
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ $business->is_approved ? 'Approved' : 'Pending' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{ $business->description ?? 'Not provided' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <h5>Images</h5>
                @if($business->images->isNotEmpty())
                    <div class="row">
                        @foreach($business->images as $image)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <img src="{{ asset($image->image_path) }}" alt="Business Image" class="img-fluid rounded shadow-sm" style="height: 200px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No images uploaded.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('list-businesses.index') }}" class="btn btn-secondary">Back to Listings</a>
    </div>
</div>
@endsection
