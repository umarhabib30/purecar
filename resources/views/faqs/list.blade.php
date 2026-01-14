@extends('layout.superAdminDashboard')
@section('body')
    <section id="faqs-container">
        <h2>{{ $title }}</h2>
        <div id="blogs-content">
            <div id="top-bar">
                <div id="search">
                 
                </div>
                <div id="add-faqs">
                    <img src="assets/adminPanelAssets/bs/add.svg" id="add-icon" alt="Add Icon">
                    <button id="add-faqs-btn" onclick="window.location.href = '{{ url('/create-faq') }}'">Add FAQ</button>
                </div>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Sr. #</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($faqs as $faq)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $faq->question }}</td>
                        <td>{{ $faq->answer }}</td>
                        <td>
                            <div class="action-faqs">
                                <a href="{{ route('faq.edit', ['faq' => $faq->id]) }}" class="btn-update">Update</a>
                                <a href="{{ route('faq.delete', ['faq' => $faq->id]) }}" class="btn-delete">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="my-pagination-container">
            {{ $faqs->links('vendor.pagination.custom-pagination') }}
        </div>
    </section>
    <style>
        /* General Styles */
        #faqs-container {
            padding: 20px;
            font-family: 'Arial', sans-serif;
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        #top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        #add-faqs {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #add-faqs {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        #add-faqs-btn{
            background-color: transparent;
            border: none;
            color: white;
        }
        #add-icon {
            width: 20px;
            height: 20px;
        }

        /* Table Styles */
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
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .action-faqs {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-update, .btn-delete {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-update {
            background-color: #ffc107;
            color: #000;
        }

        .btn-update:hover {
            background-color: #e0a800;
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
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            gap: 10px;
        }

        .pagination li {
            list-style: none;
        }

        .pagination li a {
            padding: 8px 12px;
            background-color: #f4f4f4;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }

        .pagination li.active a {
            background-color: #4CAF50;
            color: white;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            #top-bar {
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

            .action-faqs {
                flex-direction: column;
                gap: 5px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            #add-faqs-btn {
                padding: 8px 16px;
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }

            .btn-update, .btn-delete {
                padding: 4px 8px;
                font-size: 12px;
            }
        }
    </style>
@endsection
