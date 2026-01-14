@extends('layout.dashboard')
@section('body')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive::-webkit-scrollbar {
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
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .dropdown img {
            cursor: pointer;
            width: 20px;
            height: auto;
        }

        .dropdown-menu {
            padding: 5px 0;
            font-size: 14px;
            min-width: 100px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        #deleteOption:active {
            background-color: #000;
            color: white;
        }

        #deleteOption:hover {
            background-color: #343a40;
            color: white;
        }

        .modal {
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

        @media screen and (max-width: 768px) {            
            #mobile-listing{
                display: block;
            }
            #desktop-listing{
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

        @media screen and (min-width:768px) {
           

            #top-bar-heading {
                width: 50%;
            }
            #top-bar-Search {
                display: flex;
                justify-content: end;
                width: 50%;
            }            
            #search-bar {
                width: 50%;
                display: flex;
                align-items: center;
                gap: 10px;
                padding-left: 10px;
                background-color: #f1f1f1;
                border: 1px solid #ddd;
                border-radius: 10px;
            }            
            #input {
                padding: 12px;
                width: 100%;
                background-color: #f1f1f1;
                border: none;
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
            }
            #desktop-listing{
                display: block;
            }
            #mobile-listing{
                display: none;
            }
        }

        #pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination-btn {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            background-color: #f8f9fa;
        }

        .pagination-btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        #page-status {
            font-size: 14px;
            color: #666;
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
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
    <style>
                            #cancelDelete, #cancelSold {
                                background-color: #fff !important;
                                color: #000 !important;
                                border: 2px solid #000 !important;
                                padding: 8px 20px !important;
                                font-size: 14px !important;
                                font-weight: bold !important;
                                border-radius: 5px !important;
                                width: 100px;
                            }

                            #confirmDelete, #confirmSold  {
                                background-color: #000 !important;
                                color: #fff !important;
                                border: 2px solid #000 !important;
                                padding: 8px 20px !important;
                                font-size: 14px !important;
                                font-weight: bold !important;
                                width: 100px;
                                border-radius: 5px !important;
                            }
                        </style>

    <section class="MyFavoritePage" id="desktop-listing">
        <div id="favorites-container">
            @if (session('message'))
                <div class="alert alert-success" id="success-alert" role="alert">
                    {{ session('message') }}
                </div>
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            $('#success-alert').alert('close');
                        }, 3000);
                    };
                </script>
            @endif

            <div id="top-bar-listing" class="p-0">
                <div id="top-bar-heading">
                    <h2 style="margin: 0px; padding:0px;">Cars You Sold</h2>
                </div>
                <div id="top-bar-Search">
                    <div id="search-bar" style="background: white;">
                        <img src="{{ asset('assets/search-icon.png') }}" alt="Search" id="search-icon">
                        <input type="search" placeholder="Search" id="input" class="search-input"
                            style="outline: none; border: none; background: white; box-shadow: none !important">
                    </div>
                </div>
            </div>
            <div id="favorites-content">
                <div class="table-responsive p-3">
                    <table>
                        <thead>
                            <tr>
                                <th class="text-center">Image</th>
                                <th class="text-center">Information</th>    
                                <th class="text-center">Views</th>
                                <th class="text-center">Favourites</th>
                                <th class="text-center">Action</th>
                               
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            @foreach ($sold_data as $data)
                                <tr class="{{ $data->status == 'inactive' ? 'inactive-row' : '' }}">
                                    <td data-label="Image" class="text-center">
                                    @if ($data->car && $data->car->car_id)
                                        <a href="{{ route('advert_detail', $data->car->slug) }}" target="_blank">
                                   

                                            <img class="img-fluid"
                                                style="width: 60px; height: 60px; border-radius: 5px; object-fit: cover;"
                                                src="{{ $data->image ? asset('' . $data->image) : asset('asset/logo.png') }}"
                                                alt="Car Image">
                                        </a>
                                        @else
                                     
                                     @endif
                                    </td>
                                    <td data-label="Information" class="text-center">
                                        @if ($data->car)
                                            {{ $data->car->make }} {{ $data->car->model }} {{ $data->car->year }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                   
                                           
                                                <td data-label="View" class="text-center">{{ $data->page_views }}</td>
                                                <td data-label="Favourites" class="text-center">{{ $data->total_favorites }}</td>
                                                <td data-label="Action" class="text-center">
                                                    <a href="#" class="soldOption" data-advert-id="{{ $data->advert_id }}" style="text-decoration: none;">
                                                    <i class="fas fa-sync-alt" style="font-size: 18px; cursor: pointer; color: black;"></i>

                                                    </a>
                                                </td>


                                            </tr>
                                        @endforeach
                        </tbody>
                    </table>
                </div>

                            <!-- Delete Modal -->
                
            </div>                        
                             
        </div>
    </section>
    <section id="mobile-listing">
        <div>
            @if (session('message'))
                <div class="alert alert-success" id="success-alert" role="alert">
                    {{ session('message') }}
                </div>
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            $('#success-alert').alert('close');
                        }, 3000);
                    };
                </script>
            @endif
            <div id="top-bar-Search" style="margin-bottom:10px;">
                <div id="search-bar" style="background: white;">
                    <img src="{{ asset('assets/search-icon.png') }}" alt="Search" id="search-icon">
                    <input type="search" placeholder="Search" id="input" class="search-input"
                        style="outline: none; border: none; background: white; box-shadow: none !important">
                </div>
            </div>
            <div class="accordion">
                @foreach ($sold_data as $data)
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div>
                        @if ($data->car && $data->car->car_id)
                            <a href="{{ route('advert_detail', $data->car->slug) }}" target="_blank" style="text-decoration: none;">
                            
                                <img class="img-fluid"
                                    style="width: 60px; height: 60px; border-radius: 5px; object-fit: cover;"
                                    src="{{ $data->image ? asset('' . $data->image) : asset('asset/logo.png') }}"
                                    alt="Car Image">
                            </a>
                        @else
                        @endif

                            <span>{{ optional($data->car)->make }} {{ optional($data->car)->model }} {{ optional($data->car)->year }}</span>
                        </div> 
                        <div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>                      
                    </div>
                    <div class="accordion-content">
                        <div>                            
                          
                            <div style="display:flex; justify-content:start; a;ign-items:center;">
                                <span style="width:80px; overflow:hidden; display:inline-block;">
                                    <span ><i class="fas fa-eye fa-sm" style="width: 20px;"></i></span>
                                    <span>Views : </span>
                                </span>
                                <span> {{ $data->page_views }}</span>
                            </div>
                            <div style="display:flex; justify-content:start; a;ign-items:center;">
                                <span style="width:80px; overflow:hidden; display:inline-block;">
                                    <span><i class="fas fa-heart"  style="width: 20px;"></i></span>
                                    <span>Fav : </span>
                                </span>
                                <span> {{ $data->total_favorites }}</span>
                            </div>
                            <div
                                style="display:flex; justify-content:end; align-items:center; gap:10px; flex-direction:row-reverse; margin-bottom:10px">
                                <span style="background-color: black; padding:5px 10px; border-radius:5px;">
                                    <a href="#" class="dropdown-item soldOption"
                                        data-advert-id="{{ $data->advert_id }}"><i class="fas fa-sync-alt"
                                            style="color: white;"></i></a>
                                </span>
                              
                            </div>
                        </div>
                        
                    </div>
                </div>
                @endforeach
                
