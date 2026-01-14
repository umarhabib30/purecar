@extends('layout.dashboard')
@section('body')

    <section class="ProfilePage">
    <div id="outer-container">
    <h2 class="d-none d-md-block">Profile</h2>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('user_profile', ['id' => 1]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="profile-container">
        <div class="p-row">
            <h2>Image</h2>
            <div id="upload-button" onclick="triggerFileInput()">
                <img
                    class="img {{ auth()->user()->image ? 'uploaded-image' : '' }}"
                    src="{{ auth()->user()->image ? asset('images/users/' . auth()->user()->image) : asset('assets/upload-icon.png') }}"
                    alt="User Profile Image"
                    id="preview-image"
                    name="image"
                >
                <p id="text" style="{{ auth()->user()->image ? 'display: none;' : '' }}">Upload Profile Avatar</p>
            </div>
            <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">

            <div class="p-row" id="p-row-last">

                <div class="toggle-container">
                    <span class="toggle-label {{ auth()->user()->role == 'private_seller' ? 'active' : '' }}" id="private-label">Private Seller</span>
                    <label class="switch">
                        <input type="hidden" name="role" value="private_seller" id="role-input">
                        <input type="checkbox" id="role-toggle"
                            {{ auth()->user()->role == 'car_dealer' ? 'checked' : '' }}
                            onchange="handleToggleChange(this)">
                        <span class="slider round"></span>
                    </label>
                    <span class="toggle-label {{ auth()->user()->role == 'car_dealer' ? 'active' : '' }}" id="dealer-label">Car Dealer</span>
                </div>

            </div>
            <div id="background-image-container">
                <div id="upload-button" onclick="triggerFileInputbackground('background-input')">
                    <img
                    class="img {{ auth()->user()->background_image ? 'uploaded-image' : '' }}"
                    src="{{ auth()->user()->background_image ? asset('images/users/' . auth()->user()->background_image) : asset('assets/upload-icon.png') }}"
                    alt="User Background Image"
                    id="background-preview"
                    >
                    <p id="text" style="{{ auth()->user()->background_image ? 'display: none;' : '' }}">Upload Company Banner</p>
                </div>
                <input type="file" id="background-input" name="background_image" accept="image/*" style="display: none;" onchange="backgroundImage(event)">

            </div>
        </div>
        <div id="second-container">
            <div class="p-row phone-numbers">
                <div class="input-group mobilecontainer">
                    <label for="name">Name</label>
                    <input type="text" placeholder="" name="name"
                    value="{{ old('name', auth()->user()->name ?? '') }}">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="input-group mobilecontainer">
                    <label for="email">Login Email</label>
                    <input type="text" placeholder="" name="email" value="{{ old('email', auth()->user()->email ?? '') }}">
                    @error('email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                 <div class="input-group mobilecontainer">
                    <label for="inquiry_email">Inquiry Email</label>
                    <input type="text" placeholder="" name="inquiry_email" value="{{ old('inquiry_email', auth()->user()->inquiry_email ?? '') }}">
                    @error('inquiry_email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="p-row phone-numbers " >
                <div class="input-group mobilecontainer">
                    <label for="phone">Phone Number (For Car Advert)</label>
                    <input type="tel"  name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number ?? '') }}">
                    @error('phone_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
               <div class="input-group mobilecontainer">
                    <label for="whatsapp">Whatsapp Number (For Car Advert)</label>
                   <?php 
                        $whatsappNumber = old('watsaap_number', auth()->user()->watsaap_number ?? '');

         
                        $whatsappNumber = ltrim($whatsappNumber, '0');

                      
                        $displayNumber = $whatsappNumber && !str_starts_with($whatsappNumber, '+44') ? '+44' . $whatsappNumber : $whatsappNumber;
                    ?>
                    <input type="tel" value="{{ $displayNumber }}" name="watsaap_number">
                    @error('watsaap_number')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="p-row">
                <div class="input-group mobilecontainer">
                    <label for="location">Location (For Car Advert)</label>
                    <input type="text" placeholder="Write" value="{{ old('location', auth()->user()->location ?? '') }}" name="location">
                    @error('location')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
           
           

            <div class="p-row">
            <div class="input-group mobilecontainer" id="business-desc-container" style="display: none;">
    <label for="business_desc" class="form-label">Business Description <span class="text-danger">*</span></label>
    <textarea name="business_desc" id="business_desc" rows="4" placeholder="Business Description" class="form-control" style="width: 100%; box-sizing: border-box;" maxlength="300">{{ old('business_desc', auth()->user()->business_desc ?? '') }}</textarea>
    <small id="charCount" class="text-muted">300 characters remaining</small>
    <p id="limitExceed" class="text-danger" style="display: none;">Character limit exceeded!</p>
</div>
        </div>



            <div class="p-row">
                <div class="input-group" id="website-container" style="display: none;">
                    <label for="website" style="display: block; margin-bottom: 5px;">Website <span class="text-danger">*</span></label>
                    <input type="text" name="website"  value="{{ old('website', auth()->user()->website ?? '') }}" placeholder="Website" style="width: 100%;">
                </div>
            </div>





            <!-- Placeholder for Dynamic Fields -->


            <div id="button-container">
                @if(auth()->user()->welcome_email_sent==0)
                <button type="submit">Activate</button>
                @else
                 <button type="submit">Save</button>
                @endif
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

        // Run the function on page load to initialize correctly
        updateCharCount();

        // Listen for input changes
        textarea.addEventListener("input", updateCharCount);
    });
</script>
<script>
   let uploadedImageData = null;  // Variable to store the uploaded image data

function triggerFileInput() {
    document.getElementById('image-input').click();
}
// Replace content of #upload-button with the selected image
function previewImage(event) {
    const file = event.target.files[0];  // Get the uploaded file
    const previewImage = document.getElementById("preview-image");

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;  // Set the preview image source
            previewImage.classList.add("uploaded-image");  // Add class to style the uploaded image
        }

        reader.readAsDataURL(file);  // Read the file as a data URL
    }
}
function backgroundImage(event) {
    const file = event.target.files[0];
    const backgroundPreview = document.getElementById("background-preview");
    const textElement = document.getElementById("text");

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            backgroundPreview.src = e.target.result;
            backgroundPreview.classList.add("uploaded-image");
            textElement.style.display = 'none'; // Hide the upload text
        }

        reader.readAsDataURL(file);
    }
}

function triggerFileInputbackground(inputId) {
    document.getElementById(inputId).click();
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

