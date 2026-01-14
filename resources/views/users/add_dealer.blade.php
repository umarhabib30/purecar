@extends('layout.superAdminDashboard')
@section('body')
 
<link rel="stylesheet" href="{{asset('css/ProfilePage1.css')}}">

<section class="ProfilePage">
    <div id="outer-container">
        <h2 class="d-none d-md-block">Add dealer</h2>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        
        <form action="{{ route('admin.save_dealer') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="profile-container">
                <div class="p-row">
                    <h2>Image</h2>
                    <div id="upload-button" onclick="triggerFileInput()">
                        <img
                            class="img"
                            src="{{ asset('assets/upload-icon.png') }}"
                            alt="User Profile Image"
                            id="preview-image"
                            name="image"
                        >
                        <p id="text">Upload Profile Avatar</p>
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">

                    <div class="p-row" id="p-row-last">
                        <div class="toggle-container">
                            <span class="toggle-label active" id="private-label">Private Seller</span>
                            <label class="switch">
                                 <input type="hidden" name="role" value="private_seller" id="role-input">
                                <input type="checkbox" id="role-toggle" onchange="handleToggleChange(this)">
                                <span class="slider round"></span>
                            </label>
                            <span class="toggle-label" id="dealer-label">Car Dealer</span>
                        </div>
                    </div>
                    
                    <div id="background-image-container" style="display: none;">
                        <div id="upload-button" onclick="triggerFileInputbackground('background-input')">
                            <img
                                class="img"
                                src="{{ asset('assets/upload-icon.png') }}"
                                alt="User Background Image"
                                id="background-preview"
                            >
                            <p id="text-bg">Upload Company Banner</p>
                        </div>
                        <input type="file" id="background-input" name="background_image" accept="image/*" style="display: none;" onchange="backgroundImage(event)">
                    </div>
                </div>
                
                <div id="second-container">
                    <div class="p-row phone-numbers">
                        <div class="input-group mobilecontainer">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" placeholder="" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="input-group mobilecontainer">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" placeholder="" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="p-row phone-numbers">
                        <div class="input-group mobilecontainer">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                            @error('password')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="input-group mobilecontainer">
                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <div class="p-row phone-numbers">
                        <div class="input-group mobilecontainer">
                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="input-group mobilecontainer">
                            <label for="whatsapp">Whatsapp Number</label>
                            <input type="tel" value="{{ old('watsaap_number') }}" name="watsaap_number">
                            @error('watsaap_number')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="p-row">
                        <div class="input-group mobilecontainer">
                            <label for="location">Location <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Write" value="{{ old('location') }}" name="location" required>
                            @error('location')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="p-row">
                        <div class="input-group mobilecontainer" id="business-desc-container" style="display: none;">
                            <label for="business_desc" class="form-label">Business Description <span class="text-danger">*</span></label>
                            <textarea name="business_desc" id="business_desc" rows="4" placeholder="Business Description" class="form-control" style="width: 100%; box-sizing: border-box;" maxlength="300">{{ old('business_desc') }}</textarea>
                            <small id="charCount" class="text-muted">300 characters remaining</small>
                            <p id="limitExceed" class="text-danger" style="display: none;">Character limit exceeded!</p>
                            @error('business_desc')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="p-row">
                        <div class="input-group" id="website-container" style="display: none;">
                            <label for="website" style="display: block; margin-bottom: 5px;">Website <span class="text-danger">*</span></label>
                            <input type="text" name="website" value="" placeholder="Website" style="width: 100%;">
                            @error('website')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="button-container">
                        <button type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const textarea = document.getElementById("business_desc");
        const charCount = document.getElementById("charCount");
        const limitExceed = document.getElementById("limitExceed");
        const maxLength = 300;

        // Function to update character count
        function updateCharCount() {
            if (textarea) {
                let currentLength = textarea.value.length;
                let remaining = maxLength - currentLength;
                charCount.textContent = remaining + " characters remaining";

                if (remaining < 0) {
                    textarea.value = textarea.value.substring(0, maxLength); // Trim extra characters
                    charCount.textContent = "0 characters remaining";
                    limitExceed.style.display = "block";
                } else {
                    limitExceed.style.display = "none";
                }
            }
        }

        // Run the function on page load to initialize correctly
        if (textarea) {
            updateCharCount();
            // Listen for input changes
            textarea.addEventListener("input", updateCharCount);
        }
    });

    function triggerFileInput() {
        document.getElementById('image-input').click();
    }

    function previewImage(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById("preview-image");
        const textElement = document.getElementById("text");

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.add("uploaded-image");
                textElement.style.display = 'none';
            }

            reader.readAsDataURL(file);
        }
    }

    function backgroundImage(event) {
        const file = event.target.files[0];
        const backgroundPreview = document.getElementById("background-preview");
        const textElement = document.getElementById("text-bg");

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                backgroundPreview.src = e.target.result;
                backgroundPreview.classList.add("uploaded-image");
                textElement.style.display = 'none';
            }

            reader.readAsDataURL(file);
        }
    }

    function triggerFileInputbackground(inputId) {
        document.getElementById(inputId).click();
    }
    document.querySelector("form").addEventListener("submit", function() {
    const roleInput = document.getElementById('role-input');
    if (!document.getElementById('role-toggle').checked) {
        roleInput.value = 'private_seller';  
    }
    });

    function handleToggleChange(checkbox) {
        const roleInput = document.getElementById('role-input');
        const privateLabel = document.getElementById('private-label');
        const dealerLabel = document.getElementById('dealer-label');
        const businessDescContainer = document.getElementById('business-desc-container');
        const websiteContainer = document.getElementById('website-container');
        const backgroundContainer = document.getElementById('background-image-container');

        if (checkbox.checked) {
            roleInput.value = 'car_dealer';
            privateLabel.classList.remove('active');
            dealerLabel.classList.add('active');
            businessDescContainer.style.display = 'block';
            websiteContainer.style.display = 'block';
            backgroundContainer.style.display = 'block';
        } else {
            roleInput.value = 'private_seller';
            privateLabel.classList.add('active');
            dealerLabel.classList.remove('active');
            businessDescContainer.style.display = 'none';
            websiteContainer.style.display = 'none';
            backgroundContainer.style.display = 'none';
        }
    }