</div>

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
                        // Close all other accordion contents and reset their icons
                        document.querySelectorAll('.accordion-content').forEach(content => {
                            if (content !== header.nextElementSibling && content.classList.contains('active')) {
                                content.classList.remove('active');
                                const otherHeader = content.previousElementSibling;
                                const otherIcon = otherHeader.querySelector('.accordion-icon');
                                otherIcon.classList.remove('rotate'); // Reset rotation
                            }
                        });
            
                        // Toggle the clicked accordion content
                        const content = header.nextElementSibling;
                        content.classList.toggle('active');
            
                        // Toggle the rotation on the icon
                        const icon = header.querySelector('.accordion-icon');
                        icon.classList.toggle('rotate'); // Toggle rotation class
                    });
                });
            </script> 
        </div>
    </section>
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <img src="{{ asset('assets/deleteicons.png') }}" alt="Are you sure?" class="modal-icon">
            <p>Are you sure you want to delete this listing?</p>
            <div class="button-container">
                <button id="cancelDelete" class="btnpopup btn-light">Cancel</button>
                <button id="confirmDelete" class="btnpopup btn-dark">Yes</button>
            </div>
        </div>
    </div>
    <div id="soldModal" class="modal">
        <div class="modal-content">
          
            <p>Are you sure you want to reactivate this advert?</p>
            <div class="button-container">
          
        <button id="confirmSold" data-advert-id="">Yes</button>
        <button id="cancelSold">Cancel</button>
            </div>
        </div>
    </div>
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {            
            document.querySelectorAll('.deleteOption').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); 
                    const advertId = this.getAttribute(
                        'data-advert-id'); 

                    
                    document.getElementById('confirmDelete').setAttribute('data-advert-id',
                        advertId);

                    
                    document.getElementById('deleteModal').style.display = 'flex';
                });
            });

            // Confirm delete action
            document.getElementById('confirmDelete').addEventListener('click', function() {
                const advertId = this.getAttribute('data-advert-id'); // Get stored advert ID
                const deleteUrl = "{{ route('delete_listing', ':advert_id') }}".replace(':advert_id',
                    advertId);
                window.location.href = deleteUrl; // Redirect to the delete route
            });

            // Cancel delete action
            document.getElementById('cancelDelete').addEventListener('click', function() {
                document.getElementById('deleteModal').style.display = 'none'; // Hide modal
            });
        });
        document.querySelectorAll('.soldOption').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 
            const advertId = this.getAttribute('data-advert-id'); 

            document.getElementById('confirmSold').setAttribute('data-advert-id', advertId);
            document.getElementById('soldModal').style.display = 'flex';
        });
    });

    document.getElementById('confirmSold').addEventListener('click', function() {
        const advertId = this.getAttribute('data-advert-id'); 
        const soldUrl = "{{ route('resell_listing', ':advert_id') }}".replace(':advert_id', advertId);

        window.location.href = soldUrl; // Redirects and refreshes the page
    });


    document.getElementById('cancelSold').addEventListener('click', function() {
        document.getElementById('soldModal').style.display = 'none';
    });





        

        document.addEventListener("DOMContentLoaded", function() {
            // Select all elements with the class 'expiry-date'
            const expiryElements = document.querySelectorAll(".expiry-date");

            expiryElements.forEach(element => {
                // Get the expiry date from the data attribute
                const expiryDate = new Date(element.getAttribute("data-expiry-date"));
                const today = new Date(); // Current date
                const diffTime = expiryDate.getTime() - today.getTime(); // Difference in milliseconds
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convert to days

                // Find the status container associated with the current expiry-date element
                const statusContainer = element.closest("tr").querySelector(
                    ".status"); // Adjust selector if needed

                // Determine the text to display and update the status
                let statusText = document.createElement("span"); // Create a span for the status text
                statusText.style.fontWeight = "bold"; // Make text bold

                if (diffDays > 0) {
                    element.textContent = `${diffDays} days left`; // Future date
                    statusText.textContent = "Active"; // Set status text
                    statusText.style.color = "green"; // Set text color to green
                } else {
                    element.textContent = "Expired"; // Past date
                    statusText.textContent = "Inactive"; // Set status text to Inactive
                    statusText.style.color = "gray"; // Set text color to gray for inactive status
                    const advertId = element.closest("tr").getAttribute("data-advert-id");
                    if (advertId) {
                        fetch(`/auto-renew-payment`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        .content
                                },
                                body: JSON.stringify({
                                    advert_id: advertId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log("Payment successful");
                                } else {
                                    console.error("Payment failed", data.message);
                                }
                            })
                            .catch(error => console.error("Error during payment:", error));
                    }
                }

                if (statusContainer) {
                    statusContainer.innerHTML = "";
                    statusContainer.appendChild(statusText);
                }
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
        document.querySelectorAll('.renewPackage').forEach(function(element) {
            if (element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    let advertId = this.getAttribute('data-advert-id');
                    console.log('Advert ID:', advertId);
                    let paymentMethod = 'stripe';

                    fetch("{{ route('stripe.renew') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                advert_id: advertId,
                                payment_method: paymentMethod
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log(data))
                        .catch(error => console.log(error));
                });
            }
        });
    </script>

    <script>
        document.querySelectorAll('.cancelPackage').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                let advertId = this.getAttribute('data-advert-id');

                Swal.fire({
                    title: 'Are you sure you want to cancel the subscription?',
                    text: 'Your advert will not be published without a package subscription.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route('cancel.subscription') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    advert_id: advertId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Cancelled!', data.message);
                                } else {
                                    Swal.fire('Error!', data.message);
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error!', 'Something went wrong. Please try again.',
                                    'error');
                                console.error('Error:', error);
                            });
                    } else {
                        console.log("Subscription cancellation was canceled.");
                    }
                });
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
