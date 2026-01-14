@extends('layout.dashboard')
@section('body')

<section id="DB-container">
        <h1 class="Dashboard-title">{{ $title }}</h1>
        <div id="row-1-container">
            <div class="row-1-card" id="ads-published">
                <div class="card-title" onclick="window.location.href='{{ route('my_listing') }}'" style="cursor: pointer;">
                    <div class="card-icon">
                        <img src="assets/statistics/ads-published.png" alt="Icon">
                    </div>
                    <div class="card-title-container" >
                        <h2 class="card-number">{{ $ads_published }}</h2>
                        <p>Ads</p>
                    </div>
                </div>
               
            </div>
            <div class="row-1-card" id="favorited-cars" onclick="window.location.href='{{url('/advert/showfavorite')}}'" style="cursor: pointer;">
                <div class="card-title">
                    <div class="card-icon">
                        <img src="assets/statistics/cars.png" alt="Icon">
                    </div>
                    <div class="card-title-container">
                        <h2 class="card-number">{{ $favorite_ads }}</h2>
                        <p>Favourites</p>
                    </div>
                </div>
            </div>
            <div class="row-1-card" id="reviews">
            @if ($role === 'car_dealer')
            <div class="card-title" onclick="window.location.href='{{ url('/dealer-profile/' . $user_slug) }}'" style="cursor: pointer;">                    <div class="card-icon">
                        <img src="assets/statistics/reviews.png" alt="Icon">
                    </div>
                    <div class="card-title-container">
                        <h2 class="card-number">{{ $total_reviews }}</h2>
                        <p>Reviews</p>
                    </div>
                </div>
            @elseif ($role === 'private_seller')
                <div class="card-title"onclick="window.location.href='{{ url('/private_seller') }}'" style="cursor: pointer;">
                    <div class="card-icon">
                        <img src="assets/statistics/reviews.png" alt="Icon">
                    </div>
                    <div class="card-title-container">
                        <h2 class="card-number">{{ $user_id * 76 }}</h2>
                        <p>Membership</p>
                    </div>
                </div>
            @endif
            <div class="card-footer">
                @if ($role === 'car_dealers')
                    <!-- <p class="growth"><img src="assets/statistics/arrow-top-right.png"> 0%</p>
                    <p class="since">since last month</p> -->
                @elseif ($role === 'private_users')
                    <p class="growth"><img src="assets/statistics/arrow-top-right.png"> N/A</p>
                    <p class="since">Membership based value</p>
                @endif
            </div>
         </div>

        </div>

        <div id="row-2-container">
            <div class="row-2-card" id="activities-stats">
                <div class="card-header">
                    <h3>Daily Enquiries</h3>

                 
                <!-- Button trigger for desktop -->
                <div class="dropdown d-none d-md-block">
    <button class="btn btn-secondary" type="button" id="pageViewDropdown"
        data-bs-toggle="dropdown" aria-expanded="false"
        style="width: 200px; text-align: left; padding-right: 0px; white-space: nowrap; position: relative; visibility: hidden;">
        Select Car 
    </button>
    <button class="btn btn-secondary dropdown-toggle" 
        type="button" 
        data-bs-toggle="modal" 
        data-bs-target="#carSelectModal"
        style="width: 200px; text-align: left; padding-right: 0px; white-space: nowrap; position: relative;">
        
        <span class="car-selected-label text-truncate d-block" style="max-width: calc(100% - 20px);">
           @if(count($advertname) > 0 && $advertname[0]->car)
                {{ $advertname[0]->car->make }} {{ $advertname[0]->car->model }}
            @else
                Select Car
            @endif

        </span>
    </button>
    <ul class="dropdown-menu overflow-auto" aria-labelledby="pageViewDropdown"
        style="width: 200px; min-width: 200px; max-height: 200px; overflow-y: auto;">
        @foreach($advertname as $advert)
            <li>
                <a class="dropdown-item car-select-item" href="javascript:void(0)"
                     data-car="{{ optional($advert->car)->make }} {{ optional($advert->car)->model }}"
                    data-advert-id="{{ $advert->advert_id }}"
                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-right: 20px; background-image: none !important;">
                    {{ optional($advert->car)->make }} {{ optional($advert->car)->model }} {{ optional($advert->car)->year }}
                </a>
            </li>
        @endforeach
    </ul>
</div>


