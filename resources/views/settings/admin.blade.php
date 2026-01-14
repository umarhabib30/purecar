@extends('layout.superAdminDashboard')
@section('body')
<link rel="stylesheet" href="{{asset('css/ChangePasswordPage.css')}}">
    <section class="ChangePasswordPage">
    <div id="outer-container">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        <h1 id="password-heading">Settings</h1>
        <div id="inner-container">
        <form action="{{ route('change_forum_image_limit') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="forum_images_limit">Set forum images limit (MAX: 100)</label>
                <input type="number" name="forum_images_limit" placeholder="Set limit from 1 to 100" 
                    min="1" max="100" value="{{ old('forum_images_limit', \DB::table('settings')->where('key', 'forum_images_limit')->value('value')) }}">
                @error('forum_images_limit')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div id="btn-container">
                <button type="submit">Save</button>
            </div>
        </form>
        

        </div>
           <div id="inner-container" class="mt-3">
             <form action="{{ route('clear.cache') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="clear_cache">Clear All Caches</label>
                    <p>Clear application cashe</p>
                </div>
                <div id="btn-container">
                    <button type="submit" class="clear-cache-btn">Clear Cache</button>
                </div>
        </form>
        </div>
    </div>
</section>
<style>
    .input-group{
        width: 100%;
    }
    .input-group input{
        width: 100%;
    }
</style>
@endsection
