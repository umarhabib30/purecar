@extends('layout.superAdminDashboard')
@section('body')
<section id="add-blog-outer-container">
    <h1>Edit Blog</h1>
    <form action="{{ route('blog.update', ['id' => $blog->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="add-blog-inner-container">
            <!-- Category Input -->
            <div class="input-group">
                <label for="category_id">Category <span class="text-danger">*</span></label>
                <select name="category_id" >
                    @foreach($blog_categories as $blog_category)
                        <option value="{{ $blog_category->id }}" @selected($blog_category->id == $blog->category_id)>{{ $blog_category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tags Input -->
            <div class="input-group">
                <label for="tags">Tags <span class="text-danger">*</span></label>
                <select name="tags[]" multiple >
                    @foreach($blog_tags as $blog_tag)
                        <option value="{{ $blog_tag->name }}" @if(in_array($blog_tag->name, explode(',', $blog->tags))) selected @endif>
                            {{ $blog_tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Author Input -->
            <div class="input-group">
                <label for="author_id">Author <span class="text-danger">*</span></label>
                <select name="author_id" >
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" @selected($blog->author_id == $author->id)>{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Title Input -->
            <div class="input-group">
                <label for="title">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ $blog->title }}" placeholder="Add a Title" >
            </div>

            <!-- Content Input -->
            <div class="input-group">
                <label for="content">Blog Contents <span class="text-danger">*</span></label>
                <textarea name="content" id="summernote" >{{ $blog->content }}</textarea>
            </div>

            <!-- Featured Image Input -->
            <div class="input-group">
                <label for="featured_image">Featured Image</label>
                <input type="file" name="featured_image" class="form-control-file">
            </div>

            <!-- Save Button -->
            <div class="btn-container-add-blog">
                <button type="submit" class="btn-primary-1">Update</button>
            </div>
        </div>
    </form>

    <!-- Comments Table -->
    <!-- <div class="mt-4 table-container">
        <h2>Comments</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sn.</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blog->blogComments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $comment['comment'] }}</td>
                        <td>
                            <a href="{{ route('comment.delete', ['comment' => $comment->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> -->
</section>

<!-- Include Required CSS & JS -->
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
    .note-editor .modal {
    z-index: 1050 !important;
}
.modal-backdrop {
    z-index: 1040 !important;
}

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    #add-blog-outer-container {
        padding: 20px;
        background-color: #F5F6FA;
    }
    h1 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }
    #add-blog-inner-container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .input-group {
        margin-bottom: 20px;
        display: block;
    }
    .input-group label {
        display: block;
        margin-top: 5px;
        margin-right: 10px;
        font-weight: bold;
        color: #333;
    }
    .input-group input, .input-group select, .input-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    .input-group textarea {
        resize: vertical;
    }
    .btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }
    .btn-primary {
        background-color: black;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
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
    .table-container {
        margin-top: 30px;
    }
    .table-container h2 {
        font-size: 20px;
        margin-bottom: 15px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }
    .table th {
        background-color: black;
        color: white;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 3px;
        cursor: pointer;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    @media (max-width: 768px) {
        .btn-container {
            justify-content: center;
        }
        .table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>
@endsection