</script>

<style>
.toggle-container {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 15px 0;
}

.toggle-label {
    font-size: 14px;
    color: #666;
    transition: color 0.3s ease;
}

.toggle-label.active {
    color: #000;
    font-weight: 600;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>

<script>
// Initialize the user's role from PHP
const initialRole = "{{ auth()->user()->role }}";

function handleToggleChange(checkbox) {
    const roleInput = document.getElementById('role-input');
    const privateLabel = document.getElementById('private-label');
    const dealerLabel = document.getElementById('dealer-label');

    if (checkbox.checked) {
        roleInput.value = 'car_dealer';
        privateLabel.classList.remove('active');
        dealerLabel.classList.add('active');
    } else {
        roleInput.value = 'private_seller';
        privateLabel.classList.add('active');
        dealerLabel.classList.remove('active');
    }

    toggleExtraFields();
}

function toggleExtraFields() {
    const roleInput = document.getElementById('role-input');
    const businessDescContainer = document.getElementById('business-desc-container');
    const websiteContainer = document.getElementById('website-container');
    const backgroundContainer = document.getElementById('background-image-container');

    const isCarDealer = roleInput.value === 'car_dealer';

    businessDescContainer.style.display = isCarDealer ? 'block' : 'none';
    websiteContainer.style.display = isCarDealer ? 'block' : 'none';
    backgroundContainer.style.display = isCarDealer ? 'block' : 'none';
}

// Initialize everything on page load
document.addEventListener('DOMContentLoaded', () => {
    // Set initial toggle state
    const roleToggle = document.getElementById('role-toggle');
    const roleInput = document.getElementById('role-input');

    // Ensure the hidden input has the correct initial value
    roleInput.value = initialRole;

    // Set the toggle checkbox state
    roleToggle.checked = initialRole === 'car_dealer';

    // Set initial label states
    const privateLabel = document.getElementById('private-label');
    const dealerLabel = document.getElementById('dealer-label');

    if (initialRole === 'car_dealer') {
        privateLabel.classList.remove('active');
        dealerLabel.classList.add('active');
    } else {
        privateLabel.classList.add('active');
        dealerLabel.classList.remove('active');
    }

    // Set initial field visibility
    toggleExtraFields();
});
</script>
@endsection


