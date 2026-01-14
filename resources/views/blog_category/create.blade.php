@extends('layout.superAdminDashboard')

@section('body')
    <section id="add-blog-category-outer-container">
        <h1>{{ $title }}</h1>
        <form action="{{ route('blog-category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="add-blog-category-inner-container">
                <div class="input-group-blog">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Enter Blog Category Name" required>
                </div>
                <div id="btn-container-blog">
                    <button type="submit" id="save-btn">Save</button>
                </div>
            </div>
        </form>
    </section>

    <style>
        #add-blog-category-outer-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        #add-blog-category-inner-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .input-group-blog {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .input-group label {
            font-weight: bold;
            color: #555;
        }
        .input-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .input-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        #btn-container-blog{
            display: flex;
            justify-content: flex-end;
        }
        #save-btn {
            padding: 10px 20px;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        @media (max-width: 768px) {
            #add-bramd-category-outer-container {
                padding: 15px;
            }
            h1 {
                font-size: 24px;
            }
            .input-group input {
                font-size: 14px;
            }
            #save-btn {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
@endsection
