@extends('layout.dashboard')
@section('body')
<section class="SubmitAdvertPage2">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 4.5 CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-pzjw8f+ua7Kw1TIq0+1Xy6lRzFz88aIsp9P0he5iDs9tTaV15vI7Fqep9FUnxvLZP" crossorigin="anonymous">
    <!-- Bootstrap 4.5 JS and Popper.js CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIq0+1Xy6lRzFz88aIsp9P0he5iDs9tTaV15vI7Fqep9FUnxvLZP" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-b4gt1jrGC7Jh4Agbs7pR2H0I6NO4w6lY64gGRTWf/i6t8L8LMW+V5IcR2wcsfiQ4O" crossorigin="anonymous">
    </script>
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

    <style>
        input[type="file"] {
    display: none !important;
}
    .image-preview-grid {
        display: grid;
        /* For larger screens, keep auto-fill behavior */
        grid-template-columns: repeat(auto-fill, minmax(162px, 1fr));
        gap: 10px;
        margin-top: 20px;
    }

    /* Add media query for mobile devices */
    @media screen and (max-width: 480px) {
        .image-preview-grid {
            /* Force 2 columns on mobile */
            grid-template-columns: repeat(2, 1fr);
            /* Adjust gap for smaller screens */
            gap: 8px;
        }

        .preview-container {
            /* Make containers responsive */
            width: 132px !important;
            height: 132px !important;
            aspect-ratio: 1/1;
        }

        .preview-container img {
            /* Make images responsive */
            max-width: 100px !important;
            height: 100% !important;
        }

    }

    @media screen and (max-width: 767px) {
        #outer-container {
            background: white !important;
        }
    }

    /* Rest of your existing CSS */
    .preview-container {
        position: relative;
        width: 162px;
        height: 162px;
        overflow: hidden;
        border: 1px solid #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-container img {
        max-width: 162px !important;
        height: 162px !important;
        border: 1px solid #ccc;
        border-radius: 5px;
        object-fit: cover !important;
    }

    .remove-image {
        position: absolute;
        top: 5px !important;
        right: 5px !important;
        background: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }



    #upload-button {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-bottom: 20px;
    }

    #upload-button:hover {
        border-color: #999;
    }

    #upload-icon {
        width: 50px;
        height: 50px;
        margin-bottom: 10px;
    }
    </style>
@php

if (Session::has('saved_coupon')) {
    $couponUsed = Session::get('saved_coupon');
    Session::put('save_coupon', $couponUsed);
}
@endphp
<?php
    Session::forget('payment_completed');
