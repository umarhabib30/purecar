
@extends('layout.superAdminDashboard')
@section('body')

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
<link rel="stylesheet" href="{{asset('css/SubmitAdvertPage2.css')}}">
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<section>
    <style>
    .advert-submit-button {
        display: flex;
        justify-content: end;
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
   

    #img-container h2 {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 16px;
        display: block;
    }

    @media screen and (min-width: 767px) {
        .edit-advert-container {
            background-color: #F5F6FA;
            padding: 18px;
        }

        .top-form-box {
            display: flex;
            margin-bottom: 10px;
            gap: 24px;
        }

        .top-form-box-1 {
            width: 50%
        }

        .top-form-box-2 {
            width: 50%
        }
    }

    @media screen and (max-width: 767px) {
        .outer-container {
            background: white !important;
        }

        .edit-advert-container {
            background-color: #F5F6FA;
            padding: 8px;
        }

        .top-form-box {
            display: flex;
            flex-direction: column;
        }

        .top-form-box-1 {
            width: 100%
        }

        .top-form-box-2 {
            width: 100%
        }
    }

    .detail-row {
        background-color: white;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        border-radius: 12.63px;
    }

    .detail-row p {
        margin: 0px;
        padding: 0px;
        color: #848B9D;
    }

    .detail-row input {
        padding: 4px;
    }

    #inner-container {
        padding: 20px;
        margin-left: 30px;
        margin-right: 30px;
        margin-bottom: 30px;

    }

    .outer-container h1 {
        padding-top: 20px;
        padding-bottom: 0px;
        padding-left: 30px;
        font-size: 28px;
        font-weight: 600;
    }

    .detail-row {
        border-bottom: 1px solid #F2F2F2
    }
    </style>
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

        #inner-container {
            padding: 0px !important;
            margin-left: 10px !important;
            margin-right: 10px !important;
            margin-bottom: 10px !important;
            margin-top: 0px !important;
        }

    }
    </style>
    <div class="outer-container " style="background: #f5f6fa; padding-bottom: 15px;">
        <h1 class="d-none d-md-block">Edit Advert</h1>
        <div id="inner-container">
            <form action="{{ route('adverts.update', $advert->advert_id) }}" method="POST" enctype="multipart/form-data"
                id="editAdvertForm" onsubmit="tinymce.triggerSave();">
                @csrf
                @method('PUT')

                <div class="container">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-12 col-md-6 d-flex flex-column">
                            <h6 class="fw-bold mt-4 mobilecontainer">
                                {{ $advert->car->make }} {{ $advert->car->model }}
                                ({{ $advert->car->year }})
                            </h6>
                            <p class="mobilecontainer">
                                {{ $advert->car->engine_size }} {{ $advert->car->Trim }}
                                {{ $advert->car->fuel_type }}
                                {{ $advert->car->gear_box }}
                            </p>
                        </div>

                        <!-- Mileage Information (Right) -->
                        <div
                            class="col-12 col-md-6 d-flex flex-column align-items-md-end align-items-start text-md-end text-start">
                            <div id="mileage-container" class="d-flex flex-column align-items-start align-items-md-end">
                                <div id="mileage" class="d-flex align-items-center">
                                    <!-- <img src="{{ asset('assets/mileage.png') }}" alt="Mileage Icon" class="me-2"> -->
                                    <p id="mileage-text" class="mb-0 fw-bold">
                                        <span id="mileage-value">{{ number_format($advert->car->miles) }}</span>
                                        Miles
                                    </p>
                                    <input type="number" id="mileage-input" class="form-control d-none ms-2"
                                        value="{{ $advert->car->miles }}" />
                                </div>
                                <a id="edit-mileage-btn" href="javascript:void(0);" class="ms-2  text-dark">Edit
                                    Mileage</a>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 d-md-none mb-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#carDetails">
                        Show Car Details
                    </button>
                    <div class="collapse d-md-block" id="carDetails">
                        <div class="top-form-box">
                            <div class="top-form-box-1">
                                <div class="detail-row">
                                    <p class="detail-heading">Fuel Type</p>
                                    <p class="border-0 detail text-end" type="text" name="fuel_type">
                                        {{ $advert->car->fuel_type }}</p>
                                </div>
                                <div class="detail-row">
                                    <p class="detail-heading">Body type</p>
                                    <p class="border-0 detail text-end" type="text" name="bodystyle">
                                        {{ $advert->car->body_type }}</p>
                                </div>
                                <div class="detail-row">
                                    <p class="detail-heading">Engine</p>
                                    <p class="border-0 detail text-end" type="text" name="engine">
                                        {{ $advert->car->engine_size }}</p>
                                </div>
                            </div>
                            <div class="top-form-box-2">
                                <div class="detail-row">
                                    <p class="detail-heading">Gearbox</p>
                                    <p class="border-0 detail text-end" type="text" name="Gearbox">
                                        {{ $advert->car->gear_box }}</p>
                                </div>
                                <div class="detail-row">
                                    <p class="detail-heading">Doors</p>
                                    <p class="border-0 detail text-end" type="text" name="door">
                                        {{ $advert->car->doors }}</p>
                                </div>
                                <div class="detail-row">
                                    <p class="detail-heading">Seats</p>
                                    <p class="border-0 detail text-end" type="text" name="seats">
                                        {{ $advert->car->seats }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Price -->
                    <div class="form-group position-relative">
                        <label for="price" class="h5">Price or add 0 for POA</label>
                        <div class="position-relative">
                            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">£</span>
                            <input type="number" id="price" placeholder="" name="price" class="form-control ps-4"
                                value="{{ old('price', $advert->car->price) }}" required placeholder=""
                                style="background: #f5f6fa; padding-left: 30px;"
                                min="0" 
                                oninput="validatePrice(this)" 
                                onpaste="return false;">
                        </div>
                    </div>



                    <!-- Miles -->
                    <input type="hidden" id="miles" name="miles" value="{{ old('miles', $advert->car->miles) }}">

                    <!-- Description -->
                    <div class="form-group pt-2">
                        <label for="description" class="h5">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4"
                            placeholder="Enter the description of the advert">{!! old('description', $advert->description) !!}</textarea>
                    </div>
                    <div class="row mt-4">

                    <div class="col-12 col-md-6 mb-4">
    <div id="img-container" class="p-3 bg-light rounded">
        <div class="p-row">
            <h2>Thumbnail Image</h2>

            <div id="upload-button" class="position-relative"
                style="cursor: pointer; margin-top: 20px; margin-bottom: 20px; width:100%;"
                onclick="event.preventDefault(); document.getElementById('feature-image').click()">
                <img src="{{ asset('assets/upload_icon.png') }}" alt="Upload Images"
                    id="upload-icon" class="mb-4 mt-4" style="width: 50px;">
                <p>Drag your file(s) to start uploading</p>                        
            </div>
            @error('feature_image')
            <div class="text-danger">{{$message}}</div>
            @enderror
            <input type="file" id="feature-image" name="feature_image" accept="image/*"
                style="display: none;" onchange="handleFeatureImage(event)">
        </div>
        <div class="mt-3 featured-image-container">
            @if ($advert->image)
            <div class="preview-container">
                <img src="{{ url($advert->image) }}" alt="Featured Image">
            </div>
            @else
            <p>No featured image available</p>
            @endif
        </div>
        <div id="feature-image-preview-container" class="image-preview-grid"></div>
    </div>
</div>

<div class="col-12 col-md-6 mb-4">
    <div id="img-container" class="p-3 bg-light rounded">
        <div class="p-row">
            <h2>Main Image</h2>

            <div id="upload-button" class="main-upload-button position-relative"
                style="cursor: pointer; margin-top: 20px; margin-bottom: 20px; width:100%;"
                onclick="event.preventDefault(); document.getElementById('main-image').click()">
                <img src="{{ asset('assets/upload_icon.png') }}" alt="Upload Images"
                    id="main-upload-icon" class="mb-4 mt-4" style="width: 50px;">
                <p>Drag your file(s) to start uploading</p>
                
              
            </div>
            @error('main_image')
            <div class="text-danger">{{$message}}</div>
            @enderror
            <input type="file" id="main-image" name="main_image" accept="image/*"
                style="display: none;" onchange="handleMainImage(event)">
        </div>
        <div class="mt-3 featured-image-container">
            @if ($advert->main_image)
            <div class="preview-container">
                <img src="{{ url($advert->main_image) }}" alt="mainImage">
            </div>
            @else
            <p>No main image available</p>
            @endif
        </div>
        <div id="main-image-preview-container" class="image-preview-grid"></div>
    </div>
</div>
                        </div>

                        <div class="col-12 col-md-12 mb-4">
                            <div id="img-container" class="p-3 bg-light rounded">
                                <div class="p-row">
                                    <h2>Gallery Images</h2>
                                    <div id="upload-button"
                                        style="cursor: pointer; margin-top: 20px; margin-bottom: 20px; width:100%;"
                                        onclick="document.getElementById('images').click()">
                                        <img src="{{ asset('assets/upload_icon.png') }}" alt="Upload Images"
                                            id="upload-icon" class="mb-4 mt-4" style="width: 50px;">
                                        <p>Drag your file(s) to start uploading</p>
                                       
                                       
                                    </div>
                                    <div>
                                        <input type="file" id="images" name="images[]" class="form-control"
                                            accept="image/*" multiple style="display: none;"
                                            onchange="handleMultipleImages(event)">

                                        <div id="existing-images-container" class="mt-3 image-preview-grid">
                                            @foreach ($advert->images as $image)
                                            <div class="preview-container" data-image-id="{{ $image->image_id }}">
                                                <img src="{{ url($image->image_url) }}" alt="Existing Image">
                                                <button type="button" class="remove-image"
                                                    data-image-id="{{ $image->image_id }}">×</button>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div id="image-preview-container" class="mt-3 image-preview-grid"></div>
                                        @error('images.*')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="pt-2" id="progressContainer" style="display: none; text-align: center;">
                                    <div
                                        style="width: 100%; background-color: #e0e0e0; border-radius: 8px; position: relative;">
                                        <div id="progressBar"
                                            style="width: 0%; height: 20px; background-color: #4A90E2; border-radius: 8px; position: relative; text-align: center; line-height: 20px; color: white; font-weight: bold;">
                                            <span id="progressText"
                                                style="position: absolute; width: 100%; left: 0; top: 0;">0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="mt-4 advert-submit-button">
                            <button type="submit" class="custom-btn">Update Advert</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</section>

<script>
let resizedFiles = [];

function handleMultipleImages(event) {
    const files = event.target.files;
    const imagePreviewContainer = document.getElementById('image-preview-container');
    // imagePreviewContainer.innerHTML = ''; 
    // resizedFiles = []; 

    const resizePromises = [];

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (file.type.startsWith('image/')) {
            resizePromises.push(resizeImage(file, 0.7, 800).then(resizedFile => {
                resizedFiles.push(resizedFile);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.createElement('div');
                    previewContainer.classList.add('preview-container');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.height = 'auto';
                    img.style.border = '1px solid #ccc';
                    img.style.borderRadius = '5px';

                    const removeButton = document.createElement('button');
                    removeButton.textContent = '×';
                    removeButton.classList.add('remove-image');
                    removeButton.addEventListener('click', function() {
                        const index = resizedFiles.indexOf(resizedFile);
                        if (index > -1) {
                            resizedFiles.splice(index, 1);
                        }
                        previewContainer.remove();
                    });

                    previewContainer.appendChild(img);
                    previewContainer.appendChild(removeButton);
                    imagePreviewContainer.appendChild(previewContainer);
                }
                reader.readAsDataURL(resizedFile);
            }));
        }
    }

    Promise.all(resizePromises).then(() => {

        console.log('All images resized and ready.');
    });
}

