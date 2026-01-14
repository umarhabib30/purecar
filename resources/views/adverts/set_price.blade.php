@extends('layout.superAdminDashboard')
@section('body')
<link rel="stylesheet" href="{{asset('css/ChangePasswordPage.css')}}">
    <section class="ChangePasswordPage">
    <div id="outer-container">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <h1 id="password-heading">Cheapest Cars</h1>
        <div id="inner-container">
            <form action="{{ route('set-price.update') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="min_price">Minimum Price</label>
                    <input type="number" 
                           name="min_price" 
                           id="min_price" 
                           value="{{ old('min_price', $priceSettings->min_price ?? '') }}"
                           step="0.01"
                           required>
                    @error('min_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="max_price">Maximum Price</label>
                    <input type="number" 
                           name="max_price" 
                           id="max_price" 
                           value="{{ old('max_price', $priceSettings->max_price ?? '') }}"
                           step="0.01"
                           required>
                    @error('max_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div id="btn-container">
                    <button type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    .input-group{
        width: 100%;
        margin-bottom: 20px;
    }
    .input-group input{
        width: 100%;
        padding: 8px;
        margin-top: 5px;
    }
    .text-danger {
        color: red;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }
</style>
@endsection