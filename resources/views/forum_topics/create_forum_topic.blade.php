@extends('layout.superAdminDashboard')
@section('body')
<section id="add-post-forum-outer-container">
    <h1>{{ $title }}</h1>
    <form action="{{ route('forum-topic.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="add-post-forum-inner-container">
            <h2>Add Post Title, Image, and Relevant Categories</h2>
            <div class="input-group-forum">
                <label for="title">Title</label>
                <input type="text" name="title" placeholder="Add a Title">
            </div>
            <div class="input-group-forum" id="categories-container">
                <label for="categories">Categories</label>
                <div class="category-input-group">
                    <input type="text" name="categories[0][name]" placeholder="Add a Category">
                    <input type="file" name="categories[0][image]" accept="image/*">
                </div>
            </div>
            <button type="button" id="new-category" class="btn btn-dark">+ Add</button>
            <div id="btn-container-forum">
                <button id="cancel-btn" type="button">Cancel</button>
                <button type="submit" id="save-btn">Save</button>
            </div>
        </div>
    </form>
</section>
<script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        document.getElementById("new-category").addEventListener("click", function () {
            const container = document.getElementById("categories-container");
            const lastInputGroup = container.querySelector(".category-input-group:last-of-type");
            if (lastInputGroup) {
                const newInputGroup = lastInputGroup.cloneNode(true);
                const index = container.querySelectorAll(".category-input-group").length;
                newInputGroup.querySelector('input[type="text"]').name = `categories[${index}][name]`;
                newInputGroup.querySelector('input[type="file"]').name = `categories[${index}][image]`;
                newInputGroup.querySelector('input[type="text"]').value = "";
                container.appendChild(newInputGroup);
            }
        });
    </script>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f5f5f5;
    }
    #add-post-forum-outer-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    h1, h2 {
        text-align: center;
        color: #333;
    }
    .input-group-forum {
        margin-bottom: 15px;
    }
    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    input[type="text"], input[type="file"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .category-input-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 10px;
    }
    .btn {
        display: block;
        width: 100%;
        padding: 10px;
        background: gray;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn:hover {
        background: gray;
        color: white
    }
    #btn-container-forum {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    #cancel-btn, #save-btn {
        width: 48%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #cancel-btn {
        background: #dc3545;
        color: white;
    }
    #cancel-btn:hover {
        background: #c82333;
    }
    #save-btn {
        background: black;
        color: white;
    }
    @media (max-width: 480px) {
        #btn-container-forum {
            flex-direction: column;
            gap: 10px;
        }
        #cancel-btn, #save-btn {
            width: 100%;
        }
    }
</style>
@endsection
