@extends('layout.superAdminDashboard')
@section('body')
    <section class="blogs-container">
        <h2>Coupon</h2>
        <div class="blogs-content">
            <div class="top-bar">
                <div class="search">
                    <!-- Add search functionality here if needed -->
                </div>
                <div class="add-blog">
                    <img src="assets/adminPanelAssets/bs/add.svg" alt="Add Icon" class="add-icon">
                    <button class="add-blog-btn" onclick="window.location.href = '{{ url('/create-coupon') }}'">+ Add Coupon</button>
                </div>
            </div>
            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Usage Limit</th>
                        <th>Used</th>
                        <th>Expiry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->discount }}</td>
                        <td>{{ ucfirst($coupon->type) }}</td>
                        <td>{{ $coupon->usage_limit ?? 'Unlimited' }}</td>
                        <td>{{ $coupon->used_count }}</td>
                        <td>{{ $coupon->expiry_date }}</td>
                        <td>
                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-primary m-1">Edit</a>
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger m-1">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

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