function resizeImage(file, quality, maxWidth) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => {
            let width = img.width;
            let height = img.height;

            if (width > maxWidth) {
                height *= maxWidth / width;
                width = maxWidth;
            }

            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);

            canvas.toBlob(blob => {
                const resizedFile = new File([blob], file.name, {
                    type: file.type,
                    lastModified: file.lastModified
                });
                resolve(resizedFile);
            }, file.type, quality);
        };
        img.onerror = reject;

        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

document.getElementById('editAdvertForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let progressContainer = document.getElementById('progressContainer');
    let progressBar = document.getElementById('progressBar');
    let progressText = document.getElementById('progressText');

    progressContainer.style.display = 'block';
    progressBar.style.width = '0%';
    progressText.innerText = '0%';


    const formData = new FormData();

    // Add all other form fields manually
    const formElements = this.elements;
    for (let i = 0; i < formElements.length; i++) {
        const element = formElements[i];
        if (element.name && element.name !== 'images[]') {
            if (element.type === 'checkbox') {
                if (element.checked) {
                    formData.append(element.name, element.value);
                }
            } else if (element.type === 'radio') {
                if (element.checked) {
                    formData.append(element.name, element.value);
                }
            } else if (element.type === 'file') {
                // Skip file inputs - we'll handle resizedFiles separately
            } else {
                formData.append(element.name, element.value);
            }
        }
    }

    // Add only the resized files
    for (let i = 0; i < resizedFiles.length; i++) {
        formData.append('images[]', resizedFiles[i]);
    }
    const featureImageInput = document.getElementById('feature-image');
    if (featureImageInput.files.length > 0) {
        formData.append('feature_image', featureImageInput.files[0]);
    }
    const mainImageInput = document.getElementById('main-image');
    if (mainImageInput.files.length > 0) {
        formData.append('main_image', mainImageInput.files[0]);
    }

  
    $.ajax({
        url: this.action,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        xhr: function() {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    let percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    progressBar.style.width = percentComplete + '%';
                    progressText.innerText = percentComplete + '%';
                }
            }, false);
            return xhr;
        },
        success: function(response) {
            console.log('Upload successful', response);
           
            window.location.href = '/list-ads';
        },
        error: function(xhr, status, error) {
            console.error('Upload failed', xhr, status, error);
   
        },
        complete: function() {
            progressContainer.style.display = 'none';
        }
    });
});

