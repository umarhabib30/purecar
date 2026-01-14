@extends('layout.layout')
<title>Pure Car Events | Upcoming Car Meets & Shows</title>
<meta name="description" content="Stay updated on the latest car meets, auto shows, and events near you. Join the Pure Car Club community and never miss an event.">
@section('body')
<div>
        @if ($event_most_recent_one)
        <section class="container">
                <!-- Featured event latest first-->
                <section class="featured-event-section">
                    
                        <div style="position: relative">
                            <div class="hero-event-img-div">
                                <a href="{{ route('event.details', ['event' => $event_most_recent_one->slug]) }}">
                                    <img class="hero-event-img" src="{{ asset($event_most_recent_one->featured_image) }}" alt="Featured Event Image">
                                </a>
                            </div>
                            <div class="image-text-div">
    <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100%; background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent); z-index: 1;"></div>
    <h1 class="image-text-div-heading" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); position: relative; z-index: 2;">
        {{ $event_most_recent_one->title }}
    </h1>
</div>



                        </div>
                   
                </section>

                <!-- Clear separation between featured event and recent events -->
                <div class="clearfix"></div>

                <!-- Latest events below -->
                <section class="Recent-section">
                    <div>
                        <h1 style="margin-top: 10px; margin-bottom: 5px; font-size: 30px;">Recent Events</h1>
                    </div>
                    <div class="first-div">
                        @foreach($events as $event)
                            <div class="event-card">
                                <div class="event-image-container">
                                    <a href="{{ route('event.details', ['event' => $event->slug]) }}">
                                        <img src="{{ asset($event->featured_image) }}" 
                                             alt="Event Image" 
                                             class="event-image">
                                    </a>
                                </div>
                                
                                <div class="event-title-container">
                                    <h5>{{ $event->title }}</h5>
                                    <a href="{{ route('event.details', ['event' => $event->slug]) }}">
                                        <h5><i class="fas fa-arrow-up" style="color:black; rotate:45deg;"></i></h5>
                                    </a>
                                </div>
                            </div>
                        @endforeach 
                    </div>
                </section>
                <div class="row align-items-center ps-lg-3 buttons-part container pegminationbuttons">
                    <div class="p-0 col d-flex justify-content-start">
                        <!-- Previous Button -->
                        <a href="{{ $events->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                            class="btn white_color border {{ !$events->onFirstPage() ? '' : 'disabled' }}"
                            style="color: #344054">Previous</a>
                        <!-- Next Button -->
                        <a href="{{ $events->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                            class="btn white_color border ms-2 {{ $events->hasMorePages() ? '' : 'disabled' }}"
                            style="color: #344054">Next</a>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <span class="pt-2 pb-2 border white_color ps-2 pe-2" style="color: #1A1A1A;">Page
                            {{ $events->currentPage() }} of {{ $events->lastPage() }}</span>
                    </div>
                </div>
            @else
                <p style="font-size: 22px; font-weight:700; text-align:center; margin:5px 10px;">No events available.</p>
            @endif
        </section>
</div>
        <style>
            /* Clear fix to ensure sections are properly separated */
            
            
            /* Event card styles */
            .event-card {
                margin-bottom: 15px;
               
            }
            
            .event-image-container {
                width: 100%; 
                height: 200px; 
                
               
            }
            
            .event-image {
                width: 100%; 
                height: 100%;
                border-radius: 10px; 
                object-fit: cover;
            }
            
            .event-title-container {
                display: flex; 
                justify-content: space-between; 
                align-items: center; 
                margin-top: 10px;
            }
            
            /* Featured event section styles */
            .featured-event-section {
                margin-bottom: 20px;
                width: 100%;
            }
              
            @media screen and (max-width: 565px) {
                .first-div {
                    display: grid; 
                    grid-template-columns: repeat(1, 1fr); 
                    gap: 20px;
                }
            }
              
            @media screen and (max-width: 767px) {
                .hero-event-img {
                    width: 100%; 
                    height: 300px; 
                    object-fit: cover;
                }
                
                .hero-event-img-div {
                    width: 100%; 
                    height: 300px; 
                    object-fit: cover; 
                }
              
                .image-text-div {
                    position: absolute;                
                    bottom: 0px;
                    width: 100%;
                    color: white;
                    padding: 10px;
                }
                
                .image-text-div-heading {
                    font-size: 24px; 
                    margin: 0px;
                    padding: 0px;
                }
                
                .Recent-section {
                    padding: 20px;
                    margin-top: 10px;
                }
                
                .first-div {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
                    gap: 20px;
                    width: 100%;
                    max-width: 100%;
                    overflow-x: hidden;
                }
                
                .pegminationbuttons {
                    padding-left: 45px;
                }
            }
            
            @media screen and (min-width: 768px) {
                .hero-event-img {
                    width: 100%; 
                    height: 400px; 
                    object-fit: cover;                    
                    border-radius: 10px;
                }
                
                .hero-event-img-div {
                    width: 100%; 
                    height: 400px; 
                    object-fit: cover;
                    border-radius: 10px; 
                }
                
                .image-text-div {
                    position: absolute;
                    bottom: 0px;
                    /* width: 60%; */
                    width: 100%;
                    color: white;
                    padding: 20px;
                }
                
                .image-text-div-heading {
                    font-size: 30px; 
                    margin: 0px;
                    padding: 0px;
                }
                
                .first-div {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 20px;
                    width: 100%;
                    max-width: 100%;
                    overflow-x: hidden;
                }
                
                .first-div div {
                    width: 100% !important;
                }
                
                .container {
                    padding-top: 20px;
                }
                .clearfix {
                clear: both;
                height: 0px;
            }
            }              
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                function handleContainerClass() {
                    let section = document.querySelector("section.container");
                    if (section) {
                        if (window.innerWidth < 768) {
                            section.classList.remove("container");
                        } else {
                            section.classList.add("container");
                        }
                    }
                }
                handleContainerClass();
                window.addEventListener("resize", handleContainerClass);
            });
        </script>
@endsection