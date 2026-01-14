@extends('layout.superAdminDashboard')
@section('body')
<section id="DB-container" class="container">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h1>Dashboard</h1>
        <form action="{{ route('admin_dashboard') }}" method="GET" id="timeRangeForm" >
            <select class="w-auto form-select" name="timeRange">
                <option value="24_hours" {{ $timeRange === '24_hours' ? 'selected' : '' }}>24 hours</option>
                <option value="7_days" {{ $timeRange === '7_days' ? 'selected' : '' }}>7 days</option>
                <option value="1_month" {{ $timeRange === '1_month' ? 'selected' : '' }}>1 month</option>
                <option value="all_time" {{ $timeRange === 'all_time' ? 'selected' : '' }}>All Time</option>
            </select>
        </form>
    </div>
    <div class="mb-3 d-flex justify-content-end">
   
    </div>
    <div class="row g-4" style="display: flex; justify-content:center; align-items:center; margin-bottom:20px;">
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="ads-published">
            <div class="text-center">
                <h2 class="-number">{{$total_users}}</h2>
                <p>Members</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="favorited-cars">
            <div class="text-center">
                <h2 class="-number">{{$total_dealers}}</h2>
                <p>Dealers</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="reviews">
            <div class="text-center">
                <h2 class="-number">{{$total_private}}</h2>
                <p>Private</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="users">
            <div class="text-center">
                <h2 class="-number">{{ $ads_published }}</h2>
                <p>Car Adverts</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="orders">
            <div class="text-center">
                <h2 class="-number">{{$ads_expired}}</h2>
                <p>Expired</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="feedbacks">
            <div class="text-center">
                <h2 class="-number">{{ $total_email_enquiries['total'] }}</h2>
                <p>Emails</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="likes">
            <div class="text-center">
                <h2 class="-number">{{$total_payments}}</h2>
                <p>Payments</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="shares">
            <div class="text-center">
                <h2 class="-number">&dollar;{{$total_amount}}</h2>
                <p>Revenue</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="comments">
            <div class="text-center">
                <h2 class="-number">{{$total_whatsapp_call_enquiries['total']}}</h2>
                
                <p>WhatsApp + call</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="forum-visitors">
            <div class="text-center">
                <h2 class="-number">{{$total_emails_enquiries['total']}}</h2>
                <p>Successfull Inquiries</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="topics">
            <div class="text-center">
                <h2 class="-number">{{$total_topic_started}}</h2>
                <p>Topics</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 box-dashboard">
        <div class="box-inner-dashboard" id="replies">
            <div class="text-center">
                <h2 class="-number">{{$total_forum_posts}}</h2>
                <p>Replies</p>
            </div>
        </div>
    </div>
</div>

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
    <div style="height: 400px; overflow-y: auto;">
    <table >
        <thead>
            <tr>
          
                <th>Car (Inquiries)</th>
                <th>Dealer</th>
                <th>Method</th>
                <th>Buyer Email</th>
                <th>Contacted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($combined as $index => $item)
            <tr>
             
                <td>
                    @if ($item instanceof \App\Models\Inquiry)
                        {{ $item->advert_name }} ({{ \App\Models\Inquiry::where('advert_id', $item->advert_id)->count() }})
                    @else
                        {{ $item->advert->name ?? 'N/A' }} ({{ \App\Models\Counter::where('advert_id', $item->advert_id)->whereIn('counter_type', ['text', 'call'])->count() }})
                    @endif
                </td>
                <td>
                   @if ($item->advert && $item->advert->user)
                        {{ $item->advert->user->name ?? 'N/A' }} ({{ $userInquiryCounts[$item->advert->user_id] ?? 0 }})
                    @else
                        N/A
                    @endif
                </td>
                <td>
                   @if ($item instanceof \App\Models\Counter)
                        @if ($item->counter_type == 'call')
                            WhatsApp
                        @elseif ($item->counter_type == 'text')
                            Call
                        @else
                            {{ $item->counter_type }}
                        @endif
                    @else
                        Inquiry
                    @endif

                </td>
                <td>
                    @if ($item instanceof \App\Models\Inquiry)
                        {{ $item->email }}
                        <br>
                        {{ $item->phone_number }}
                    @else
              
                    @endif
                </td>
                <td>
                    {{ $item->created_at ? $item->created_at->format('d/m/y g:ia') : 'N/A' }}
                </td>
                <td>
                    <a href="/car-for-sale/{{ $item->advert && $item->advert->car ? $item->advert->car->slug : '#' }}"><button class="btn btn-primary">View</button></a>
            
            </td>
            </tr>
            @endforeach
        </tbody>
        </div>
    </table>

  
</div>

