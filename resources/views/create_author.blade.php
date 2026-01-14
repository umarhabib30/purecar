@extends('layout.superAdminDashboard')
@section('body')
<section id="add-author-outer-container">
        <h1>{{ $title }}</h1>
    <form action="{{ route('author.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="add-author-inner-container">

            <div class="input-group-author">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" placeholder="Author Name" required>
            </div>

            <div id="author-editor-container">
                <label for="image">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" required>
            </div>
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
 @endsection
