@extends('layout.dashboard')
@section('body')
<section class="LogOut">
    <div class="modal-backdrop"></div>
    <div id="logout-container">
        <div id="contents">
            <img src="{{ asset('assets/delete-icon.svg') }}" alt="Delete Icon">
            <p id="main-text">Are you sure you want to log out?</p>
            <p id="sub-text">You will be logged out of your account.</p>
        </div>
        <div id="btn-container">
            <!-- Form to cancel logout -->
            <form action="{{ route('dashboard') }}" method="GET">
                <button type="submit" id="no-btn">No, cancel</button>
            </form>

            <!-- Form to confirm logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Yes, Logout</button>
            </form>
        </div>
    </div>
</section>
@endsection