?>

    <div id="outer-container">
        <h1 id="outer-container-heading">Submit Advert</h1>
        <div id="inner-container">
            <div class="row d-flex justify-content-between">

                <div class="col-12 col-md-6 d-flex flex-column">
                    <h6 class="fw-bold mt-4 mobilecontainer">
                        {{ session('vehicleInfo')['make'] }} {{ session('vehicleInfo')['model'] }}
                        ({{ session('vehicleInfo')['YearOfManufacture'] }})
                    </h6>
                    <p class="mobilecontainer">
                        {{ session('vehicleInfo')['EngineCapacity'] }}L {{ session('vehicleInfo')['Trim'] }}
                        {{ session('vehicleInfo')['FuelType'] }} {{ session('vehicleInfo')['gear_box'] }}
                    </p>
                </div>

                <!-- Mileage Information (Right) -->
                <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center">
                    <div id="mileage-container" class="d-flex align-items-center">
                        <div id="mileage" class="d-flex align-items-center">
                            <!-- <img src="assets/mileage.png" alt="Mileage Icon" class="me-2"> -->
                            <p id="mileage-text" class="mb-0">
                                @if(session('licensedata'))
                                <span id="mileage-value">{{ session('licensedata')['miles'] }}</span>
                                @endif
                                Miles
                            </p>
                        </div>
                        <a id="edit-mileage-btn" href="javascript:void(0);" class="ms-2 text-dark m-0">Edit Mileage</a>
                    </div>
                </div>
            </div>


            @if (session('tag'))
            <div class="alert alert-success alert-dismissible fade show">{{session('tag')}}</div>
            @endif

            <form action="{{ route('submit.advert') }}" method="POST" enctype="multipart/form-data" class="advert-form"
                id="submitForm" onsubmit="tinymce.triggerSave();">
                @csrf
                <input type="hidden" name="payment_id" id="payment_id">
                <input type="hidden" name="package_duration" id="package_duration">
                <button class="btn btn-dark w-100 d-md-none mb-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#carDetails">
                    Show Car Details
                </button>

                <div class="collapse d-md-block" id="carDetails">
                    <div class="top-form-box">
                        <div class="top-form-box-1">
                            <div class="detail-row">
                                <p class="detail-heading">Fuel Type</p>
                                <input type="hidden" name="fuel_type" value="{{ session('vehicleInfo')['FuelType'] }}">
                                <p class="border-0 detail text-end">{{ session('vehicleInfo')['FuelType'] }}</p>
                            </div>
                            <div class="detail-row">
                                <p class="detail-heading">Body type</p>
                                <input type="hidden" name="bodystyle" value="{{ session('vehicleInfo')['BodyStyle'] }}">
                                <p class="border-0 detail text-end">{{ session('vehicleInfo')['BodyStyle'] }}</p>
                            </div>
                            <div class="detail-row">
                                <p class="detail-heading">Engine</p>
                                <input type="hidden" name="engine"
                                    value="{{ session('vehicleInfo')['EngineCapacity'] }}">
                                <p class="border-0 detail text-end">{{ session('vehicleInfo')['EngineCapacity'] }}</p>
                            </div>
                        </div>
                        <div class="top-form-box-2">
                            <div class="detail-row">
                                <p class="detail-heading">Gearbox</p>
                                <input type="hidden" name="Gearbox"
                                    value="{{ session('vehicleInfo')['Transmission'] }}">
                                <p class="border-0 detail text-end">{{ session('vehicleInfo')['Transmission'] }}</p>
                            </div>
                            <div class="detail-row">
                                <p class="detail-heading">Doors</p>
                                <input type="hidden" name="door" value="{{ session('vehicleInfo')['NumberOfDoors'] }}">
                                <p class="border-0 detail text-end">{{ session('vehicleInfo')['NumberOfDoors'] }}</p>
                            </div>
                            <div class="detail-row">
                                <p class="detail-heading">Seats</p>
                                <input type="hidden" name="seats" value="{{ session('vehicleInfo')['NumberOfSeats'] }}">
                                <p class="border-0 detail text-end">{{ session('vehicleInfo')['NumberOfSeats'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group position-relative">
                    <label for="price" class="h5">Price or add 0 for POA</label>
                    <div class="position-relative">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">£</span>
                        <input type="number" name="price" id="price" placeholder="" class="form-control ps-4"
                            style="border-radius:12px; background-color:#F5F6FA; padding-left: 30px;"
                            inputmode="numeric" step="1" required min="0" 
                                oninput="validatePrice(this)" 
                                onpaste="return false;">
                    </div>
                    @error('price')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>


                <div id="description-div">
                    <div class="input-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description"></textarea>
                        @error('description')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-4">
                    <!-- Feature Image Container - Takes half width on desktop, full on mobile -->
                    <div class="col-12 col-md-6 mb-4">
                        <div id="img-container" class="p-3 bg-light rounded">

                            <div class="p-row">

                                <h2>Thumbnail Image</h2>

                                <div id="upload-button" style="cursor: pointer; margin-top: 20px; margin-bottom: 20px;"
                                    onclick="document.getElementById('feature-image').click()">
                                    <img src="{{asset('assets/upload_icon.png')}}" alt="Upload Images" id="upload-icon"
                                        class="mb-3" style="max-width: 100px;">
                                    <p>Drag your file(s) to start uploading</p>
                              
                                </div>
                            
                                @error('feature_image')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                                <input type="file" id="feature-image" name="feature_image" accept="image/*"
                                    style="display: none;" onchange="handleFeatureImage(event)">
                            </div>
                            <div id="feature-image-preview-container" class="image-preview-grid"></div>
                        </div>
                    </div>

                    <!-- Gallery Images Container - Takes half width on desktop, full on mobile -->
                    <div class="col-12 col-md-6 mb-4">
                        <div id="img-container" class="p-3 bg-light rounded">
                            <div class="p-row">
                                <h2>Main Image</h2>
                                <div id="upload-button" class="main-upload-button" style="cursor: pointer; margin-top: 20px; margin-bottom: 20px;"
                                    onclick="document.getElementById('main-image').click()">
                                    <img src="{{asset('assets/upload_icon.png')}}" alt="Upload Images" id="main-upload-icon"
                                        class="mb-3" style="max-width: 100px;">
                                    <p>Drag your file(s) to start uploading</p>
                                   
                                </div>
                             
                                @error('images.*')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                                <input type="file" id="main-image" name="main_image" accept="image/*" multiple
                                    style="display: none;" onchange="handleMainImage(event)">
                            </div>
                            <div id="main-image-preview-container" class="image-preview-grid"></div>
                        </div>


                    </div>
                </div>
                <!-- gallery Images Container -->
                <div class="col-12 col-md-12 mb-4">
                    <div id="img-container" class="p-3 bg-light rounded">
                        <div class="p-row">
                            <h2>Gallery Images</h2>
                            <div id="upload-button" style="cursor: pointer; margin-top: 20px; margin-bottom: 20px;"
                                onclick="document.getElementById('multiple-images').click()">
                                <img src="{{asset('assets/upload_icon.png')}}" alt="Upload Images" id="upload-icon"
                                    class="mb-3" style="max-width: 100px;">
                                    <p>Drag your file(s) to start uploading</p>
                                  
                            </div>
                           
                            @error('images.*')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                            <input type="file" id="multiple-images" name="images[]" accept="image/*" multiple
                                style="display: none;" onchange="handleMultipleImages(event)">
                        </div>
                        <div id="image-preview-container" class="image-preview-grid"></div>
                    </div>


                </div>
                <div class="pt-2" id="progressContainer" style="display: none; text-align: center;">
                    <div style="width: 100%; background-color: #e0e0e0; border-radius: 8px; position: relative;">
                        <div id="progressBar"
                            style="width: 0%; height: 20px; background-color: #4A90E2; border-radius: 8px; position: relative; text-align: center; line-height: 20px; color: white; font-weight: bold;">
                            <span id="progressText" style="position: absolute; width: 100%; left: 0; top: 0;">0%</span>
                        </div>
                    </div>
                </div>

                <div id="btn-container">
                    <!-- <button type="submit" name="action" value="edit" id="edit-btn">Edit vehicle details</button> -->
                    <button type="submit" id="submitBtn">Submit

                        <span id="loadingSpinner" class="spinner-border spinner-border-sm text-light"
                            style="display: none;" role="status" aria-hidden="true"></span>
                    </button>
            </form>

        </div>
    </div>

</section>

<script>
let resizedFiles = [];

function handleMultipleImages(event) {
    const files = event.target.files;
    const imagePreviewContainer = document.getElementById('image-preview-container');

    // Process each file one at a time (for reliability)
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            // Simple compression with reasonable defaults
            compressImage(file).then(compressedFile => {
                // Store the file
                resizedFiles.push(compressedFile);

                // Create and show preview
                displayImagePreview(compressedFile, imagePreviewContainer);

                console.log(
                    `Compressed ${file.name}: ${Math.round(file.size/1024)}KB → ${Math.round(compressedFile.size/1024)}KB`
                    );
            }).catch(error => {
                console.error("Error compressing image:", error);
                // Fall back to original file if compression fails
                resizedFiles.push(file);
                displayImagePreview(file, imagePreviewContainer);
            });
        }
    });
}

