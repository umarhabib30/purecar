@extends('layout.superAdminDashboard')
@section('body')
<section id="add-blog-outer-container">
    <h1>Post an Event</h1>
    <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data" id="eventForm">
        @csrf
        <div id="add-blog-inner-container">
            <!-- Heading -->
            <div class="input-group">
                <label for="title">Heading <span class="text-danger">*</span></label>
                <input type="text" name="title" placeholder="Add a Title" required>
            </div>

            <!-- Event Description -->
            <div class="input-group">
                <label for="content">Event Description <span class="text-danger">*</span></label>
                <textarea name="content" id="summernote" required></textarea>
            </div>

            <!-- Featured Image  -->
            <div class="input-group">
                <label for="featured_image">Featured Image <span class="text-danger">*</span></label>
                <input type="file" name="featured_image" id="featured_image" accept="image/*" required>
                <div id="featured_image_preview" class="image-preview-container"></div>
            </div>

            <!-- Gallery Images -->
            <div class="input-group">
                <label for="gallery_images">Gallery <span class="text-danger">*</span></label>
                <input type="file" name="gallery_images[]" id="gallery_images" multiple accept="image/*" required>
                <div id="gallery_images_preview" class="image-preview-container"></div>
            </div>

            <!-- Save Button -->
            <div class="btn-container-add-blog">
                <button type="submit" class="btn-primary-1" id="saveButton">Save</button>
            </div>
        </div>
    </form>
