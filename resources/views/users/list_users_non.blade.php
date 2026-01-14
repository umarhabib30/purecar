@extends('layout.superAdminDashboard')
@section('body')
    <section id="nonuser-container">
        <h2>{{ $title }}</h2>
        <div id="nonuser-content">
            <!-- Top Bar with Search -->
            <div id="top-bar">
                <div id="search-bar">
                    <img src="assets/search-icon.png" alt="Search" id="search-icon">
                    <input type="search" placeholder="Search by name..." id="input">
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
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A' }}</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge verified">Verified</span>
                                    @else
                                        <span class="badge unverified">Unverified</span>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <div>
                                        @if(!$user->email_verified_at)
                                            <form action="{{ route('verification.send') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Resend Verification
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('user.delete', ['user' => $user->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                                        @if(!$user->email_verified_at)
                                        <form action="{{ route('user.verify') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-success btn-sm" title="Verify User">
                                                Verify
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="my-pagination-container">
                {{ $users->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </section>
    <script>
        // Your existing search script
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
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.display = 'none';
                });
            }, 5000);
        });
        </script>
    <style>
        #nonuser-container {
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        #search-bar {
            display: flex;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px;
            max-width: 300px;
            margin-bottom: 20px;
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
        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .verified {
            background-color: #28a745;
            color: white;
        }
        .unverified {
            background-color: #ffc107;
            color: black;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 4px;
        }
        /* Pagination */
        .my-pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            border-radius: 8px;
        }
        .alert-dismissible .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        @media (max-width: 768px) {
            #search-bar {
                max-width: 100%;
            }
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px;
            }
            .btn-danger{
                margin-top: 5px;
            }
            .action-buttons {
                flex-direction: column;
                gap: 8px;
            }
            .btn-sm {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection
