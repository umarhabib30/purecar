@extends('layout.superAdminDashboard')
@section('body')
<section id="add-blog-outer-container">
    <h1>Edit Event</h1>
    <form action="{{ route('event.update', $event->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div id="add-blog-inner-container">
            <!-- Title Input -->
            <div class="input-group">
                <label for="title">Heading <span class="text-danger">*</span></label>
                <input type="text" name="title" placeholder="Add a Title" value="{{ $event->title }}" required>
            </div>

            <!-- Event Description Input -->
            <div class="input-group">
                <label for="content">Event Description <span class="text-danger">*</span></label>
                <textarea name="content" id="summernote" required>{{ $event->content }}</textarea>
            </div>

            <div class="input-group">
                <label for="featured_image">Featured Image</label>
                <input type="file" name="featured_image" id="featured_image">
                <div id="featured_image_preview" class="image-preview-container">
                    @if($event->featured_image)
                        <div class="image-preview-item">
                            <img src="{{ asset($event->featured_image) }}" alt="Featured Image Preview">
                            <span class="remove-image" onclick="removeFeaturedImage()">×</span>
                        </div>
                    @endif
                </div>
            </div>


            <div class="input-group">
                <label for="gallery_images">Gallery Images</label>
                <input type="file" name="gallery_images[]" id="gallery_images" multiple>
                <div id="gallery_images_preview" class="image-preview-container">
                    @if($event->gallery_images)
                        @foreach($event->gallery_images as $image)
                            <div class="image-preview-item existing-image">
                                <img src="{{ asset($image) }}" alt="Gallery Image Preview">
                                <span class="remove-image" onclick="removeGalleryImage(this, '{{ $image }}')">×</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Update Button -->
            <div class="btn-container-add-blog">
                <button type="submit" class="btn-primary-1">Update</button>
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

        $('#featured_image').on('change', function() {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#featured_image_preview').html(`
                        <div class="image-preview-item">
                            <img src="${e.target.result}" alt="Featured Image Preview">
                            <span class="remove-image" onclick="removeFeaturedImage()">×</span>
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            }
        });

        $('#gallery_images').on('change', function() {
            let files = this.files;
            for (let i = 0; i < files.length; i++) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#gallery_images_preview').append(`
                        <div class="image-preview-item new-image">
                            <img src="${e.target.result}" alt="Gallery Image Preview">
                            <span class="remove-image" onclick="$(this).closest('.image-preview-item').remove()">×</span>
                        </div>
                    `);
                }
                reader.readAsDataURL(files[i]);
            }
        });

        window.removeFeaturedImage = function() {
            $('#featured_image').val('');
            $('#featured_image_preview').html('');
            $('<input>').attr({
                type: 'hidden',
                name: 'remove_featured_image',
                value: 'true'
            }).appendTo('form');
        }

        window.removeGalleryImage = function(element, imageSrc) {
            let $item = $(element).closest('.image-preview-item');
            if ($item.hasClass('existing-image')) {
                $.ajax({
                    url: '{{ route("event.removeGalleryImage", $event->id) }}',
                    method: 'POST',
                    data: {
                        imageSrc: imageSrc,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $item.remove();
                        } else {
                            alert('Failed to remove image.');
                        }
                    },
                    error: function() {
                        $item.remove();
                    }
                });
            } else {
                $item.remove();
            }
        }
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

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