// Basic image compression function
function compressImage(file) {
    return new Promise((resolve, reject) => {
        try {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    let width = img.width;
                    let height = img.height;
                    const maxWidth = 1200;

                    if (width > maxWidth) {
                        height = Math.round(height * maxWidth / width);
                        width = maxWidth;
                    }

                    // Create canvas for resizing
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob(blob => {
                        const newFile = new File([blob], file.name, {
                            type: file.type,
                            lastModified: new Date().getTime()
                        });
                        resolve(newFile);
                    }, file.type, 0.7); // Use 0.7 quality for JPEG
                };
                img.onerror = function() {
                    reject(new Error("Failed to load image"));
                };
                img.src = event.target.result;
            };
            reader.onerror = function() {
                reject(new Error("Failed to read file"));
            };
            reader.readAsDataURL(file);
        } catch (e) {
            reject(e);
        }
    });
}

function displayImagePreview(file, container) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const previewContainer = document.createElement('div');
        previewContainer.className = 'preview-container';

        const img = document.createElement('img');
        img.src = e.target.result;
        img.style.maxWidth = '100px';
        img.style.height = 'auto';
        img.style.border = '1px solid #ccc';
        img.style.borderRadius = '5px';

        const removeButton = document.createElement('button');
        removeButton.textContent = '×';
        removeButton.className = 'remove-image';
        removeButton.onclick = function() {
            const index = resizedFiles.indexOf(file);
            if (index > -1) {
                resizedFiles.splice(index, 1);
            }
            previewContainer.remove();
        };

        previewContainer.appendChild(img);
        previewContainer.appendChild(removeButton);
        container.appendChild(previewContainer);
    };
    reader.readAsDataURL(file);
}

