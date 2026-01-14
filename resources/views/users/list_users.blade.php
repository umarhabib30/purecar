@extends('layout.superAdminDashboard')
@section('body')
    <section id="user-container">
        <h2>{{ $title }}</h2>
        <div id="user-content">
            <!-- Top Bar with Search and Add User Button -->
            <div id="top-bar-user">
                <!-- Search Bar -->
                <div id="search-bar-user">
                    <img src="assets/search-icon.png" alt="Search" id="search-icon">
                    <input type="search" placeholder="Search by name..." id="input">
                </div>
                <!-- Add User Button -->
                <div id="add-user">
                    <button id="add-user-btn" onclick="window.location.href = '{{ url('/create-user') }}'">
                        <img src="assets/adminPanelAssets/bs/add.svg" id="add-icon"> Add User
                    </button>
                </div>
            </div>
            <!-- User Table -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Sr. #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th>Listings</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="min-width:150px;">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->location }}</td>
                                <td>{{ $user->role }}</td>
                                <td style="min-width:120px;">{{ $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $user->active_adverts_count }}</td>
                                <td>
                                    <div class="action-user">
                                        <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-primary btn-sm">Update</a>
                                        <a href="{{ route('user.delete', ['user' => $user->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                                        <a href="{{ route('removeadvert.delete', ['user' => $user->id]) }}" class="btn btn-secondary btn-sm">Remove Adverts</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
        </div>
    </section>
    <script>
        // Search Functionality
        document.getElementById('input').addEventListener('input', function () {
            const searchQuery = this.value.toLowerCase();
            const rows = document.querySelectorAll('#user-table-body tr');
            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (name.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    <style>
        #user-container {
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        #top-bar-user {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        #search-bar-user {
            display: flex;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px;
            width: 300px;
        }
        #search-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        #input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
        }
        #add-user-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        #add-icon {
            width: 16px;
            height: 16px;
            margin-right: 8px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        td {
            color: #555;
        }
        .action-user {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        /* Pagination */
        .my-pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            #top-bar-user {
                flex-direction: column;
                gap: 10px;
            }
            #search-bar-user {
                width: 100%;
            }
            #add-user-btn {
                width: 100%;
                justify-content: center;
            }
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px;
            }
            .action-user {
                flex-direction: column;
                gap: 4px;
            }
            .btn {
                width: 100%;
                text-align: center;
            }
        }
        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }
            table {
                font-size: 12px;
            }
            th, td {
                padding: 6px;
            }
        }
    </style>
@endsection
