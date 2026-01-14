@extends('layout.superAdminDashboard')
@section('body')
<section id="add-user-outer-container">
    <h1>{{ $title }}</h1>
    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="add-user-inner-container">
            <div class="input-group">
                <label for="role">Role <span class="text-danger">*</span></label>
                <select name="role" id="role" required>
                    <option value="private_seller">Private Seller</option>
                    <option value="car_dealer">Car Dealer</option>
                </select>
            </div>
            <div class="input-group">
                <label for="image">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" id="image" required>
            </div>
            <div class="input-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" placeholder="Name" required>
            </div>
            <div class="input-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
             <div class="input-group">
                <label for="inquiry_email">Inquiry Email <span class="text-danger">*</span></label>
                <input type="email" name="inquiry_email" id="inquiry_email" placeholder="Inquiry Email" required>
            </div>
            <div class="input-group">
                <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" required>
            </div>
            <div class="input-group">
                <label for="watsaap_number">WhatsApp Number <span class="text-danger"></span></label>
                <input type="text" name="watsaap_number" id="watsaap_number" placeholder="WhatsApp Number">
            </div>
            <div class="input-group">
                <label for="location">Location <span class="text-danger">*</span></label>
                <input type="text" name="location" id="location" placeholder="Location" required>
            </div>
            <div class="input-group" id="business-desc-container">
                <label for="business_desc">Business Description <span class="text-danger">*</span></label>
                <textarea name="business_desc" id="business_desc" placeholder="Business Description"></textarea>
            </div>
            <div class="input-group" id="website-container">
                <label for="website">Website <span class="text-danger">*</span></label>
                <input type="url" name="website" id="website" placeholder="Website">
            </div>
            <div class="input-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div id="btn-container">
                <button type="submit" id="save-btn">Save</button>
            </div>
        </div>
    </form>
</section>
<script>
    // JavaScript to dynamically handle fields based on role
    document.getElementById('role').addEventListener('change', function () {
        const role = this.value;
        const businessDescContainer = document.getElementById('business-desc-container');
        const websiteContainer = document.getElementById('website-container');
        if (role === 'private_seller') {
            businessDescContainer.style.display = 'none';
            websiteContainer.style.display = 'none';
        } else if (role === 'car_dealer') {
            businessDescContainer.style.display = 'block';
            websiteContainer.style.display = 'block';
        }
    });
    // Trigger the change event on page load to set the initial visibility
    document.getElementById('role').dispatchEvent(new Event('change'));
</script>
<style>
    #add-user-outer-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    #add-user-inner-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .input-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .input-group label {
        font-weight: bold;
        color: #555;
    }
    .input-group input,
    .input-group select,
    .input-group textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }
    .input-group input:focus,
    .input-group select:focus,
    .input-group textarea:focus {
        border-color: black;
        outline: none;
    }
    #btn-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    #save-btn {
        padding: 10px 20px;
        background-color: black;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    @media (max-width: 768px) {
        #add-user-outer-container {
            padding: 15px;
        }
        .input-group input,
        .input-group select,
        .input-group textarea {
            font-size: 14px;
        }
        #save-btn {
            width: 100%;
            padding: 12px;
        }
    }
    @media (max-width: 480px) {
        h1 {
            font-size: 24px;
        }
        .input-group label {
            font-size: 14px;
        }
    }
</style>
@endsection
