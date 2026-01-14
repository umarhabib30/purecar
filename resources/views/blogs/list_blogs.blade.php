@extends('layout.superAdminDashboard')
@section('body')
    <section class="blogs-container">
        <h2>Blogs</h2>
        <div class="blogs-content">
            <div class="top-bar">
                <div class="search">
                    <!-- Add search functionality here if needed -->
                </div>
                <div class="add-blog">
                    <img src="assets/adminPanelAssets/bs/add.svg" alt="Add Icon" class="add-icon">
                    <button class="add-blog-btn" onclick="window.location.href = '{{ url('/create-blog') }}'">+ Add Blog</button>
                </div>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Sr. #</th>
                            <th>Featured Image</th>
                            <th>Title</th>
                            <th>Date Posted</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td class="serial">{{ $loop->iteration }}</td>
                                <td class="featured-image-cell">
                                    <img src="{{ asset('images/blogs/'. $blog->featured_image) }}" alt="Featured Image" class="featured-image">
                                </td>
                                <td class="title">{{ $blog->title }}</td>
                                <td class="date-posted">
                                    <img src="assets/adminPanelAssets/bs/calendar-icon.png" alt="Calendar Icon" class="calendar-icon">
                                    <p class="date">{{ $blog->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="author">{{ $blog->nameAuthor->name ?? 'N/A' }}</td>
                                <td class="category">{{ $blog->blogCategory->name ?? 'N/A' }}</td>
                                <td class="tags">{{ implode(', ', explode(',', $blog->tags)) }}</td>
                                <td class="action-1">
                                    <div class="action-1-div">
                                        <a href="{{ route('blog.edit', ['slug' => $blog->slug]) }}" class="btn-update">Update</a>
                                        <a href="{{ route('blog.delete', ['blog' => $blog->id]) }}" class="btn-delete">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-container">
                {{ $blogs->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
    </section>

    <style>
        /* General Styles */
        .blogs-container {
            padding: 20px;
            background-color: #f9f9f9;
            min-height: 90vh;
        }

        .blogs-container h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-blog {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .add-blog-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-blog-btn:hover {
            background-color: #333;
        }

        .add-icon {
            width: 20px;
            height: 20px;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
            vertical-align: middle; /* Ensure vertical alignment */
        }

        th {
            background-color: black;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .featured-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .calendar-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .date-posted p {
            margin: 0;
            padding: 0;
        }

        .date-posted {
            display: flex;
            align-items: center;
            justify-content: start;
        }
        .action-1-div{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-update, .btn-delete {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            width: 80px;
        }

        .btn-update {
            background-color: #28a745;
            color: white;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Pagination Styles */
        .pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                gap: 10px;
            }

            table {
                display: block;
                overflow-x: auto;
            }

            th, td {
                white-space: nowrap;
            }

            .add-blog-btn {
                width: 100%;
                text-align: center;
            }

            .action-1 {
                flex-direction: row; /* Switch to row layout on smaller screens */
                gap: 5px;
            }
        }

        @media (max-width: 480px) {
            th, td {
                padding: 8px;
                font-size: 14px;
            }

            .featured-image {
                width: 40px;
                height: 40px;
            }

            .btn-update, .btn-delete {
                padding: 3px 6px;
                font-size: 12px;
                width: 70px; /* Adjust button width for smaller screens */
            }
        }
    </style>
@endsection
