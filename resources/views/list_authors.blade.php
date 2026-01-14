@extends('layout.superAdminDashboard')
@section('body')
    <section id="author-container">
        <h2>Authors</h2>
        <div id="author-content">
            <!-- Top Bar with Search and Add Author Button -->
            <div id="top-bar-author">
                <!-- Search Bar -->
                <div id="search-author">

                </div>
                <!-- Add Author Button -->
                <div id="add-author">
                    <button id="add-author-btn" onclick="window.location.href = '{{ url('/create-author') }}'">
                        <img src="{{ asset('assets/adminPanelAssets/bs/add.svg') }}" alt="Add Icon" id="add-icon">
                        Add Author
                    </button>
                </div>
            </div>

            <!-- Authors Table -->
            <table>
                <thead>
                <tr>
                    <th>Sr. #</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td class="serial-author">{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset('images/authors/'. $author->image) }}" alt="{{ $author->name }}" class="author-image">
                        </td>
                        <td class="info-author">{{ $author->name }}</td>
                        <td class="action-author">
                            <a href="{{ route('author.edit', ['author' => $author->id]) }}" class="btn-edit">Edit</a>
                            <a href="{{ route('author.delete', ['author' => $author->id]) }}" class="btn-delete">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="my-pagination-container">
                {{ $authors->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
    </section>

    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        #author-container {
            padding: 24px;
            background-color: #F5F6FA;
        }

        #author-container h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 24px;
        }

        /* Top Bar */
        #top-bar-author {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        #add-author-btn {
            display: flex;
            align-items: center;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #add-icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: black;
            color: #fff;
            font-weight: 500;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        .author-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Action Buttons */
        .action-author {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }

        .btn-edit, .btn-delete {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit {
            background-color: #28a745;
            color: #fff;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Pagination Styles */
        .my-pagination-container {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 8px;
        }

        .pagination li {
            list-style: none;
        }

        .pagination li a {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            color: #007bff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .pagination li a:hover {
            background-color: #f8f9fa;
        }

        .pagination .active a {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #top-bar-author {
                flex-direction: column;
                gap: 16px;
            }
            #add-author-btn {
                width: 100%;
                justify-content: center;
            }
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
@endsection
