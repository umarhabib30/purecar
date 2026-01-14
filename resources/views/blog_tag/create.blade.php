@extends('layout.superAdminDashboard')

@section('body')
    <section id="add-blog-outer-container">
        <div class="form-container">
            <!-- Form Container -->
            <form action="{{ route('blog-tag.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h1>{{ $title }}</h1>
                <div class="input-group">
                    <label for="name">Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Enter Blog Tag" required>
                </div>
                <div class="btn-container">
                    <button type="submit">Save</button>
                </div>
            </form>
        </div>
    </section>

    <style>
        #add-blog-outer-container {
            display: flex;
            /* align-items: center; */
            justify-content: center;
            /* min-height: 100vh; */
            padding: 20px;
            background-color: #f9f9f9;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-group input:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }

        .required {
            color: #ff0000;
        }

        .btn-container {
            display: flex;
            justify-content: center;
        }

        .btn-container button {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: black;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
            h1 {
                font-size: 24px;
            }
            .input-group input {
                font-size: 14px;
                padding: 10px;
            }
            .btn-container button {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
@endsection
