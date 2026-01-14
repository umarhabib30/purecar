
   @extends('layout.superAdminDashboard')
@section('body')
    <section id="faqs-container">
       <div id="blogs-content">
            <div id="top-bar">
                <h2 id="top-heading">Inquiries</h2>
                <div class="filter-container">
                    <select id="dealerFilter" class="form-control" style="width: 200px;">
                        <option value="">All Dealers</option>
                        @foreach($dealers as $dealer)
                            <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                        @endforeach
                    </select>
                    <select id="timeFilter" class="form-control" style="width: 150px;">
                        <option value="24hours">Last 24 Hours</option>
                        <option value="7days">Last 7 Days</option>
                        <option value="1month">Last 1 Month</option>
                        <option value="all">All Time</option>
                    </select>
                </div>
            </div>
        </div>
            <table>
                <thead>
                <tr>
                   <th >Dealer</th>
                   <th >Advert Name</th>
                   <th >Full Name</th>
                   <th >Email</th>
                   <th >Phone Number</th>
                   <th >Message</th>
                   <th >Contacted At</th>
                   <th >Action</th>
                </tr>
                </thead>
                <tbody>
                 @foreach($admininquiry as $inquiry)
               <tr>

                    <td >
                                @if ($inquiry->advert && $inquiry->advert->user)
                                    {{ $inquiry->advert->user->name ?? 'N/A' }}
                                @else
                                    N/A
                                @endif

                    </td>
                   <td >{{ $inquiry->advert_name }}</td>
                   <td >{{ $inquiry->full_name }}</td>
                   <td >{{ $inquiry->email }}</td>
                   <td >{{ $inquiry->phone_number }}</td>
                   <td >{{ $inquiry->message }}</td>
                   <td>{{ $inquiry->created_at->format('d-m-Y g:ia') }}</td>
                    <td>
                        <a href="/car-for-sale/{{ $inquiry->advert && $inquiry->advert->car ? $inquiry->advert->car->slug : '#' }}"><button class="btn btn-primary">View</button></a>
                    </td>
               </tr>
               @endforeach
                </tbody>
            </table>
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
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const dealerFilter = document.getElementById('dealerFilter');
    const timeFilter = document.getElementById('timeFilter');

    // Restore scroll position
    const scrollY = localStorage.getItem('scrollY');
    if (scrollY !== null) {
        window.scrollTo(0, parseInt(scrollY));
        localStorage.removeItem('scrollY');
    }

    function applyFilters() {
        const dealerId = dealerFilter.value;
        const timePeriod = timeFilter.value;

        // Save current scroll position
        localStorage.setItem('scrollY', window.scrollY);

        // Reload with query params
        const url = new URL(window.location.href);
        url.searchParams.set('dealer_id', dealerId);
        url.searchParams.set('time_period', timePeriod);
        window.location.href = url.toString();
    }

    dealerFilter.addEventListener('change', applyFilters);
    timeFilter.addEventListener('change', applyFilters);

    // Set initial values from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    dealerFilter.value = urlParams.get('dealer_id') || '';
    timeFilter.value = urlParams.get('time_period') || 'all';
});

</script>

<style>
 #top-bar {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
#top-heading {
    margin: 0;
}
.filter-container {
    display: flex;
    gap: 10px;
}
</style>
@endsection
