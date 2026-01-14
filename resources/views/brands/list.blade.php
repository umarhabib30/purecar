@extends('layout.superAdminDashboard')
@section('body')
    <section id="brands-section">
        <h2>{{ $title }}</h2>
        <div id="brands-container">
            <div id="top-bar-1">
                <div id="search">
                    <!-- Add search functionality here if needed -->
                </div>
                <div id="add-blog">
                    {{-- <img src="assets/adminPanelAssets/bs/add.svg" id="add-icon"> --}}
                    <button id="add-blog-btn" onclick="window.location.href = '{{ url('/create-brand') }}'">+ Add Brand</button>
                </div>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Sr. #</th>
                            <th>Link</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td class="serial">{{ $loop->iteration }}</td>
                                <td class="serial" style="max-width: 200px; word-wrap: break-word; overflow-wrap: break-word;">
                                    {{ $brand->link }}
                                </td>
                                <td>
                                    <img src="{{ asset('images/brands/'. $brand->image) }}" alt="Brand Image" class="rounded-circle brand-image">
                                </td>
                                <td class="action">
                                    <a href="{{ route('brand.delete', ['id' => $brand->id]) }}" class="delete-btn">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-pagination-container">
                {{ $brands->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
    </section>
    <style>
        /* General Styles */
        #brands-section {
            padding: 20px;
            background-color: #E7E7E7;
        }

        #brands-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #top-bar-1 {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
        }

        #add-blog {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        #add-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        #add-blog-btn {
            background: black;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .brand-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Pagination Styles */
        .my-pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            #top-bar {
                flex-direction: column;
                align-items: center;
            }

            #add-blog {
                margin-top: 10px;
            }

            table {
                /* display: block; */
                width: 100%;
                overflow-x: auto;
                margin-bottom: 20px;
            }

            th, td {
                padding: 8px;
                white-space: nowrap; /* Prevent text wrapping */
            }

            .brand-image {
                width: 40px;
                height: 40px;
            }

            .delete-btn {
                padding: 6px 10px;
            }
        }

        @media (max-width: 480px) {
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                padding: 6px;
            }

            .brand-image {
                width: 30px;
                height: 30px;
            }

            .delete-btn {
                padding: 4px 8px;
                font-size: 12px;
            }

            #add-blog-btn {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
@endsection