<!-- Mobile button -->

<button class="btn btn-secondary btn-sm d-md-none dropdown-toggle position-relative" 
    type="button" 
    data-bs-toggle="modal" 
    data-bs-target="#carSelectModal"
    style="width: 150px; text-align: left; padding-right: 20px;">
    
    <span class="car-selected-label text-truncate d-block" style="max-width: calc(100% - 20px);">
       @if(count($advertname) > 0 && $advertname[0]->car)
            {{ $advertname[0]->car->make }} {{ $advertname[0]->car->model }}
        @else
            Select Car
        @endif

    </span>
</button>

<!-- Mobile Modal -->
<div class="modal fade " id="carSelectModal" tabindex="-1" aria-labelledby="carSelectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered carSelect">
        <div class="modal-content rounded-4 carSelect" style="max-height: 80vh;">
            <div class="modal-body p-0">
                <div class="list-group list-group-flush" style="max-height: 70vh; overflow-y: auto;">
                <a href="javascript:void(0)" 
                        class="list-group-item list-group-item-action car-select-item dropdown-item"
                        data-car="Show All"
                        data-advert-id="all"
                        data-bs-dismiss="modal"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-right: 20px; background-image: none !important; font-weight: bold;">
                        View All
                    </a>
                    @foreach($advertname as $advert)
                        <a href="javascript:void(0)" 
                            class="list-group-item list-group-item-action car-select-item dropdown-item"
                            data-car="{{ optional($advert->car)->make }} {{ optional($advert->car)->model }}"
                            data-advert-id="{{ $advert->advert_id }}"
                            data-bs-dismiss="modal"
                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-right: 20px; background-image: none !important;">
                            {{ optional($advert->car)->make }} {{ optional($advert->car)->model }} {{ optional($advert->car)->year }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.btn.dropdown-toggle::after {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
}
</style>


<style>
@media (max-width: 767.98px) {
    
    .modal-dialog {
        display: flex !important;
    align-items: center;
    justify-content: center;
    min-height: 100vh; /* Ensure full height for centering */
    }
    
    .modal-content {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .list-group-item {
    padding: 20px;
    border-left: none;
    border-right: none;
    display: flex;
    justify-content: start;
    align-items: center; 
}
    
    .list-group-item:first-child {
        border-top: none;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
    }
}
@media (min-width: 769px) {
    .carSelect{
        width: 500px  !important;
    }
    .modal-dialog {
        display: flex !important;
    align-items: center;
    justify-content: center;
    min-height: 100vh; /* Ensure full height for centering */
    }
    
    .modal-content {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .list-group-item {
    padding: 20px;
    border-left: none;
    border-right: none;
    display: flex;
    justify-content: start;
    align-items: center; 
}
    
    .list-group-item:first-child {
        border-top: none;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carSelectItems = document.querySelectorAll('.car-select-item');
    const mobileButton = document.querySelector('[data-bs-target="#carSelectModal"]');

    // Pre-select first item if available
    if (carSelectItems.length > 0) {
        const firstCar = carSelectItems[0].dataset.car;
        mobileButton.querySelector('.text-truncate').textContent = firstCar;
    }

    carSelectItems.forEach(item => {
        item.addEventListener('click', function() {
            const carName = this.dataset.car;
            const advertId = this.dataset.advertId;
            
            mobileButton.querySelector('.text-truncate').textContent = carName;
            
            console.log('Selected car:', carName, 'Advert ID:', advertId);
        });
    });
});
</script>






                </div>
                <div class="chart-container">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
            <div class="row-2-card" id="activities-stats-pie">
                <div>


                <div id="pie-container-1">
                    <div id="pie-chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="pie-title-container">
                    @php
                        $userId = auth()->id();
                        $currentMonth = \Carbon\Carbon::now()->month;
                        $previousMonth = \Carbon\Carbon::now()->subMonth()->month;

                        $allowedTypes = ['emailsu', 'text', 'call'];

                        // Step 1: Get all advert IDs that belong to this user
                        $userAdvertIds = \App\Models\Advert::where('user_id', $userId)->pluck('advert_id');

                        // Step 2: Filter counters that belong to those adverts and have allowed types
                        $currentMonthCount = $counters->filter(function ($counter) use ($userAdvertIds, $currentMonth, $allowedTypes) {
                            return $userAdvertIds->contains($counter->advert_id) &&
                                \Carbon\Carbon::parse($counter->created_at)->month == $currentMonth &&
                                in_array($counter->counter_type, $allowedTypes);
                        })->count();

                        $previousMonthCount = $counters->filter(function ($counter) use ($userAdvertIds, $previousMonth, $allowedTypes) {
                            return $userAdvertIds->contains($counter->advert_id) &&
                                \Carbon\Carbon::parse($counter->created_at)->month == $previousMonth &&
                                in_array($counter->counter_type, $allowedTypes);
                        })->count();

                        $growth = $previousMonthCount > 0 ? (($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100 : 0;
                        $growthFormatted = number_format($growth, 2);
                    @endphp

                        <h2 class="pie-number">{{ $currentMonthCount }} total</h2>
                        <p style="color: #848B9D; font-size: 16px;">{{ \Carbon\Carbon::now()->format('F') }} Inquiries</p>
                        <p class="growth" style="color: {{ $growth >= 0 ? 'green' : 'red' }};">
                            @if($growth >= 0)
                                +{{ $growthFormatted }}%
                            @else
                                {{ $growthFormatted }}%
                            @endif
                            <img src="assets/statistics/{{ $growth >= 0 ? 'Arrow-gr.png' : 'Arrow-red.png' }}" alt="Growth Icon">
                        </p>
                    </div>


                </div>
                <div id="pie-container-2">
                    <div class="legend-item">
                    @php
                        $calls = $counters->filter(fn($c) => $userAdvertIds->contains($c->advert_id) && \Carbon\Carbon::parse($c->created_at)->month == $currentMonth && $c->counter_type === 'call')->count();
                        $texts = $counters->filter(fn($c) => $userAdvertIds->contains($c->advert_id) && \Carbon\Carbon::parse($c->created_at)->month == $currentMonth && $c->counter_type === 'text')->count();
                        $emails = $counters->filter(fn($c) => $userAdvertIds->contains($c->advert_id) && \Carbon\Carbon::parse($c->created_at)->month == $currentMonth && $c->counter_type === 'emailsu')->count();
                    @endphp


                        <div class="legend-color" style="background-color: #f5a623;"></div>
                        <span>Whatsapp: {{ $calls }}</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #333;"></div>
                        <span>Call: {{ $texts }}</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #3fa3ff;"></div>
                        <span>Emails: {{ $emails }}</span>
                    </div>
                </div>


                </div>
                <div id="pie-container-3">
                    <div class="pie-3-subcontainer">
                        <h3>{{ $total_forum_posts ?? 0 }}</h3>
                        <p style="color: #848B9D; font-size: 12px;">Forum Posts</p>
                        <p class="{{ $forum_graph_class }}" style="margin-top: -6px;">
                            {{ $forum_percentage }} <img src="assets/statistics/{{ $forum_graph_icon }}" alt="Graph Icon">
                        </p>
                        <!-- <img src="assets/statistics/{{ $forum_graph_image }}" alt="" style="padding-top: 7px;"> -->
                    </div>
                    <div class="pie-3-subcontainer">
                        <h3>{{ $total_topic_started ?? 0 }}</h3>
                        <p style="color: #848B9D; font-size: 12px;">Topics started</p>
                        <p class="{{ $topic_graph_class }}" style="margin-top: -6px;">
                            {{ $topic_percentage }}
                            <img src="assets/statistics/{{ $topic_graph_icon }}" alt="Graph Icon">
                        </p>
                        <!-- <img src="assets/statistics/{{ $topic_graph_image }}" alt="" style="padding-top: 7px;"> -->
                    </div>
                </div>
            </div>
        </div>

        <div id="row-3-container">
            <div class="row-3-card" id="page-view">
                <div class="card-header">
                    <h3>Advertisement Views</h3>
                </div>
                <div class="chart-container">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <div class="row-3-card" id="activities">
                <h3>Notifications</h3>
                <ul class="activity-list">
                    @if($all_activities->isEmpty())
                    <li class="no-activity-container d-flex flex-column justify-content-center align-items-center text-center">
                        <div class="no-activity-img">
                            <img src="assets/nonotification.png" alt="No Notifications Icon" class="img-fluid">
                        </div>

                        <div class="no-activity-message mt-3">
                            <p>No new notifications at the moment!</p>
                        </div>
                    </li>

                    @else
                    @foreach($all_activities as $activity)
                        <li class="activity-container">
                            <div class="activity-img">
                                @if($activity->activity_type == 'forum_reply')
                                    <img src="assets/forumreply.jpg" alt="Forum Reply Icon" style="width: 40px; height: 40px; object-fit: cover;">
                                @elseif($activity->activity_type == 'ad')
                                    <img src="assets/forumcar.jpg" alt="Advertisement Icon" style="width: 40px; height: 40px; object-fit: cover;">
                                @elseif($activity->activity_type == 'adexpired')
                                    <img src="assets/forumcar.jpg" alt="Advertisement Icon" style="width: 40px; height: 40px; object-fit: cover;">
                                @elseif($activity->activity_type == 'favorite')
                                    <img src="assets/forumfavourite.jpg" alt="Favorite Icon" style="width: 40px; height: 40px; object-fit: cover;">
                                @elseif($activity->activity_type == 'review')
                                    <img src="assets/forumreview.jpg" alt="Review Icon" style="width: 40px; height: 40px; object-fit: cover;">
                                @endif
                            </div>


                            <div class="activity-main">
                                @if($activity->activity_type == 'forum_reply')
                                    <p>
                                        <a href="{{ route('forum.topic.show', ['slug' => $activity->post_slug]) }}" class="text-decoration-none text-dark">
                                        @php
                                            $topicTitle = html_entity_decode($activity->topic_title);
                                            $topicTitle = strip_tags($topicTitle);
                                        @endphp

                                        Forum: <strong>{{ $activity->replier_name }}</strong> replied to your topic "<strong>{{ $topicTitle }}</strong>"
                                        </a>
                                    </p>
                                @elseif($activity->activity_type == 'ad')
                                    <p>
                                        <a href="{{ route('advert_detail', ['slug' => $activity->car_slug]) }}" class="text-decoration-none text-dark">
                                        Your advert:
                                        <strong>{{ $activity->car_make }} {{ $activity->car_model }} {{ $activity->car_year }}</strong>

                                        </a>
                                        has been published.
                                    </p>
                                @elseif($activity->activity_type == 'adexpired')
                                    <p>
                                        Your advert:
                                        <a href="{{ route('advert_detail', ['slug' => $activity->car_slug]) }}" class="text-decoration-none text-dark">
                                        <strong>{{ $activity->car_make }} {{ $activity->car_model }} {{ $activity->car_year }}</strong>

                                        </a> has expired.

                                        <a href="{{ route('my_listing') }}" class="text-success">
                                            Renew now
                                        </a>

                                    </p>
                                @elseif($activity->activity_type == 'favorite')
                                    <p>
                                    <a href="{{ route('advert_detail', ['slug' => $activity->car_slug]) }}"
                                    class="text-decoration-none text-dark">
                                        Liked:
                                        <strong>{{ $activity->user_name }}</strong> has favourited your advert

                                            <strong>{{ $activity->car_make }} {{ $activity->car_model }} {{ $activity->car_year }}</strong>
                                        </a>
                                    </p>
                                @elseif($activity->activity_type == 'review')
                                    <p>
                                        <a href="{{ route('dealer.profile', ['slug' => $activity->user_slug]) }}"
                                        class="text-decoration-none text-dark">
                                        Review: You got a new review from
                                        <strong>{{ $activity->reviewer_name }}</strong>
                                            <span>"{{ \Illuminate\Support\Str::words($activity->review_content, 5, '...') }}"</span>
                                        </a>
                                    </p>
                                @endif
                                <p class="activity-time">{{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y / g:ia') }}</p>

                            </div>
                            <hr class="activity-divider">
                        </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>


        <!-- verification model  -->
        <!-- if ($email_verified_at === null)
        <div id="verificationModal" class="modal">
            <div class="modal-content">
                <img src="{{asset('assets/verifyemail.png')}}" alt="Please verify your email" class="modal-icon">

                <p><strong>Verify Your Account</strong></p>
                <p><strong>{{$email}}</strong></p>
                <p>Please go to your emails and verify your account. if the email is not there, please check your spam folder.</p>
                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <button type="submit" id="resendBtn" class="btn btn-dark">
                        Resend Email
                    </button>
                    <div id="timer" class="timer" style="display: none;">
                        Resend in <span id="countdown">60</span>s
                    </div>
                </form>


            </div>
        </div>
        endif -->

    </section>
    <style>


/* Button and Timer Styles */
.button-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 40px; /* Adjust based on your button height */
    margin-top: 15px;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s;
    text-align: center;
    justify-content: center;
    align-items: center;
}

.btn-dark {
    background-color: #343a40;
    color: white;
    text-align: center;
    justify-content: center;
    align-items: center;
}

.btn-dark:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
    justify-content: center;
    align-items: center;
}

.timer {
    font-size: 14px;
    color: #6c757d;
    text-align: center;
}

</style>

<script>


document.getElementById('resendForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const button = document.getElementById('resendBtn');
    const timer = document.getElementById('timer');

    // Disable button and show timer
    button.style.display = 'none';
    timer.style.display = 'block';

    // Start countdown
    let timeLeft = 60;
    const countdownElement = document.getElementById('countdown');

    const updateTimer = setInterval(() => {
        timeLeft--;
        countdownElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(updateTimer);
            button.style.display = 'block';
            timer.style.display = 'none';
        }
    }, 1000);

    // Submit the form
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Verification email sent successfully!');
        } else {
            showToast(data.error || 'Failed to send verification email');
            // Reset timer if failed
            clearInterval(updateTimer);
            button.style.display = 'block';
            timer.style.display = 'none';
        }
    })
    .catch(error => {
        showToast('An error occurred. Please try again.');
        // Reset timer if error
        clearInterval(updateTimer);
        button.style.display = 'block';
        timer.style.display = 'none';
    });
});