document.getElementById('images').addEventListener('change', function() {
  
    let progressContainer = document.getElementById('progressContainer');
    let progressBar = document.getElementById('progressBar');
    let progressText = document.getElementById('progressText');

    progressContainer.style.display = 'block';
    progressBar.style.width = '0%';
    progressText.innerText = '0%';

    let files = this.files;
    if (files.length > 0) {
        let progress = 0;
        let interval = setInterval(() => {
            if (progress >= 100) {
                clearInterval(interval);
                progressContainer.style.display = 'none';
            } else {
                progress += 10;
                progressBar.style.width = progress + '%';
                progressText.innerText = progress + '%';
            }
        }, 200);
    }
});

// Add event listeners for existing image delete buttons
document.addEventListener('DOMContentLoaded', function() {
    const existingRemoveButtons = document.querySelectorAll('#existing-images-container .remove-image');
    existingRemoveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            const container = this.closest('.preview-container');

            // Add the image ID to a hidden input to be processed by the server
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_images[]';
            hiddenInput.value = imageId;
            document.getElementById('editAdvertForm').appendChild(hiddenInput);

            // Remove the preview from the UI
            container.remove();
        });
    });
});

function handleFeatureImage(event) {
    const file = event.target.files[0];
    const uploadButton = document.getElementById('upload-button');
    const uploadIcon = document.getElementById('upload-icon');

    if (file) {
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
        reader.readAsDataURL(file);
    }
}


