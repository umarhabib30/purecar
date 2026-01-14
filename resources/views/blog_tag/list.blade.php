@extends('layout.superAdminDashboard')

@section('body')
    <section id="blogs-container-tags">
        <h2>{{ $title }}</h2>
        <div id="blogs-content-tags">
            <div id="top-bar-tags">
                <div id="search-tags">
                </div>
                <div id="add-blog-tags">
                    <button id="add-blog-btn" onclick="window.location.href = '{{ url('/create-blog-tag') }}'">
                        <img src="assets/adminPanelAssets/bs/add.svg" id="add-icon" alt="Add Icon">
                        Add Blog Tag
                    </button>
                </div>
            </div>

            <table id="blog-tags-table">
                <thead>
                    <tr>
                        <th>Sr. #</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blog_tags as $blog_tag)
                        <tr>
                            <td class="serial-tags">{{ $loop->iteration }}</td>
                            <td class="info-tags">{{ $blog_tag->name }}</td>
                            <td class="action-tags">
                                <a href="{{ route('blog-tag.delete', ['id' => $blog_tag->id]) }}" class="btn btn-danger" style="text-decoration: none;">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="my-pagination-container">
                {{ $blog_tags->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
    </section>

    <style>
        #blogs-container-tags {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        #top-bar-tags {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        #add-blog-tags {
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
        #blog-tags-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        #blog-tags-table th,
        #blog-tags-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        #blog-tags-table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        #blog-tags-table tr:hover {
            background-color: #f5f5f5;
        }
        .delete-btn {
            color: #dc3545;
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