// Store timer state in localStorage to persist across page reloads
window.addEventListener('load', function() {
    const timerEndTime = localStorage.getItem('verificationTimerEnd');
    if (timerEndTime) {
        const timeLeft = Math.ceil((parseInt(timerEndTime) - Date.now()) / 1000);
        if (timeLeft > 0) {
            const button = document.getElementById('resendBtn');
            const timer = document.getElementById('timer');
            button.style.display = 'none';
            timer.style.display = 'block';

            const countdownElement = document.getElementById('countdown');
            const updateTimer = setInterval(() => {
                const newTimeLeft = Math.ceil((parseInt(timerEndTime) - Date.now()) / 1000);
                if (newTimeLeft <= 0) {
                    clearInterval(updateTimer);
                    timer.style.display = 'none';
                    button.style.display = 'block';
                    localStorage.removeItem('verificationTimerEnd');
                } else {
                    countdownElement.textContent = newTimeLeft;
                }
            }, 1000);
        }
    }
});
</script>
    <style>
        /* Ensure modal is visible and centered */
#verificationModal {
    display: flex; /* Hidden by default */
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    z-index: 9999; /* Ensure the modal appears above all other content */
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 300px; /* Set the modal width */
    box-sizing: border-box; /* Make padding included in the width */
}

.modal-icon {
    width: 80px;
    height: 80px;
    margin-bottom: 20px;
}



    </style>
