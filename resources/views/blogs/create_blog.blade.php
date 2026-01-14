@extends('layout.superAdminDashboard')
@section('body')
<section id="add-blog-outer-container">
    <h1>Post a Blog</h1>
    <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="add-blog-inner-container">
            <!-- Category Input -->
            <div class="input-group">
                <label for="category_id">Category <span class="text-danger">*</span></label>
                <select name="category_id" >
                    @foreach($blog_categories as $blog_category)
                        <option value="{{ $blog_category->id }}">{{ $blog_category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tags Input -->
            <div class="input-group">
                <label for="tags">Tags <span class="text-danger">*</span></label>
                <select name="tags[]" multiple >
                    @foreach($blog_tags as $blog_tag)
                        <option value="{{ $blog_tag->name }}">{{ $blog_tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Author Input -->
            <div class="input-group">
                <label for="author_id">Author <span class="text-danger">*</span></label>
                <select name="author_id" >
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Title Input -->
            <div class="input-group">
                <label for="title">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" placeholder="Add a Title" >
            </div>

            <!-- Blog Content Input -->
            <div class="input-group">
                <label for="content">Blog Contents <span class="text-danger">*</span></label>
                <textarea name="content" id="summernote" ></textarea>
            </div>

            <!-- Featured Image Input -->
            <div class="input-group">
                <label for="featured_image">Featured Image <span class="text-danger">*</span></label>
                <input type="file" name="featured_image" required>
            </div>

            <!-- Save Button -->
            <div class="btn-container-add-blog">
                <button type="submit" class="btn-primary-1">Save</button>
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
            ['fontsize', ['fontsize']],  // Font size selection
            ['color', ['forecolor', 'backcolor']],  // Color selection
            ['para', ['ul', 'ol', 'paragraph']], 
            ['height', ['height']],
            ['table', ['table']], 
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
        fontsizeUnits: ['px', 'pt'], // Fixes font size issue

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

    $(document).on('shown.bs.modal', function() {
        $('body').addClass('modal-open');
    });
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

    /* Summernote Editor Customization */
    .note-editor.note-frame {
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .note-editor.note-frame .note-toolbar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        border-radius: 8px 8px 0 0;
    }

    .note-editor.note-frame .note-statusbar {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        border-radius: 0 0 8px 8px;
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