</section>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
$(document).ready(function() {
    let existingGalleryFiles = [];

 
    $('#summernote').summernote({
        height: 300,
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            ['style', ['style']],  
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],  
            ['color', ['forecolor', 'backcolor']], 
            ['para', ['ul', 'ol', 'paragraph']], 
            ['height', ['height']],
            ['table', ['table']], 
            ['view', ['fullscreen']]
        ],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
        fontsizeUnits: ['px', 'pt'],
        callbacks: {
            onImageUpload: function(files) {
                let data = new FormData();
                data.append('file', files[0]);

                $.ajax({
                    url: "{{ route('upload.image') }}",
                    method: "POST",
                    data: data,
                    contentType: false,
                    processData: false,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        let imgNode = $('<img>').attr('src', response.url);
                        $('#summernote').summernote('insertNode', imgNode[0]);
                    },
                    error: function() {
                        alert('Image upload failed');
                    }
                });
            }
        }
    });

    function compressAndConvertToWebP(file, quality = 0.8, maxWidth = 1920) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;
                
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;

                    if (width > maxWidth) {
                        height = Math.round((height * maxWidth) / width);
                        width = maxWidth;
                    }                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        resolve(new File([blob], file.name.replace(/\..+$/, '.webp'), {
                            type: 'image/webp',
                            lastModified: Date.now()
                        }));
                    }, 'image/webp', quality);
                };
            };
            reader.readAsDataURL(file);
        });
    }


    $('#featured_image').on('change', async function() {
        const file = this.files[0];
        if (file) {
            const processedFile = await compressAndConvertToWebP(file);
           
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(processedFile);
            this.files = dataTransfer.files;

            const reader = new FileReader();
            reader.onload = (e) => {
                $('#featured_image_preview').html(`
                    <div class="image-preview-item">
                        <img src="${e.target.result}" alt="Featured Image Preview">
                        <span class="remove-image" onclick="removeFeaturedImage()">×</span>
                    </div>
                `);
            };
            reader.readAsDataURL(processedFile);
        }
    });


    $('#gallery_images').on('change', async function() {
        const files = Array.from(this.files);
        const processedFiles = await Promise.all(
            files.map(file => compressAndConvertToWebP(file))
        );
        
        existingGalleryFiles = existingGalleryFiles.concat(processedFiles);
        const dataTransfer = new DataTransfer();
        existingGalleryFiles.forEach(file => dataTransfer.items.add(file));
        this.files = dataTransfer.files;


        $('#gallery_images_preview').html('');
        existingGalleryFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                $('#gallery_images_preview').append(`
                    <div class="image-preview-item">
                        <img src="${e.target.result}" alt="Gallery Image Preview">
                        <span class="remove-image" onclick="removeGalleryImage(${index})">×</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });


    window.removeFeaturedImage = function() {
        $('#featured_image').val('');
        $('#featured_image_preview').html('');
    }

   
    window.removeGalleryImage = function(index) {
        existingGalleryFiles.splice(index, 1); // Remove the file from the array

 
        let dataTransfer = new DataTransfer();
        existingGalleryFiles.forEach(file => dataTransfer.items.add(file));
        $('#gallery_images')[0].files = dataTransfer.files;

      
        $('#gallery_images_preview').html('');
        existingGalleryFiles.forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#gallery_images_preview').append(`
                    <div class="image-preview-item">
                        <img src="${e.target.result}" alt="Gallery Image Preview">
                        <span class="remove-image" onclick="removeGalleryImage(${index})">×</span>
                    </div>
                `);
            }
            reader.readAsDataURL(file);
        });
    }

    $('#eventForm').on('submit', async function(e) {
        e.preventDefault(); 


        var saveButton = $('#saveButton');
        saveButton.prop('disabled', true).text('Saving...');


        $('html, body').animate({
            scrollTop: saveButton.offset().top -200
        }, 'slow');


        const galleryInput = document.getElementById('gallery_images');
        const galleryFiles = Array.from(galleryInput.files);

        const processedGalleryFiles = await Promise.all(
            galleryFiles.map(file => compressAndConvertToWebP(file))
        );

        const featuredImageInput = document.getElementById('featured_image');
        let featuredImageFile = featuredImageInput.files[0];
        const processedFeaturedImage = await compressAndConvertToWebP(featuredImageFile);

        const dataTransferGallery = new DataTransfer();
        processedGalleryFiles.forEach(file => dataTransferGallery.items.add(file));

        const dataTransferFeatured = new DataTransfer();
        dataTransferFeatured.items.add(processedFeaturedImage);

        galleryInput.files = dataTransferGallery.files;
        featuredImageInput.files = dataTransferFeatured.files;

      
        const formData = new FormData(this);

 
        $.ajax({
            url: "{{ route('event.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                window.location.href = "{{ route('event.index') }}";
            },
            error: function(xhr, status, error) {
                alert('There was an error saving the event');
                console.log(xhr.responseText);
                 
                saveButton.prop('disabled', false).text('Save');
            }
        });
    });
});
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;0,700;0,800;0,900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .note-editor .modal {
        z-index: 1050 !important;
    }

    .modal-backdrop {
        z-index: 1040 !important;
    }

    #add-blog-outer-container {
        font-family: 'Poppins', sans-serif;
        padding: 32px;
        background-color: #F5F6FA;
    }

    #add-blog-outer-container h1 {
        font-weight: 600;
        font-size: 28px;
        margin-bottom: 24px;
        text-align: center;
    }

    #add-blog-inner-container {
        background-color: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .input-group {
        margin-bottom: 24px;
        display: block;
    }

    .input-group label {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-top: 8px;
        margin-right: 10px;
        display: block;
    }

    .input-group input,
    .input-group select,
    .input-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Manrope', sans-serif;
    }

    .input-group textarea {
        resize: vertical;
    }

    .input-group input::placeholder {
        color: #a1a1a1;
    }

    .btn-container-add-blog {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 32px;
    }

    .btn-primary-1 {
        background-color: black;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 8px;
        max-width: 200px;
        min-width: 200px;
        color: #fff;
        cursor: pointer;
    }

    /* Image Preview Container */
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview-item {
        position: relative;
        width: 100px;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview-item .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
    }

    .image-preview-item .remove-image:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    @media (max-width: 768px) {
        #add-blog-outer-container {
            padding: 16px;
        }

        #add-blog-inner-container {
            padding: 16px;
        }

        .btn-container {
            justify-content: center;
        }
    }
</style>
@endsection
