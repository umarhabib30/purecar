@extends('layout.superAdminDashboard')

@section('body')
    <section id="list-blogs-container">
        <h2>{{ $title }}</h2>
        <div id="list-blogs-content">
            <!-- Top Bar with Search and Add Button -->
            <div id="list-top-bar">
                <div id="search">
                </div>
                <div id="list-add-blog">
                    <button id="add-blog-btn" onclick="window.location.href = '{{ url('/create-blog-category') }}'">
                        <img src="assets/adminPanelAssets/bs/add.svg" id="add-icon" alt="Add Icon">
                        Add Blog Category
                    </button>
                </div>
            </div>

            <!-- Table for Listing Blog Categories -->
            <table id="blog-category-table">
                <thead>
                    <tr>
                        <th>Sr. #</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blog_categories as $blog_category)
                        <tr>
                            <td class="serial-list">{{ $loop->iteration }}</td>
                            <td class="info-list">{{ $blog_category->name }}</td>
                            <td class="action-list">
                                <a href="{{ route('blog-category.delete', ['id' => $blog_category->id]) }}" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="my-pagination-container">
                {{ $blog_categories->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
    </section>

    <style>
        #list-blogs-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        #list-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        #list-add-blog {
            display: flex;
            align-items: center;
        }
        #add-blog-btn {
            padding: 8px 12px;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        #add-icon {
            margin-right: 8px;
        }
        #blog-category-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        #blog-category-table th,
        #blog-category-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        #blog-category-table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        #blog-category-table tr:hover {
            background-color: #f5f5f5;
        }
        .delete-btn {
            color: white;
            background-color: #c82333;
            padding: 5px 8px;
            text-decoration: none;
            font-weight: bold;
        }
        .delete-btn:hover {
            text-decoration: underline;
        }
        .my-pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination {
            list-style: none;
            display: flex;
            gap: 10px;
        }
        .pagination li {
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .pagination li:hover {
            background-color: #0056b3;
        }
        .pagination .active {
            background-color: #0056b3;
        }
    </style>
@endsection
