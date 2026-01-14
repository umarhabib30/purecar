@extends('layout.layout')
@section('body')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color:rgb(255, 255, 255);
    }

    .heading {
        text-align: center;
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 40px;
    }

    .paragraph-top {
        text-align: center;
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }
    .form-section{
        padding: 30px 100px;
        background-color: white;
    }
    .input-inner-div{
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .grid-form{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .input-inner-div label{
        font-weight: 600;
    }
    .input-inner-div input{
        border: none !important;
        background-color: #F9FAFB;
        padding: 10px 15px;
    }
    .input-inner-div select{
        border: none !important;
        background-color: #F9FAFB;
        padding: 10px 15px;
        cursor: pointer;
    }
    .input-inner-div textarea{
        border: none !important;
        background-color: #F9FAFB;
        padding: 10px 15px;
    }
    .submit-button-div{
        display: flex;
        justify-content: end;
    }
    .submit-button{
        width: fit-content;
        background-color: black;
        border: none;
        padding: 10px 15px;
        color: white;
        margin-top: 10px;
    }
    .preview-thumbs{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        row-gap: 10px;
        column-gap: 10px;
    }
    .custom-select-wrapper {
        position: relative;
        width: 100%;
    }

    .custom-select-wrapper select {
        width: 100%;
        padding: 10px 40px 10px 12px;
        font-size: 14px;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #F9FAFB;
    }

    .custom-select-wrapper::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 12px;
        width: 0;
        height: 0;
        pointer-events: none;
        transform: translateY(-50%);
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #6b7280; /* filled gray arrow */
    }

    /* Success Popup Styles */
    .success-popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .success-popup-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .success-popup {
        background: white;
        padding: 40px 60px;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.9) translateY(20px);
        transition: all 0.3s ease;
        max-width: 400px;
        width: 90%;
    }

    .success-popup-overlay.active .success-popup {
        transform: scale(1) translateY(0);
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        animation: successBounce 0.6s ease 0.2s both;
    }

    .success-icon svg {
        width: 40px;
        height: 40px;
        color: white;
    }

    .success-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
    }

    .success-message {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .redirect-info {
        color: #9ca3af;
        font-size: 0.875rem;
    }

    @keyframes successBounce {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }
        50% {
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media screen and (max-width:786px){
        .grid-form{
            display: grid;
            grid-template-columns: 1fr;
        }
        .form-section{
            padding: 15px 15px;
            background-color: white;
        }
        .submit-button-div{
            display: flex;
            justify-content: end;
        }
        .submit-button{
            width: fit-content;
            background-color: black;
            border: none;
            padding: 10px 15px;
            color: white;
            margin-top: 10px;
        }
        .preview-thumbs{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            row-gap: 10px;
            column-gap: 10px;
        }
        .success-popup {
            padding: 30px 40px;
            margin: 20px;
        }
    }
</style>
<div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-4 heading" style="font-weight: 500; font-size: 34px;">Add Your Business to PureCar Today!</h1>
        <p class="mb-8 text-gray-600 paragraph-top">Get discovered by thousands of car buyers and vehicle owners...</p>

        @if (session('success'))
            <div class="fixed bottom-[5%] right-[5%] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data" class="form-section" style="margin-bottom:0 !important; padding-bottom: 0 !important;" >
            @csrf
            <div class="grid-form">
                <div class="input-inner-div">
                    <label class="">Business Name</label>
                    <input type="text" name="name" class="" placeholder="" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-inner-div">
                    <label class="" style="">Business Type</label>
                    <div class="custom-select-wrapper">
                        <select name="business_type_id" required>
                            <option value="">Select Option</option>
                            @foreach($businessTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('business_type_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div  class="input-inner-div">
                    <label class="">Business Location</label>
                    <div class="custom-select-wrapper">
                        <select name="business_location_id" class="" required>
                            <option value="">Select Option</option>
                            @foreach($businessLocations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('business_location_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-inner-div">
                    <label class="">Contact No</label>
                    <input type="text" name="contact_no" class="" placeholder="" required>
                    @error('contact_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-inner-div">
                    <label class="">Email</label>
                    <input type="email" name="email" class="" placeholder="">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-inner-div">
                    <label class="">Address</label>
                    <input type="text" name="address" class="" placeholder="" required>
                    @error('address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
              
            </div>
            <div class="input-inner-div" style="margin-top: 12px;">
                    <label class="">Website</label>
                    <input type="text" name="website" placeholder="" class="" >
                    @error('website')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>
            <div class="input-inner-div" style="margin-top: 12px;">
                <label class="">Description</label>
                <textarea name="description" class="" rows="5" placeholder=""></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-inner-div" style="margin-top: 8px;">
                <label class="">Business Images</label>
            
                <!-- Hidden file input triggered by custom upload div -->
                <input type="file" id="feature-image" name="images[]" accept="image/*" multiple style="display: none;" onchange="handleFeatureImage(event)">
            
                <!-- Custom upload button UI -->
                <div id="upload-button" style="cursor: pointer; margin-top: 20px; margin-bottom: 20px; width:100%; text-align:center; border:2px dotted black"
                     onclick="document.getElementById('feature-image').click()">
                    <img src="{{ asset('assets/upload_icon.png') }}" alt="Upload Images"
                         id="upload-icon" class="mb-4 mt-4 mx-auto" style="width: 50px;">
                    <p class="text-gray-500">Drag your file(s) or click here to start uploading</p>
                </div>
            
                <!-- Preview thumbnails -->
                <div id="image-preview" class="preview-thumbs flex-wrap mt-4 mb-4"></div>
            
                @error('images.*')                    
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            {{-- image preview  --}}
            <div id="image-preview" class="preview-thumbs"></div>
            <div class="submit-button-div">
                <button type="submit" class="submit-button">Submit Listing</button>
            </div>
        </form>
</div>

<!-- Success Popup -->
<div id="successPopup" class="success-popup-overlay">
    <div class="success-popup">
        <div class="success-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h3 class="success-title">Success!</h3>
        <p class="success-message">Your listing will be published once it has been reviewed by our team. </p>
    </div>
</div>

<script>
    let selectedFiles = [];

    function handleFeatureImage(event) {
        const files = Array.from(event.target.files);
        selectedFiles = files; 
        updateImagePreview();
    }

    function updateImagePreview() {
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.style.position = 'relative';
                wrapper.style.width = '210px';
                wrapper.style.height = '210px';
                wrapper.style.overflow = 'hidden';
       
              

                // Create remove button
                const removeBtn = document.createElement('button');
                removeBtn.textContent = '×';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '5px';
                removeBtn.style.right = '10px';
                removeBtn.style.background = 'rgba(0,0,0,0.6)';
                removeBtn.style.color = '#fff';
                removeBtn.style.border = 'none';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.width = '24px';
                removeBtn.style.height = '24px';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.zIndex = '10';
                removeBtn.onclick = () => {
                    selectedFiles.splice(index, 1);
                    updateImagePreview();
                };

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';

                wrapper.appendChild(removeBtn);
                wrapper.appendChild(img);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    function showSuccessPopup() {
        const popup = document.getElementById('successPopup');
        popup.classList.add('active');
        
        // Redirect after 2 seconds
        setTimeout(() => {
            window.location.href = '{{ route("business.index") }}';
        }, 2000);
    }
</script>
    
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        const fileInput = form.querySelector('input[type="file"][name="images[]"]');        
    
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!selectedFiles.length) {
                // Handle form submission without images
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(res => {
                    if (res.ok) {
                        showSuccessPopup();
                    } else {
                        alert('Upload failed');
                    }
                })
                .catch(err => console.error(err));
                
                return;
            }

            // Handle form submission with images
            const compressedFiles = await Promise.all(
                selectedFiles.map(file => compressImageToTarget(file, 1 * 1024 * 1024))
            );

            const formData = new FormData(form);
            formData.delete('images[]');

            compressedFiles.forEach((blob, i) => {
                formData.append('images[]', blob, `image_${i}.webp`);
            });

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(res => {
                if (res.ok) {
                    showSuccessPopup();
                } else {
                    alert('Upload failed');
                }
            })
            .catch(err => console.error(err));
        });
    
        function compressImageToTarget(file, targetSize) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = async () => {
                        let width = img.width;
                        let height = img.height;
                        let quality = 0.5;
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
    
                        while (true) {
                            canvas.width = width;
                            canvas.height = height;
                            ctx.clearRect(0, 0, width, height);
                            ctx.drawImage(img, 0, 0, width, height);
    
                            const blob = await new Promise(res => canvas.toBlob(res, 'image/webp', quality));
                            if (blob.size <= targetSize || width < 400) {
                                resolve(blob);
                                break;
                            }
    
                            width *= 0.8;
                            height *= 0.8;
                            quality *= 0.9;
                        }
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });
        }
    });
</script>        

@endsection