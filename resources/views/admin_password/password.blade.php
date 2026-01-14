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
        <h1 id="password-heading">Change Password</h1>
        <div id="inner-container">
            <form action="{{route('change_password')}}" method="POST">
                @csrf
            <div class="input-group">
                <label for="old-pass">Old Password</label>
                <input type="password" name="old_password" placeholder="enter old password">
                @error('old_password')
            <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label for="new-pass-1">New Password</label>
                <input type="password" name="new_password" placeholder="enter new password">
                @error('new_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="input-group">
                <label for="new-pass-2">Confirm Password</label>
                <input type="password" name="new_password_confirmation" placeholder="re-type new password">
                @error('new_password_confirmation')
            <span class="text-danger">{{ $message }}</span>
             @enderror
            </div>
            <div id="btn-container">
                <button>Save</button>
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