document.getElementById('submitForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    submitBtn.disabled = true;
    loadingSpinner.style.display = 'inline-block';
    progressContainer.style.display = 'block';

    const formData = new FormData(this);

    // Add compressed images from resizedFiles
    resizedFiles.forEach(file => {
        formData.append('images[]', file);
    });

    const xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    // Update progress bar during upload
    xhr.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            const percentComplete = Math.round((event.loaded / event.total) * 100);
            progressBar.style.width = percentComplete + '%';
            progressText.textContent = percentComplete + '%';
        }
    };

    // Handle completion
    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = '/my-listing'; 
        } else {
            alert('Upload failed!');
        }
        submitBtn.disabled = false;
        loadingSpinner.style.display = 'none';
        progressContainer.style.display = 'none';
    };

    // Handle errors
    xhr.onerror = function () {
        alert('An error occurred during upload.');
        submitBtn.disabled = false;
        loadingSpinner.style.display = 'none';
        progressContainer.style.display = 'none';
    };

    xhr.send(formData);
});

function handleFeatureImage(event) {
    const file = event.target.files[0];
    const uploadButton = document.getElementById('upload-button');
    const uploadIcon = document.getElementById('upload-icon');

    if (file) {
        // Compress the feature image
        compressImage(file).then(compressedFile => {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadButton.style.backgroundImage = `url(${e.target.result})`;
                uploadButton.style.backgroundSize = "cover";
                uploadButton.style.backgroundPosition = "center";
                uploadButton.style.backgroundRepeat = "no-repeat";

                uploadIcon.style.opacity = "0"; 
                uploadButton.querySelector("p").style.opacity = "0"; 
                uploadButton.querySelector("button").style.opacity = "0";

                const removeButton = document.createElement("button");
                removeButton.className = "remove-image btn btn-danger";
                removeButton.innerHTML = "Remove Image";
                removeButton.style.position = "absolute";
                removeButton.style.bottom = "10px";
                removeButton.style.right = "10px";

                removeButton.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation(); 
                    document.getElementById('feature-image').value = '';
                    uploadButton.style.backgroundImage = ""; 
                    uploadIcon.style.opacity = "1"; 
                    uploadButton.querySelector("p").style.opacity = "1"; 
                    uploadButton.querySelector("button").style.opacity = "1"; 
                    removeButton.remove(); 
                };
                
                let existingButton = uploadButton.querySelector(".remove-image");
                if (existingButton) existingButton.remove();

                uploadButton.appendChild(removeButton);
            };
            reader.readAsDataURL(compressedFile);

            // Replace the original file input with the compressed file
            const fileInput = document.getElementById('feature-image');
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.id = 'feature-image';
            newInput.name = 'feature_image';
            newInput.accept = 'image/*';
            newInput.style.display = 'none';
            newInput.onchange = handleFeatureImage;

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            newInput.files = dataTransfer.files;

            fileInput.parentNode.replaceChild(newInput, fileInput);
        }).catch(error => {
            console.error("Error compressing feature image:", error);
        });
    }
}