<br>
 <div style="height: 400px; overflow-y: auto; margin-bottom: 20px;">
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
<!-- Charts Section -->
<div class="row">
    <div class="col-12">
        <div class="chart-container">
            <div class="chart-title">Monthly Performance Overview</div>
            <canvas id="monthlyTrendChart"></canvas>
        </div>
    </div>
 
    <div class="col-lg-6">
        <div class="chart-container">
            <div class="chart-title">Revenue & Payments Trend</div>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="chart-container">
            <div class="chart-title">Enquiries Breakdown</div>
            <canvas id="enquiriesChart"></canvas>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="chart-container">
            <div class="chart-title">User Distribution</div>
            <canvas id="userDistributionChart"></canvas>
        </div>
    </div>
    

   
 
    <div class="col-lg-6">
        <div class="chart-container">
            <div class="chart-title">Adverts Status</div>
            <canvas id="advertsChart"></canvas>
        </div>
    </div>
    
  
 
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.querySelector('select[name="timeRange"]').addEventListener('change', function() {
        this.form.submit();
        this.options[this.selectedIndex].text = 'Loading...';
        this.disabled = true;
    });
    
   
    document.addEventListener('DOMContentLoaded', function() {
        const monthlyCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyTrendData['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                datasets: [{
                    label: 'New Users',
                    data: {!! json_encode($monthlyTrendData['users'] ?? [0, 0, 0, 0, 0, 0]) !!},
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }, {
                    label: 'New Adverts',
                    data: {!! json_encode($monthlyTrendData['adverts'] ?? [0, 0, 0, 0, 0, 0]) !!},
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }, {
                    label: 'Revenue ($)',
                    data: {!! json_encode($monthlyTrendData['revenue'] ?? [0, 0, 0, 0, 0, 0]) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    }
                }
            }
        });
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($paymentChartData['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                datasets: [{
                    label: 'Revenue ($)',
                    data: {!! json_encode($paymentChartData['revenue'] ?? [0, 0, 0, 0, 0, 0]) !!},
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Number of Payments',
                    data: {!! json_encode($paymentChartData['count'] ?? [0, 0, 0, 0, 0, 0]) !!},
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Number of Payments'
                        }
                    }
                }
            }
        });
        
        const userCtx = document.getElementById('userDistributionChart').getContext('2d');
        const userChart = new Chart(userCtx, {
            type: 'doughnut',
            data: {
                labels: ['Dealers', 'Private Sellers'],
                datasets: [{
                    data: [
                        {{ $total_dealers }}, 
                        {{ $total_private }}
                 
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                        
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        // Enquiries Breakdown Chart
        const enquiriesCtx = document.getElementById('enquiriesChart').getContext('2d');
        const enquiriesChart = new Chart(enquiriesCtx, {
            type: 'bar',
            data: {
                labels: ['Call', 'Text', 'Email'],
                datasets: [{
                    label: 'Number of Enquiries',
                    data: [
                        {{ $total_enquiries['call'] ?? 0 }}, 
                        {{ $total_enquiries['text'] ?? 0 }}, 
                        {{ $total_enquiries['email'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
        
        // Adverts Status Chart
        const advertsCtx = document.getElementById('advertsChart').getContext('2d');
        const advertsChart = new Chart(advertsCtx, {
            type: 'pie',
            data: {
                labels: ['Active', 'Expired'],
                datasets: [{
                    data: [
                        {{ $ads_published - $ads_expired }}, 
                        {{ $ads_expired }}
                    ],
                    backgroundColor: [
                        'rgba(46, 204, 113, 0.7)',
                        'rgba(231, 76, 60, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        
    });
</script>
</section>
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

    
        localStorage.setItem('scrollY', window.scrollY);


        const url = new URL(window.location.href);
        url.searchParams.set('dealer_id', dealerId);
        url.searchParams.set('time_period', timePeriod);
        window.location.href = url.toString();
    }

    dealerFilter.addEventListener('change', applyFilters);
    timeFilter.addEventListener('change', applyFilters);

   
    const urlParams = new URLSearchParams(window.location.search);
    dealerFilter.value = urlParams.get('dealer_id') || '';
    timeFilter.value = urlParams.get('time_period') || 'all';
});

</script>

<style>


        @media screen and (max-width: 576px) {
            .box-dashboard{
                max-width: 180px;
            }
        }
        @media screen and (max-width: 399px) {
            .box-dashboard{
                max-width: 172px;
            }
        }
        .box-inner-dashboard{
            background-color: white;
            padding:5px;
            border:1px solid rgb(196, 192, 192);
            border-radius: 10px;
        }
        .chart-container {
            background-color: white;
            padding: 15px;
            border: 1px solid rgb(196, 192, 192);
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .chart-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

         #top-bar {
    margin-bottom: 10px;
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