<script>
   document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('pieChart').getContext('2d');

    let callCount = {{ $counters->where('counter_type', 'call')->count() }};
    let textCount = {{ $counters->where('counter_type', 'text')->count() }};
    let emailCount = {{ $counters->where('counter_type', 'emailsu')->count() }};


    if (callCount === 0 && textCount === 0 && emailCount === 0) {
        callCount = textCount = emailCount = 1; // Set equal dummy values
    }

    const data = {
        labels: ['Calls', 'Text', 'Emails'],
        datasets: [{
            data: [callCount, textCount, emailCount],
            backgroundColor: ['#f5a623', '#333', '#3fa3ff'],
            hoverOffset: 4,
            borderWidth: 0
        }]
    };

    const options = {
        plugins: {
            legend: {
                display: false
            }
        },
        responsive: true,
        maintainAspectRatio: false,
    };

    new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });
});


</script>
<script>



document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('activityChart').getContext('2d');
    let myChart;

    // Function to get the last 14 days in "DD/MM/YYYY" format
    const getLast14Days = () => {
        const days = [];
        const today = new Date();
        for (let i = 13; i >= 0; i--) {
            const date = new Date(today);
            date.setDate(today.getDate() - i);
            const formattedDate = `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}`;
            days.push(formattedDate);
        }
        return days;
    };

    const days = getLast14Days();

    const initializeChart = (callsData, textsData, emailsData) => {
        const defaultData = new Array(14).fill(0);

        const data = {
            labels: days,
            datasets: [
                {
                    label: 'Whatsapp',
                    data: callsData.length ? callsData : defaultData,
                    borderColor: '#f5a623',
                    tension: 0.4,
                    fill: false,
                },
                {
                    label: 'Calls',
                    data: textsData.length ? textsData : defaultData,
                    borderColor: '#3fa3ff',
                    tension: 0.4,
                    fill: false,
                },
                {
                    label: 'Emails',
                    data: emailsData.length ? emailsData : defaultData,
                    borderColor: '#333',
                    tension: 0.4,
                    fill: false,
                }
            ]
        };

        const options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                    position: 'top',
                },
               tooltip: {
            mode: 'index',
            intersect: false,
            
            padding: 12, // Increase padding inside the tooltip
            bodyFont: {
                size: 16, // Increase font size for dataset labels (WhatsApp, Calls, Emails)
            },
            titleFont: {
                size: 16, // Increase font size for the title (e.g., date)
            },
            backgroundColor: 'rgba(0, 0, 0, 0.8)', // Optional: Adjust background for visibility
            cornerRadius: 6, // Optional: Adjust corner radius for a smoother look
            caretSize: 8, // Optional: Size of the caret (pointer) of the tooltip
            boxPadding: 6, // Optional: Padding between tooltip items
        },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        maxRotation: 0, 
                        minRotation: 0,
                        callback: (value, index) => {
                            // Display every 5th day
                            return index % 5 === 0 ? days[index] : '';
                        },
                    }
                },
                y: {
                    ticks: {
                        stepSize: 5,
                    },
                    grid: {
                        drawTicks: false,
                        drawBorder: false,
                    },
                },
            },
        };

        if (myChart) {
            myChart.data = data;
            myChart.update();
        } else {
            myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: options,
            });
        }
    };


    initializeChart([], [], []);

    // Event listener for dropdown selection
    document.querySelectorAll('.car-select-item').forEach(item => {
        item.addEventListener('click', (e) => {
            const advertId = e.target.dataset.advertId;

            // Make an AJAX request to fetch data
            const url = advertId === 'all' 
                ? '/get-all-daily-counters' 
                : `/get-daily-counters?advert_id=${advertId}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const { calls, texts, emails } = data;
                    initializeChart(calls, texts, emails);
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });

    // Automatically trigger the first dropdown item when the page loads
//     const firstDropdownItem = document.querySelector('.dropdown-item');
//     if (firstDropdownItem) {
//         const firstAdvertId = firstDropdownItem.dataset.advertId;
//         fetch(`/get-daily-counters?advert_id=${firstAdvertId}`)
//             .then(response => response.json())
//             .then(data => {
//                 const { calls, texts, emails } = data;
//                 initializeChart(calls, texts, emails);
//             })
//             .catch(error => console.error('Error fetching data for the first car:', error));
//     }
// });
// Automatically trigger the "Show All" option when the page loads
const showAllOption = document.querySelector('.car-select-item[data-advert-id="all"]');
        if (showAllOption) {
            const dropdownButtons = document.querySelectorAll('.dropdown-toggle, .btn-secondary');
            dropdownButtons.forEach(button => {
            const span = button.querySelector('span');
            if (span) {
                span.textContent = 'View All';
            }
        });
        fetch('/get-all-daily-counters')
            .then(response => response.json())
            .then(data => {
                const { calls, texts, emails } = data;
                initializeChart(calls, texts, emails);
            })
            .catch(error => console.error('Error fetching data for all adverts:', error));
    }
});

</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('lineChart').getContext('2d');
    const dropdown = document.getElementById('pageViewDropdown');
    const items = document.querySelectorAll('.dropdown-item');
    let chart;

    // Function to format date as "DD-MM-YYYY"
    const formatDate = (date) => {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        return `${day}/${month}`;
    };

    // Function to create the chart (initial or updated)
    function createChart(labels, data) {
        if (chart) {
            chart.destroy();
        }

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Page Views',
                    data: data,
                    borderColor: '#6a5bff',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6a5bff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    tension: 0.4,
                    spanGaps: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                     tooltip: {
            mode: 'index',
            intersect: false,
            
            padding: 12, // Increase padding inside the tooltip
            bodyFont: {
                size: 16, // Increase font size for dataset labels (WhatsApp, Calls, Emails)
            },
            titleFont: {
                size: 16, // Increase font size for the title (e.g., date)
            },
            backgroundColor: 'rgba(0, 0, 0, 0.8)', // Optional: Adjust background for visibility
            cornerRadius: 6, // Optional: Adjust corner radius for a smoother look
            caretSize: 8, // Optional: Size of the caret (pointer) of the tooltip
            boxPadding: 6, // Optional: Padding between tooltip items
        },
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0, 
                            minRotation: 0,
                            callback: (value, index) => {
                                return index % 5 === 0 ? labels[index] : '';
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#eaeaea'
                        },
                        ticks: {
                            callback: (value) => value,
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Function to initialize the chart with zero data
    function initializeChart() {
        const now = new Date();
        const labels = [];
        const data = new Array(14).fill(0);

        for (let i = 13; i >= 0; i--) {
            const date = new Date(now);
            date.setDate(now.getDate() - i);
            labels.push(formatDate(date));
        }

        createChart(labels, data);
    }

    // Function to update chart with real data
    function updateChart(advertId) {
        const url = advertId === 'all' 
            ? '/fetch-all-page-views' 
            : `/fetch-page-views/${advertId}`;

        fetch(url)
            .then(response => response.json())
            .then(pageViews => {
                const groupedData = {};
                const now = new Date();
                const days = [];

                // Initialize the last 14 days with zero counts
                for (let i = 13; i >= 0; i--) {
                    const date = new Date(now);
                    date.setDate(now.getDate() - i);
                    const dayLabel = formatDate(date);
                    groupedData[dayLabel] = 0;
                    days.push(dayLabel);
                }

                // Group the data by day
                pageViews.forEach(view => {
                    const createdAt = new Date(view.created_at);
                    const dayLabel = formatDate(createdAt);
                    if (groupedData[dayLabel] !== undefined) {
                        groupedData[dayLabel] += 1;
                    }
                });

                const labels = days;
                const data = days.map(day => groupedData[day]);

                createChart(labels, data);
            })
            .catch(error => console.error('Error fetching page views:', error));
    }

    // Event listeners for dropdown items
    items.forEach(item => {
        item.addEventListener('click', function () {
            const selectedCar = this.getAttribute('data-car');
            const advertId = this.getAttribute('data-advert-id');

            // Update dropdown button text
            const truncatedText = selectedCar.length > 15 
                ? selectedCar.substring(0, 12) + '...' 
                : selectedCar;
            dropdown.textContent = truncatedText;

            // Fetch and update chart
            updateChart(advertId);
        });
    });

    // Initialize with "Show All" option by default
    const showAllOption = document.querySelector('.dropdown-item[data-advert-id="all"]');
    if (showAllOption) {
        dropdown.textContent = 'View All';
        updateChart('all');
    } else if (items.length > 0) {
        // Fallback to first item if "Show All" doesn't exist
        const firstItem = items[0];
        const firstCar = firstItem.getAttribute('data-car');
        const firstAdvertId = firstItem.getAttribute('data-advert-id');
        dropdown.textContent = firstCar;
        updateChart(firstAdvertId);
    } else {
        initializeChart();
    }
});
//     document.addEventListener('DOMContentLoaded', () => {
//     const ctx = document.getElementById('lineChart').getContext('2d');
//     const dropdown = document.getElementById('pageViewDropdown');
//     const items = document.querySelectorAll('.dropdown-item');
//     let chart;

//     // Function to format date as "DD-MM-YYYY"
//     const formatDate = (date) => {
//         const day = String(date.getDate()).padStart(2, '0');
//         const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
//         const year = date.getFullYear();
//         return `${day}/${month}`;
//     };

//     // Function to create the chart (initial or updated)
//     function createChart(labels, data) {
//         if (chart) {
//             chart.destroy(); // Destroy existing chart before creating a new one
//         }

//         chart = new Chart(ctx, {
//             type: 'line',
//             data: {
//                 labels: labels,
//                 datasets: [{
//                     label: 'Daily Page Views',
//                     data: data,
//                     borderColor: '#6a5bff',
//                     backgroundColor: 'transparent',
//                     pointBackgroundColor: '#fff',
//                     pointBorderColor: '#6a5bff',
//                     pointBorderWidth: 2,
//                     pointRadius: 5,
//                     tension: 0.4,
//                     spanGaps: true, // Ensure the line remains continuous even with missing data
//                 }]
//             },
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: false,
//                 plugins: {
//                     legend: {
//                         display: false
//                     }
//                 },
//                 scales: {
//                     x: {
//                         grid: {
//                             display: false
//                         },
//                         ticks: {
//                             maxRotation: 0, 
//                             minRotation: 0,
//                             callback: (value, index) => {
//                                 return index % 5 === 0 ? labels[index] : '';
//                             }
//                         }
//                     },
//                     y: {
//                         grid: {
//                             color: '#eaeaea'
//                         },
//                         ticks: {
//                             callback: (value) => value,
//                         },
//                         beginAtZero: true
//                     }
//                 }
//             }
//         });
//     }

//     // Function to initialize the chart with zero data
//     function initializeChart() {
//         const now = new Date();
//         const labels = [];
//         const data = new Array(30).fill(0); // Array with 30 zeros

//         for (let i = 13; i >= 0; i--) {
//             const date = new Date(now);
//             date.setDate(now.getDate() - i);
//             labels.push(formatDate(date));
//         }

//         createChart(labels, data);
//     }

//     // Function to update chart with real data
//     function updateChart(advertId) {
//         fetch(`/fetch-page-views/${advertId}`)
//             .then(response => response.json())
//             .then(pageViews => {
//                 const groupedData = {};
//                 const now = new Date();
//                 const days = [];

//                 // Initialize the last 30 days with zero counts
//                 for (let i = 13; i >= 0; i--) {
//                     const date = new Date(now);
//                     date.setDate(now.getDate() - i);
//                     const dayLabel = formatDate(date);
//                     groupedData[dayLabel] = 0;
//                     days.push(dayLabel);
//                 }

//                 // Group the data by day
//                 pageViews.forEach(view => {
//                     const createdAt = new Date(view.created_at);
//                     const dayLabel = formatDate(createdAt);
//                     if (groupedData[dayLabel] !== undefined) {
//                         groupedData[dayLabel] += 1;
//                     }
//                 });

//                 const labels = days;
//                 const data = days.map(day => groupedData[day]);

//                 createChart(labels, data);
//             })
//             .catch(error => console.error('Error fetching page views:', error));
//     }

  

//     items.forEach(item => {
//         item.addEventListener('click', function () {
//             const selectedCar = this.getAttribute('data-car');
//             const advertId = this.getAttribute('data-advert-id'); // Get advert ID

//             // Limit text to 100 characters
//             const truncatedText = selectedCar.length > 15 ? selectedCar.substring(0, 12) + '...' : selectedCar;

//             // Update dropdown button text
//             dropdown.textContent = truncatedText;

//             // Fetch and update chart
//             updateChart(advertId);
//         });
//     });

//     // Initialize with the first car in the dropdown (if exists)
//     const firstItem = document.querySelector('.dropdown-item');
//     if (firstItem) {
//         const firstCar = firstItem.getAttribute('data-car');
//         const firstAdvertId = firstItem.getAttribute('data-advert-id');

//         // Set dropdown text to the first car
//         dropdown.textContent = firstCar;

//         // Fetch and update chart with the first car's data
//         updateChart(firstAdvertId);
//     } else {
//         // If no items exist, initialize an empty chart
//         initializeChart();
//     }
// });


</script>
<script>
document.querySelectorAll('.car-select-item').forEach(item => {
    item.addEventListener('click', function () {
        const selectedCar = this.getAttribute('data-car');

       
        document.querySelectorAll('.car-selected-label').forEach(label => {
            label.textContent = selectedCar;
        });

    });
});
</script>


<style>
    .activity-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.activity-container {
    display: flex;
    align-items: center;
    padding: 15px 0;
}

.activity-img {
    margin-right: 15px;
}

.activity-img img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.activity-main p {
    margin: 0;
    font-size: 14px;
}

.activity-time {
    font-size: 12px;
    color: gray;
}

.activity-divider {
    border: 0;
    border-top: 1px solid #ccc;
    margin: 10px 0;
}

    #pageViewDropdown::after {
        content: '\25BC'; /* Unicode for a downward arrow */
        font-size: 14px;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none; /* Ensures it doesn't interfere with button functionality */
    }
    @media (max-width: 767px) {
        body{
            background: #f5f6fa;
        }
    }

</style>
@endsection
