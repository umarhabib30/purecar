@extends('layout.dashboard')
@section('body')
    <style>
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 9999;
            /* Ensures modal appears above all other content */
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btnpopup {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .table-responsive {
            width: 100%;
            max-height: 500px;
            overflow-x: auto;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Customize vertical scrollbar */
        .table-responsive::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;

            text-align: left;
            border-bottom: 1px solid #ddd;
            /* text-align: center; */
            vertical-align: middle;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        @media screen and (max-width: 768px) {
            #mobile-listing {
                display: block;
            }

            #desktop-listing {
                display: none;
            }

            #search-bar {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 10px;
                padding-left: 10px;
                background-color: #f1f1f1;
                border: 1px solid #ddd;
                border-radius: 10px;
            }
        }

        @media screen and (min-width: 768px) {
            #desktop-listing {
                display: block;
            }

            #mobile-listing {
                display: none;
            }
        }
    </style>
    <section class="MyFavoritePage" id="desktop-listing">
        <div id="favorites-container">
            <div id="top-bar-listing">
                <div id="top-bar-heading">
                    <h2>My favorite</h2>
                </div>
                <div id="top-bar-Search">
                    <div id="search-bar" style="background: white;">
                        <img src="{{ asset('assets/search-icon.png') }}" alt="" id="search-icon">
                        <input type="search" placeholder="Search" id="input" class="search-input"
                            style="outline: none; border: none; background: white; box-shadow: none !important">
                    </div>
                </div>
                <!-- <div id="filter">
                        <select name="filter" id="filter-select">
                            <option value="Newest">Newest</option>
                            <option value="Oldest">Oldest</option>
                            <option value="Popular">Popular</option>
                        </select>
                        <img src="assets/dropdown.png" alt="Dropdown" id="dropdown-icon">
                    </div> -->
                <!-- <div id="custom-dropdown" class="dropdown">
                        <div id="dropdown-btn" class="dropdown-btn">
                          Newest <img src="{{ asset('assets/dropdown.png') }}" alt="Dropdown Icon" id="dropdown-icon">
                        </div>
                        <ul id="dropdown-options" class="dropdown-options">
                          <li data-value="Newest">Newest</li>
                          <li data-value="Oldest">Oldest</li>
                          <li data-value="Popular">Popular</li>
                        </ul>
                      </div> -->
            </div>
            <div id="favorites-content">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th class="text-center">Image</th>
                                <th class="text-center">Information</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Date posted</th>
                                <th>Offers</th>
                                <th class="text-center">Favourited</th>
                                <th class="text-center">Views</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            @foreach ($favourite_data as $data)
                                <tr>
                                    <td class="image" style="vertical-align: middle;">
                                        <a href="{{ route('advert_detail', $data->car->slug) }}" target="_blank">
                                            <img class="img-fluid"
                                                style="width: 60px; height: 60px; border-radius: 5px; object-fit: cover;"
                                                src="{{ asset('' . $data->image) }}" alt="Car Image">
                                        </a>
                                    </td>
                                    <td class="info" style="vertical-align: middle;">{{ $data->make }}
                                        {{ $data->model }} {{ $data->car->year }}</td>
                                    <td class="info" style="vertical-align: middle;">{{ $data->location ?? 'N/A' }}</td>
                                    <td class="date-posted-td" style="vertical-align: middle;">
                                        <div class="date-posted"
                                            style="display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ asset('assets/calendar-icon.png') }}" alt="Calendar Icon"
                                                style="margin-right: 5px;">
                                            <span>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') : 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="offers" style="vertical-align: middle;">
                                        <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                                            <div class="calls-container"
                                                style="display: flex; align-items: center; gap: 5px;">
                                                <img src="{{ asset('assets/call.png') }}"
                                                    style="width: 20px; height: 20px;">
                                                <p class="calls" style="margin: 0;">{{ $data->total_texts }} calls</p>
                                            </div>
                                            <div class="msgs-container"
                                                style="display: flex; align-items: center; gap: 5px;">
                                                <img src="{{ asset('assets/message.png') }}"
                                                    style="width: 20px; height: 20px;">
                                                <p class="messages" style="margin: 0;">{{ $data->total_calls_and_emails }}
                                                    messages</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="view" style="vertical-align: middle;">{{ $data->total_favorites }} </td>
                                    <td class="view" style="vertical-align: middle;">{{ $data->total_ad_views }} </td>
                                    <td class="action" style="vertical-align: middle;">
                                        <a href="#" class="dropdown-item deleteOption"
                                            data-advert-id="{{ $data->advert_id }}">
                                            <img src="{{ asset('assets/delete_icon.png') }}" alt="Delete"
                                                style="width: 30px; height: 30px; margin-right: 5px;">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- <div id="pagination">
                        <div id="previous-next">
                            <button class="pagination-btn">Previous</button>
                            <button class="pagination-btn">Next</button>
                        </div>
                        <div id="page-status">
                            <p>Page 1 of 10</p>
                        </div>
                    </div> -->
        </div>
    </section>
    <section id="mobile-listing">
        <div id="search-bar" style="background: white; margin-bottom:10px;">
            <img src="{{ asset('assets/search-icon.png') }}" alt="" id="search-icon">
            <input type="search" placeholder="Search" id="input" class="search-input"
                style="outline: none; border: none; background: white; box-shadow: none !important">
        </div>
        <div class="accordion">
            @foreach ($favourite_data as $data)
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div>
                            {{-- <img src="{{ asset('' . $data->image) }}" alt="Car Image" style="width: 60px; height: 60px; border-radius: 5px; object-fit: cover;">
                         --}}
                            <a href="{{ route('advert_detail', $data->car->slug) }}" target="_blank" style="text-decoration: none;">
                                <img class="img-fluid"
                                    style="width: 60px; height: 60px; border-radius: 5px; object-fit: cover;"
                                    src="{{ asset('' . $data->image) }}" alt="Car Image">
                            </a>
                            <span>{{ $data->make }} {{ $data->model }} {{ $data->car->year }}</span>
                        </div>
                        <div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                    </div>
                    <div class="accordion-content">
                        <div>
                            <div style="display: flex; justify-content:start; align-items:center; margin-top:10px;">
                                <span
                                    style="width:120px; overflow:hidden; display:inline-block; display:flex; justify-content:start; align-items:center">
                                    <span><i class="fas fa-map-marker-alt"
                                            style="width: 20px; margin-right:5px;"></i></span>
                                    <span>Location : </span>
                                </span>
                                <span style="">{{ $data->location ?? 'N/A' }}</span>
                            </div>
                            <div style="display:flex; justify-content:start; align-items:center;">
                                <span
                                    style="width:120px; overflow:hidden; display:inline-block; display:flex; justify-content:start; align-items:center">
                                    <span><i class="fas fa-calendar-alt"
                                            style="width: 20px; margin-right:5px;"></i></span>
                                    <span>Posted : </span>
                                </span>
                                <span>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') : 'N/A' }}</span>
                            </div>
                            <div style="display:flex; justify-content:start; align-items:center;">
                                <span
                                    style="width:120px; overflow:hidden; display:inline-block; display:flex; justify-content:start; align-items:center">
                                    <span><i class="fas fa-parachute-box"
                                            style="width: 20px; margin-right:5px;"></i></span>
                                    <span>Offers : </span>
                                </span>
                                <div style="display:flex; justify-content:start; align-items:center;">
                                    <span style="display:flex; justify-content:start; align-items:center; gap:5px;">
                                        <span>{{ $data->total_calls_and_emails }}</span>
                                        <span><i class="fas fa-envelope"
                                                style="width: 20px; margin-right:10px;"></i></span>
                                    </span>
                                    <span style="display:flex; justify-content:start; align-items:center; gap:5px;">
                                        <span>{{ $data->total_texts }}</span>
                                        <span><i class="fas fa-phone" style="width: 20px; margin-right:5px;"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div style="display:flex; justify-content:start; align-items:center;">
                                <span
                                    style="width:120px; overflow:hidden; display:inline-block; display:flex; justify-content:start; align-items:center">
                                    <span><i class="fas fa-heart" style="width: 20px; margin-right:5px;"></i></span>
                                    <span>Favourites : </span>
                                </span>
                                <span>{{ $data->total_favorites }}</span>
                            </div>
                            <div style="display:flex; justify-content:start; align-items:center;">
                                <span
                                    style="width:120px; overflow:hidden; display:inline-block; display:flex; justify-content:start; align-items:center">
                                    <span><i class="fas fa-eye" style="width: 20px; margin-right:5px;"></i></span>
                                    <span>Views : </span>
                                </span>
                                <span>{{ $data->total_ad_views }}</span>
                            </div>
                        </div>
                        <div
                            style="display:flex; justify-content:end; align-items:center; gap:10px; flex-direction:row-reverse; margin-bottom:10px">
                            <span style="background-color: black; padding:5px 10px; border-radius:5px;">
                                <a href="#" class="dropdown-item deleteOption"
                                    data-advert-id="{{ $data->advert_id }}"><i class="fas fa-trash-can"
                                        style="color: white;"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <style>
            .accordion {
                width: 100%;
            }

            .accordion-item {
                border: none;
                border-radius: 0px !important;
                margin-bottom: 5px;
            }

            .accordion-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px;
                border-bottom: 1px solid rgb(224, 222, 222);
                cursor: pointer;
            }

            .accordion-content {
                padding: 0 10px;
                max-height: 0;
                overflow: hidden;
                border-bottom: 1px solid rgb(224, 222, 222);
                transition: max-height 0.4s ease-in-out;

            }

            .accordion-content.active {
                max-height: 500px;
                /* Set a reasonable max height */

            }

            .accordion-icon {
                transition: transform 0.3s ease;
            }

            .accordion-icon.rotate {
                transform: rotate(180deg);
            }
        </style>
        <script>
            document.querySelectorAll('.accordion-header').forEach(header => {
                header.addEventListener('click', () => {
                    document.querySelectorAll('.accordion-content').forEach(content => {
                        if (content !== header.nextElementSibling && content.classList.contains(
                                'active')) {
                            content.classList.remove('active');
                            const otherHeader = content.previousElementSibling;
                            const otherIcon = otherHeader.querySelector('.accordion-icon');
                            otherIcon.classList.remove('rotate');
                        }
                    });
                    const content = header.nextElementSibling;
                    content.classList.toggle('active');
                    const icon = header.querySelector('.accordion-icon');
                    icon.classList.toggle('rotate');
                });
            });
        </script>
    </section>
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <img src="{{ asset('assets/deleteicon.svg') }}" alt="Are you sure?" class="modal-icon">

            <p>are you sure you want to delete this listing?</p>
            <div class="button-container">
                <button id="cancelDelete" class="btnpopup btn-light">Cancel</button>
                <button id="confirmDelete" class="btnpopup btn-dark">Yes, Delete</button>
            </div>
        </div>
    </div>


