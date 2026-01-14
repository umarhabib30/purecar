@extends('layout.layout')
@section('body')
    <div class="container text-center py-5">
        <h1 class="text-danger">404 - Page Not Found</h1>
        <p>The post you are looking for does not exist or has been removed.</p>
        <a href="{{ url('/') }}" class="btn btn-dark">Go Back to Home</a>
    </div>
@endsection
