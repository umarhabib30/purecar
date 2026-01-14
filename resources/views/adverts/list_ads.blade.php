@extends('layout.superAdminDashboard')
@section('body')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .MyListingPage {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F6FA;
            padding: 32px;
            width: 100%;
        }
        .MyListingPage #listings-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .MyListingPage h2 {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 28px;
            margin-bottom: 24px;
        }
        .MyListingPage #listings-content {
            background-color: #fff;
            border-radius: 16px;
            padding: 24px;
            overflow-x: auto;
        }
        .MyListingPage #top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }
        .MyListingPage #search-bar {
            position: relative;
            flex: 1;
            max-width: 300px;
        }
        .MyListingPage #search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .MyListingPage #input {
            border: none;
            background-color: #F5F6FA;
            border-radius: 8px;
            height: 44px;
            padding-left: 40px;
            width: 100%;
            font-size: 14px;
        }
        .MyListingPage .dropdown {
            position: relative;
            width: 114px;
            cursor: pointer;
            font-size: 16px;
            color: #A4A7AD;
        }
        .MyListingPage .dropdown-btn {
            display: flex;
            gap: 12px;
            align-items: center;
            background-color: #F5F6FA;
            padding: 11px 10px;
            border-radius: 8px;
        }
        .MyListingPage .dropdown-options {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #F5F6FA;
            border: 1px solid #ccc;
            border-radius: 8px;
            display: none;
            z-index: 10;
        }
        .MyListingPage .dropdown-options li {
            padding: 10px;
            color: #A4A7AD;
        }
        .MyListingPage .dropdown-options li:hover {
            background-color: #e0e0e0;
        }
        .MyListingPage .dropdown.active .dropdown-options {
            display: block;
        }
        .MyListingPage table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .MyListingPage th, .MyListingPage td {
            font-size: 16px;
            border-bottom: 1px solid #F2F2F2;
            padding: 12px 16px;
            text-align: left;
            vertical-align: middle;
        }
        .MyListingPage th {
            font-weight: 600;
        }
        .MyListingPage tbody {
            color: #8C8994;
        }
        .MyListingPage .expiry {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .MyListingPage .action img {
            cursor: pointer;
            width: 20px;
            height: auto;
        }
        .MyListingPage .dropdown-menu {
            padding: 5px 0;
            font-size: 14px;
            min-width: 100px;
        }
        .MyListingPage .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .MyListingPage #deleteOption:active {
            background-color: #000;
            color: white;
        }
        .MyListingPage #deleteOption:hover {
            background-color: #343a40;
            color: white;
        }
        .MyListingPage .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .MyListingPage .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }
        .MyListingPage .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .MyListingPage .btnpopup {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .MyListingPage #pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }
        .MyListingPage .pagination-btn {
            outline: none;
            border: 1px solid #D0D5DD;
            background-color: #fff;
            color: #344054;
            height: 36px;
            padding: 0 14px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }
        .MyListingPage #page-status {
            background-color: #fff;
            color: #344054;
            padding: 10px;
            border-radius: 12px;
            font-size: 14px;
        }
        /* Responsive Styles */
        @media (max-width: 768px) {
            .MyListingPage #top-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .MyListingPage #search-bar {
                max-width: 100%;
            }
            .MyListingPage table {
                display: block;
                overflow-x: auto;
            }
            .MyListingPage th, .MyListingPage td {
                white-space: nowrap;
            }
            .MyListingPage #pagination {
                flex-direction: column;
                align-items: center;
            }
        }
    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .pagination .page-item .page-link {
        outline: none;
        border: 1px solid #D0D5DD;
        background-color: #fff;
        color: #344054;
        height: 36px;
        padding: 0 14px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }
    .pagination .page-item.disabled .page-link {
        cursor: not-allowed;
        opacity: 0.5;
    }
    .pagination .page-item.active .page-link {
        background-color: #344054;
        color: #fff;
    }
</style>

<section class="MyListingPage">
    <div id="listings-container">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h2>Adverts</h2>
        <div id="listings-content">
            <div id="top-bar">
                <form action="{{ route('list-ads.index') }}" method="GET" id="search-form">
                    <div id="search-bar">
                        <img src="{{ asset('assets/search-icon.png') }}" alt="Search Icon" id="search-icon">
                        <input type="search" name="search" placeholder="Search" id="input" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Information</th>
                        <th>Location</th>
                        <th>Expiry</th>
                        <th>Seller</th>
                        <th>View</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                    @foreach ($listing_data as $data)
                        <tr>
                            <td class="image">
                                @if($data->car)
                                    <a href="{{ route('advert_detail', $data->car->car_id) }}" target="_blank" style="text-decoration: none;">
                                        <img class="img-fluid" style="width: 40px; height:40px;border-radius:5px;" src="{{ asset($data->image) }}" alt="Car Image" loading="lazy">
                                    </a>
                                @else
                                    <span>No car available</span>
                                @endif
                            </td>
                            <td class="info">
                                @if($data->car)
                                    {{ $data->car->make }} {{ $data->car->model }} {{ $data->car->variant }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="info">{{ $data->user->location ?? 'N/A' }}</td>
                            <td class="expiry">
                                <img src="{{ asset('assets/calendar-icon.png') }}" alt="Calendar Icon">
                                <span class="expiry-date" data-expiry-date="{{ $data->expiry_date }}"></span>
                            </td>
                            <td class="info">{{ $data->user->role ?? 'N/A' }}</td>
                            <td class="view">{{ $data->page_views }}</td>
                            <td class="action">
                                <div class="dropdown">
                                    <img src="{{ asset('assets/action.png') }}" alt="Action" class="dropdown-toggle" id="actionMenu{{ $data->advert_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $data->advert_id }}">
                                        <li>
                                            <a href="#" class="dropdown-item deleteOption" data-advert-id="{{ $data->advert_id }}">Delete</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('adverts.edit', $data->advert_id) }}" class="dropdown-item">Edit</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to delete this listing?</p>
                    <div class="button-container">
                        <button id="cancelDelete" class="btnpopup btn-light">Cancel</button>
                        <button id="confirmDelete" class="btnpopup btn-dark">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pagination">
            {{ $listing_data->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Debounced search form submission
    const searchInput = document.querySelector('#input');
    const searchForm = document.querySelector('#search-form');

    searchInput.addEventListener('input', function () {
        clearTimeout(searchInput.dataset.timeout);
        searchInput.dataset.timeout = setTimeout(() => {
            searchForm.submit();
        }, 300);
    });

    // Expiry date formatting
    document.querySelectorAll(".expiry-date").forEach(function (span) {
        let expiryDate = span.getAttribute("data-expiry-date");
        if (expiryDate) {
            let dateObj = new Date(expiryDate);
            let formattedDate = dateObj.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            span.textContent = formattedDate;
        }
    });

    // Delete modal handling
    document.querySelectorAll('.deleteOption').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const advertId = this.getAttribute('data-advert-id');
            document.getElementById('confirmDelete').setAttribute('data-advert-id', advertId);
            document.getElementById('deleteModal').style.display = 'flex';
        });
    });

    document.getElementById('confirmDelete').addEventListener('click', function () {
        const advertId = this.getAttribute('data-advert-id');
        const deleteUrl = "{{ route('delete_listing', ':advert_id') }}".replace(':advert_id', advertId);
        window.location.href = deleteUrl;
    });

    document.getElementById('cancelDelete').addEventListener('click', function () {
        document.getElementById('deleteModal').style.display = 'none';
    });
});
</script>
@endsection