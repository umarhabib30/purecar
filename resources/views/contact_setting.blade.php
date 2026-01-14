@extends('layout.superAdminDashboard')
@section('body')
<section id="contact-outer-container">
        <h1>Contact Details</h1>
        <div id="contact-inner-container">
            <h2>Edit Details</h2>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" placeholder="hello@pixelit.com">
            </div>
            <div class="input-group">
                <label for="number">Phone Number</label>
                <input type="tel" placeholder="xxxxxxxxxxx">
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" placeholder="9 Goldberry Ct, Brampton, ON L6X 4P5, Canada">
            </div>
            <div id="btn-container">
                <button id="cancel-btn">Cancel</button>
                <button id="save-btn">Save</button>
            </div>
        </div>
    </section>
 @endsection   