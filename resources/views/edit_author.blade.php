@extends('layout.superAdminDashboard')
@section('body')
    <section id="add-author-outer-container">
        <h1>{{ $title }}</h1>
        <form action="{{ route('author.update', ['id' => $author->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="add-author-inner-container">
                <!-- Name Input -->
                <div class="input-group-author">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" placeholder="Author Name" required value="{{ $author->name }}">
                </div>

                <!-- Image Input with Preview -->
                <div class="input-group-author">
                    <label for="image">Image <span class="text-danger">*</span></label>
                    <div id="image-upload-container">
                        <label for="image-upload" id="image-upload-label">
                            <img id="image-preview" src="{{ asset('images/authors/' . $author->image) }}" alt="Author Image Preview">
                            <span id="upload-text">Click to upload image</span>
                        </label>
                        <input type="file" name="image" id="image-upload" accept="image/*" required>
                    </div>
                </div>

                <!-- Save Button -->
                <div id="btn-container-author">
                    <button type="submit" id="save-btn">Save</button>
                </div>
            </div>
        </form>
    </section>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        #add-author-outer-container {
            padding: 32px;
            background-color: #F5F6FA;
        }
        #add-author-outer-container h1 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 24px;
            text-align: center;
        }
        #add-author-inner-container {
            background-color: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .input-group-author {
            margin-bottom: 24px;
        }
        .input-group-author label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        .input-group-author input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        .input-group-author input[type="text"]:focus {
            border-color: #007bff;
        }
        #image-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        #image-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }
        #image-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px dashed #ddd;
            padding: 8px;
            transition: border-color 0.3s ease;
        }
        #image-upload-label:hover #image-preview {
            border-color: #007bff;
        }
        #upload-text {
            font-size: 14px;
            color: #007bff;
            margin-top: 8px;
        }
        #image-upload {
            display: none;
        }
        #btn-container-author {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }
        #save-btn {
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        @media (max-width: 768px) {
            #add-author-outer-container {
                padding: 16px;
            }
            #add-author-inner-container {
                padding: 16px;
            }
        }
    </style>

    <script>
        document.getElementById('image-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