<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     // Attach click events to all delete buttons
    //     document.querySelectorAll('.deleteOption').forEach(function (button) {
    //         button.addEventListener('click', function (event) {
    //             event.preventDefault(); // Prevent immediate action
    //             const advertId = this.getAttribute('data-advert-id'); // Get advert_id from data attribute

    //             // Store the advert ID in a global variable or modal-specific attribute for confirmation
    //             document.getElementById('confirmDelete').setAttribute('data-advert-id', advertId);

    //             // Show modal
    //             document.getElementById('deleteModal').style.display = 'flex';
    //         });
    //     });

    //     // Confirm delete action
    //     document.getElementById('confirmDelete').addEventListener('click', function () {
    //         const advertId = this.getAttribute('data-advert-id'); // Get stored advert ID
    //         const deleteUrl = "{{ route('delete_listing', ':advert_id') }}".replace(':advert_id', advertId);
    //         window.location.href = deleteUrl; // Redirect to the delete route
    //     });

    //     // Cancel delete action
    //     document.getElementById('cancelDelete').addEventListener('click', function () {
    //         document.getElementById('deleteModal').style.display = 'none'; // Hide modal
    //     });
    // });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.deleteOption').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent immediate action
                const advertId = this.getAttribute(
                    'data-advert-id'); // Get advert_id from data attribute

                // Store the advert ID in the confirm button
                document.getElementById('confirmDelete').setAttribute('data-advert-id',
                    advertId);

                // Show modal
                document.getElementById('deleteModal').style.display = 'flex';
            });
        });

        // Confirm delete action
        document.getElementById('confirmDelete').addEventListener('click', function() {
            const advertId = this.getAttribute('data-advert-id'); // Get stored advert ID
            const deleteUrl = "{{ route('delete_favourite', ':advert_id') }}".replace(':advert_id',
                advertId);

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;

            // Add CSRF token
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = "{{ csrf_token() }}";
            form.appendChild(csrfField);

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit();
        });

        // Cancel delete action
        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').style.display = 'none'; // Hide modal
        });
    });



    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('input');
        const searchIcon = document.getElementById('search-icon');
        const tableBody = document.getElementById('user-table-body');

        // Function to perform the search
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const infoCell = row.querySelector('.info'); // Get the info cell (second column)
                if (infoCell) {
                    const text = infoCell.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = ''; // Show the row
                    } else {
                        row.style.display = 'none'; // Hide the row
                    }
                }
            }
        }

        // Add event listeners for both input changes and search icon clicks
        searchInput.addEventListener('input', performSearch);
        searchIcon.addEventListener('click', performSearch);

        // Add event listener for Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInputs = document.querySelectorAll(".search-input"); // Select both search bars
    const desktopRows = document.querySelectorAll("#user-table-body tr"); // Desktop table rows
    const mobileItems = document.querySelectorAll(".accordion-item"); // Mobile accordion items

    function filterResults(searchText) {
        searchText = searchText.toLowerCase().trim();

        // Filter desktop table rows
        desktopRows.forEach(row => {
            let infoColumn = row.querySelector("td:nth-child(2)"); // Selects "Information" column
            row.style.display = infoColumn && infoColumn.textContent.toLowerCase().includes(searchText) ? "" : "none";
        });

        // Filter mobile accordion items
        mobileItems.forEach(item => {
            let infoText = item.querySelector(".accordion-header span")?.textContent.toLowerCase().trim() || "";
            item.style.display = infoText.includes(searchText) ? "" : "none";
        });
    }

    // Add event listener to both search bars
    searchInputs.forEach(input => {
        input.addEventListener("keyup", function () {
            filterResults(this.value);
        });
    });
});


    </script>
@endsection