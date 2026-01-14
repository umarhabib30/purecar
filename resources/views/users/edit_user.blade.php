@extends('layout.superAdminDashboard')
@section('body')
<section id="edit-user-outer-container">
    <h1>Edit User</h1>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="edit-user-inner-container">
            <div class="p-row">
                <h2>Image</h2>
                <div id="upload-button" onclick="triggerFileInput()">
                    <img
                        class="img {{ $user->image ? 'uploaded-image' : '' }}"
                        src="{{ $user->image ? asset('images/users/' . $user->image) : asset('assets/upload-icon.png') }}"
                        alt="User Profile Image"
                        id="preview-image"
                    >
                    <p id="text" style="{{ $user->image ? 'display: none;' : '' }}">Upload Profile Avatar</p>
                </div>
                <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="p-row">
                <div class="toggle-container">
                    <span class="toggle-label {{ $user->role == 'private_seller' ? 'active' : '' }}" id="private-label">Private Seller</span>
                    <label class="switch">
                        <input type="hidden" name="role" value="{{ $user->role }}" id="role-input">
                        <input type="checkbox" id="role-toggle"
                            {{ $user->role == 'car_dealer' ? 'checked' : '' }}
                            onchange="handleToggleChange(this)">
                        <span class="slider round"></span>
                    </label>
                    <span class="toggle-label {{ $user->role == 'car_dealer' ? 'active' : '' }}" id="dealer-label">Car Dealer</span>
                </div>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="p-row" id="background-image-container" style="display: {{ $user->role == 'car_dealer' ? 'block' : 'none' }};">
                <h2>Background Image</h2>
                <div id="upload-button" onclick="triggerFileInputbackground('background-input')">
                    <img
                        class="img {{ $user->background_image ? 'uploaded-image' : '' }}"
                        src="{{ $user->background_image ? asset('images/users/' . $user->background_image) : asset('assets/upload-icon.png') }}"
                        alt="User Background Image"
                        id="background-preview"
                    >
                    <p id="text" style="{{ $user->background_image ? 'display: none;' : '' }}">Upload Company Banner</p>
                </div>
                <input type="file" id="background-input" name="background_image" accept="image/*" style="display: none;" onchange="backgroundImage(event)">
                @error('background_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="p-row phone-numbers">
                <div class="input-group mobilecontainer">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mobilecontainer">
                    <label for="email">Login Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mobilecontainer">
                    <label for="inquiry_email">Inquiry Email <span class="text-danger">*</span></label>
                    <input type="email" name="inquiry_email" placeholder="Inquiry Email" value="{{ old('inquiry_email', $user->inquiry_email) }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="p-row phone-numbers">
                <div class="input-group mobilecontainer">
                    <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number', $user->phone_number) }}">
                    @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mobilecontainer">
                    <label for="watsaap_number">WhatsApp Number</label>
                    <input type="tel" name="watsaap_number" placeholder="WhatsApp Number" value="{{ old('watsaap_number', $user->watsaap_number) }}">
                    @error('watsaap_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="p-row">
                <div class="input-group mobilecontainer">
                    <label for="location">Location <span class="text-danger">*</span></label>
                    <input type="text" name="location" placeholder="Location" value="{{ old('location', $user->location) }}">
                    @error('location')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="p-row" id="business-desc-container" style="display: {{ $user->role == 'car_dealer' ? 'block' : 'none' }};">
                <div class="input-group mobilecontainer">
                    <label for="business_desc">Business Description <span class="text-danger">*</span></label>
                    <textarea name="business_desc" id="business_desc" rows="4" placeholder="Business Description" maxlength="300">{{ old('business_desc', $user->business_desc) }}</textarea>
                    <small id="charCount" class="text-muted">300 characters remaining</small>
                    <p id="limitExceed" class="text-danger" style="display: none;">Character limit exceeded!</p>
                    @error('business_desc')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="p-row" id="website-container" style="display: {{ $user->role == 'car_dealer' ? 'block' : 'none' }};">
                <div class="input-group mobilecontainer">
                    <label for="website">Website <span class="text-danger">*</span></label>
                    <input type="url" name="website" placeholder="Website" value="{{ old('website', $user->website) }}">
                    @error('website')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="p-row">
                <div class="input-group mobilecontainer">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="input-group" id="button-container">
                <button type="submit" id="save-btn">Save Changes</button>
            </div>
        </div>
    </form>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const textarea = document.getElementById("business_desc");
    const charCount = document.getElementById("charCount");
    const limitExceed = document.getElementById("limitExceed");
    const maxLength = 300;

    function updateCharCount() {
        let currentLength = textarea.value.length;
        let remaining = maxLength - currentLength;
        charCount.textContent = remaining + " characters remaining";

        if (remaining < 0) {
            textarea.value = textarea.value.substring(0, maxLength);
            charCount.textContent = "0 characters remaining";
            limitExceed.style.display = "block";
        } else {
            limitExceed.style.display = "none";
        }
    }

    if (textarea) {
        updateCharCount();
        textarea.addEventListener("input", updateCharCount);
    }
});

function triggerFileInput() {
    document.getElementById('image-input').click();
}

function previewImage(event) {
    const file = event.target.files[0];
    const previewImage = document.getElementById("preview-image");
    const textElement = previewImage.nextElementSibling;

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

function triggerFileInputbackground(inputId) {
    document.getElementById(inputId).click();
}

function backgroundImage(event) {
    const file = event.target.files[0];
    const backgroundPreview = document.getElementById("background-preview");
    const textElement = backgroundPreview.nextElementSibling;

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

document.addEventListener('DOMContentLoaded', () => {
    const roleToggle = document.getElementById('role-toggle');
    const roleInput = document.getElementById('role-input');
    const initialRole = roleInput.value;
    roleToggle.checked = initialRole === 'car_dealer';

    const privateLabel = document.getElementById('private-label');
    const dealerLabel = document.getElementById('dealer-label');
    if (initialRole === 'car_dealer') {
        privateLabel.classList.remove('active');
        dealerLabel.classList.add('active');
    } else {
        privateLabel.classList.add('active');
        dealerLabel.classList.remove('active');
    }

    handleToggleChange(roleToggle);
});
</script>

<style>
#edit-user-outer-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

h2 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #555;
}

.p-row {
    margin-bottom: 20px;
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.input-group input,
.input-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

.input-group textarea {
    resize: vertical;
    min-height: 100px;
}

#upload-button {
    position: relative;
    cursor: pointer;
    text-align: center;
    border: 2px dashed #ddd;
    padding: 20px;
    border-radius: 4px;
}

#upload-button img {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
}

#upload-button img.uploaded-image {
    max-width: 150px;
    max-height: 150px;
    border-radius: 4px;
}

#upload-button p {
    margin: 10px 0 0;
    color: #666;
}

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

#save-btn {
    width: 100%;
    padding: 10px;
    background: black;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

.phone-numbers {
    display: flex;
    gap: 20px;
}

.phone-numbers .input-group {
    flex: 1;
}

@media (max-width: 768px) {
    #edit-user-outer-container {
        padding: 15px;
    }
    h1 {
        font-size: 24px;
    }
    .phone-numbers {
        flex-direction: column;
        gap: 10px;
    }
    .input-group input,
    .input-group textarea {
        font-size: 14px;
    }
    #save-btn {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    #edit-user-outer-container {
        padding: 10px;
    }
    h1 {
        font-size: 20px;
    }
    .input-group input,
    .input-group textarea {
        font-size: 12px;
    }
    #save-btn {
        font-size: 12px;
    }
}
</style>
@endsection