function handleMainImage(event) {
    const file = event.target.files[0];
    const uploadButton = document.querySelector('.main-upload-button');
    const uploadIcon = document.getElementById('main-upload-icon');

    if (file) {
        // Compress the main image
        compressImage(file).then(compressedFile => {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadButton.style.backgroundImage = `url(${e.target.result})`;
                uploadButton.style.backgroundSize = "cover";
                uploadButton.style.backgroundPosition = "center";
                uploadButton.style.backgroundRepeat = "no-repeat";
                uploadIcon.style.opacity = "0";
                uploadButton.querySelector("p").style.opacity = "0";
                uploadButton.querySelector("button").style.opacity = "0";
             
                const removeButton = document.createElement("button");
                removeButton.className = "remove-image btn btn-danger";
                removeButton.innerHTML = "Remove Image";
                removeButton.style.position = "absolute";
                removeButton.style.bottom = "10px";
                removeButton.style.right = "10px";

                removeButton.onclick = function(e) {
                    e.preventDefault(); 
                    e.stopPropagation();
                    document.getElementById('main-image').value = '';
                    uploadButton.style.backgroundImage = "";
                    uploadIcon.style.opacity = "1"; 
                    uploadButton.querySelector("p").style.opacity = "1"; 
                    uploadButton.querySelector("button").style.opacity = "1"; 
                    removeButton.remove(); 
                };

                let existingButton = uploadButton.querySelector(".remove-image");
                if (existingButton) existingButton.remove();

                uploadButton.appendChild(removeButton);
            };
            reader.readAsDataURL(compressedFile);

            // Replace the original file input with the compressed file
            const fileInput = document.getElementById('main-image');
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.id = 'main-image';
            newInput.name = 'main_image';
            newInput.accept = 'image/*';
            newInput.multiple = true;
            newInput.style.display = 'none';
            newInput.onchange = handleMainImage;

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            newInput.files = dataTransfer.files;

            fileInput.parentNode.replaceChild(newInput, fileInput);
        }).catch(error => {
            console.error("Error compressing main image:", error);
        });
    }
}
</script>
<style>
@media (max-width: 767px) {

    .mobilecontainer {
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
    }

    #mileage-container {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        /* Align items vertically */
        flex-wrap: nowrap !important;
        /* Prevent items from wrapping to the next line */
        gap: 10px;
        /* Add space between items */
        /* overflow: hidden;  */
        white-space: nowrap;
        /* Ensure text doesn't break into multiple lines */
        margin-bottom: 10px !important;
    }



    .mileage {
        margin-right: 0 !important;
        margin-bottom: 0px !important;
        margin-top: 0px !important;
    }

    .vehicle-specs {
        margin-bottom: 2px;
    }

    #mileage-value {
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
        padding-top: 0px !important;
    }

    #edit-mileage-btn {
        padding-top: 0px !important;
        padding-left: 0px !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
        margin-left: 0px !important;
    }

}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.getElementById('edit-mileage-btn');
    const mileageText = document.getElementById('mileage-text');
    const mileageValue = document.getElementById('mileage-value');

    let isEditing = false;

    editButton.addEventListener('click', () => {
        if (!isEditing) {
            // Start editing
            const currentMileage = mileageValue.textContent.trim();
            mileageText.innerHTML =
                `<input type="number" id="mileage-input" value="${currentMileage}" style="width: 80px;"> Miles`;
            editButton.textContent = 'Save Mileage';
            isEditing = true;
        } else {
            // Save new mileage
            const newMileage = document.getElementById('mileage-input').value.trim();
            mileageText.innerHTML = `<span id="mileage-value">${newMileage}</span> Miles`;
            editButton.textContent = 'Edit Mileage';
            isEditing = false;

            // Optional: Send updated mileage to the server via AJAX
            fetch('/update-mileage', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token if using Laravel
                    },
                    body: JSON.stringify({
                        miles: newMileage
                    })
                }).then(response => response.json())
                .then(data => {
                    console.log('Mileage updated:', data);
                }).catch(error => {
                    console.error('Error updating mileage:', error);
                });
        }
    });
});
</script>
<script>
// tinymce.init({
//     selector: '#description',
//     menubar: false,
//     height: 250,
//     toolbar: 'undo redo | formatselect | bold italic underline | link image | alignleft aligncenter alignright | bullist numlist outdent indent',
//     plugins: 'image link',
//     content_style: "body { background-color: #f5f6fa !important; border: none !important; border-radius: 10px !important;  }", // Set background and padding
//     setup: function(editor) {
//         editor.on('init', function() {
//             let container = editor.getContainer();
//             // container.style.border = "none"; // Remove border
//             container.style.borderRadius = "10px"; // Apply border radius
//             container.style.overflow = "hidden"; // Prevent content from overflowing rounded corners
//         });
//     }
// });
tinymce.init({
    selector: '#description',
    menubar: false,
    branding: false,
    height: 250,
    toolbar: 'undo redo | formatselect | bold italic underline | emoticons | alignleft aligncenter alignright | bullist numlist outdent indent',
    plugins: 'emoticons',
    content_style: `
        body { 
            background-color: #f5f6fa !important; 
            border: none !important; 
            border-radius: 10px !important;
            max-width: 100% !important;
       
        }
    `,
    mobile: {
        toolbar_mode: 'wrap',
        // Simplified mobile toolbar with most essential options
        toolbar: [
            'undo redo',
            'bold italic',
            'emoticons',
            'bullist numlist'
        ].join(' | '),
        max_width: '100%'
    },
    setup: function(editor) {
        editor.on('init', function() {
            let container = editor.getContainer();
            container.style.borderRadius = "10px";
            container.style.overflow = "hidden";
            container.style.maxWidth = "100%";
        });
    },
    width: '100%'
});
</script>





<script>
document.addEventListener('DOMContentLoaded', () => {
    const packageData = JSON.parse(localStorage.getItem('packageData'));
    const paymentId = localStorage.getItem('payment_id');

    if (paymentId) {
        document.getElementById('payment_id').value = paymentId;
    } else {
        console.log('Payment ID not found in localStorage.');
    }
    if (packageData) {
        console.log('Package Data:', packageData);

        if (typeof packageData.duration !== 'undefined') {
            document.getElementById('package_duration').value = packageData.duration;
            console.log('Package Duration:', packageData.duration);
        } else {
            console.log('Duration is missing in package data.');
        }
    } else {
        console.log('No package data found in localStorage.');
    }

    const form = document.getElementById('advertForm');
    form.addEventListener('submit', function(e) {
        if (!document.getElementById('payment_id').value || !document.getElementById('package_duration')
            .value) {
            e.preventDefault();
            alert('Payment ID or Package Duration is missing!');
        }
    });
});
function validatePrice(input) {
    if (input.value < 0) {
        input.value = 0; 
    }
}
</script>


@endsection