function handleMainImage(event) {
    const file = event.target.files[0];
    const uploadButton = document.querySelector('.main-upload-button');
    const uploadIcon = document.getElementById('main-upload-icon');

    if (file) {
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
        reader.readAsDataURL(file);
    }
}
</script>

<style>
.image-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(162px, 1fr));
    gap: 10px;
    margin-top: 20px;
}

@media screen and (max-width: 767px) {
    .image-preview-grid {
      
        grid-template-columns: repeat(2, 1fr);
    
        gap: 8px;
        
    }

    .preview-container {
     
        width: 132px !important;
        height: 132px !important;
        aspect-ratio: 1/1;
     
    }

    .preview-container img {
      
        max-width: 100px !important;
        height: 100% !important;
    }
}


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
</style>

<script>
document.querySelector('#existing-images-container').addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('remove-image')) {
        const imageId = event.target.getAttribute('data-image-id');
        deleteExistingImage(imageId);
    }
});

function deleteExistingImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        console.log('Attempting to delete image ID:', imageId);

        fetch(`/delete-image/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(`Image ${imageId} deleted successfully.`);

          
                    const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
                    if (imageElement) {
                        imageElement.remove();
                    } else {
                        console.error('Image element not found in DOM.');
                    }
                } else {
                    console.error('Server error:', data.message);
                    alert(data.message || 'Failed to delete image.');
                }
            })
            .catch((error) => {
                console.error('Error deleting image:', error);
                alert('Failed to delete image.');
            });
    }
}




tinymce.init({
    selector: '#description',
    menubar: false,
    branding: false,
    height: 250,
    toolbar: 'undo redo | formatselect | bold italic underline | emoticons | alignleft aligncenter alignright | bullist numlist outdent indent',
    plugins: 'emoticons',
    content_style: "body { background-color: #f5f6fa !important; border: none !important; border-radius: 10px !important;  }", // Set background and padding
    setup: function(editor) {
        editor.on('init', function() {
            let container = editor.getContainer();
          
            container.style.borderRadius = "10px"; 
            container.style.overflow = "hidden"; 
        });
    }
});
</script>

<script>

let uploadedFiles = [];



function removeImage(index) {
    // Remove file from array
    uploadedFiles.splice(index, 1);

    // Refresh all previews
    const previewContainer = document.getElementById('image-preview-container');
    previewContainer.innerHTML = '';

    uploadedFiles.forEach((file, idx) => {
        const reader = new FileReader();
        const previewDiv = document.createElement('div');
        previewDiv.className = 'preview-container';
        previewDiv.dataset.index = idx;

        reader.onload = function(e) {
            previewDiv.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-image" onclick="removeImage(${idx})">&times;</button>
            `;
        };

        reader.readAsDataURL(file);
        previewContainer.appendChild(previewDiv);
    });

   
    updateFileInput();
}

function updateFileInput() {
    const input = document.getElementById('images');
    const dataTransfer = new DataTransfer();

    uploadedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });

    input.files = dataTransfer.files;
}


document.getElementById('upload-button').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = '#999';
});

document.getElementById('upload-button').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.style.borderColor = '#ccc';
});

document.getElementById('upload-button').addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = '#ccc';

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const event = {
            target: {
                files: files
            }
        };
        handleMultipleImages(event);
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $("#edit-mileage-btn").click(function() {

        $("#mileage-text").addClass("d-none");
        $("#mileage-input").removeClass("d-none").focus();
    });

    $("#mileage-input").blur(function() {
        let newMileage = $(this).val().replace(/\D/g, ''); 
        if (newMileage !== "") {

            let formattedMileage = new Intl.NumberFormat().format(newMileage);


            $("#mileage-value").text(formattedMileage);


            $("#miles").val(newMileage);


            $(this).val(newMileage);
        }
       
        $(this).addClass("d-none");
        $("#mileage-text").removeClass("d-none");
    });
});

function validatePrice(input) {
    if (input.value < 0) {
        input.value = 0; 
    }
}
</script>



@endsection