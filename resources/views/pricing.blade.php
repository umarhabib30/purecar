@extends('layout.layout')
@section('body')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .package-card {
            transition: transform 0.3s ease-in-out;
            background: rgba(171, 171, 171, 0.1);
        }
        .package-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .popular-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .package-button {
            background-color: white;
            border-color: #ddd;
            color: #333;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        }
        .package-button:hover {
            background-color: #343a40;
            border-color: #343a40;
            color: white;
        }
    </style>

    <div class="container py-5">
<h2 class="text-center mb-5 d-none d-sm-block">Our Pricing</h2>

        <div class="row g-4 justify-content-center">
            @foreach($packages as $package)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 package-card border-0 shadow-sm">
                        <div class="card-body p-4">
                            @if($package->is_featured)
                                <span class="badge bg-success popular-badge">Most Popular</span>
                            @endif
                            <div class="d-flex align-items-center mb-4">
                                <h3 class="card-title h4 mb-0">{{ $package->title }}</h3>
                            </div>
                            <p class="card-text text-muted mb-4">{{ $package->description }}</p>
                             @if(strtolower($package->title) === 'dealerships')
                                <div class="mb-4">
                                    <h4 class="display-6 mb-0 text-start">Get in Touch</h4>
                                      <small class="text-muted">Duration: {{ $package->duration }} {{ Str::plural('Days', $package->duration) }}</small>
                                </div>
                            @else
                                <div class="mb-4">
                                    <h4 class="display-6 mb-0 text-start">£{{ number_format($package->price, 2) }}
                                        <span class="fs-6 text-muted">/ advert</span>
                                    </h4>
                                    <small class="text-muted">Duration: {{ $package->duration }} {{ Str::plural('Days', $package->duration) }}</small>
                                </div>
                            @endif
                            <ul class="list-unstyled mb-4">
                                @php
                                    $features = json_decode($package->features);
                                    if (json_last_error() !== JSON_ERROR_NONE || !$features) {
                                        $features = [];
                                    }
                                @endphp

                                @foreach($features as $feature)
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                                    </li>
                                @endforeach

                                @if(empty($features))
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-muted me-2"></i>No features listed
                                    </li>
                                @endif
                            </ul>

                             @if(strtolower($package->title) === 'dealerships')
                                <a href="{{ route('contact_us') }}" class="btn package-button w-100">
                                    Contact Us
                                </a>
                            @else
                             @auth
                              <a href="{{ route('stripe.payment', $package->id) }}" class="btn package-button w-100">
                                    Select Package
                                </a>
       
                            @endauth
                             @guest
                               <a href="{{ route('login') }}" class="btn package-button w-100">
                                    Select Package
                                </a>
                            @endguest
                               
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const maxShots = 1; // Set the maximum number of shots
        let shotsFired = 0;

        const confettiInterval = setInterval(() => {
            if (shotsFired >= maxShots) {
                clearInterval(confettiInterval);
                return;
            }

            confetti({
                particleCount: 200,
                angle: 90, // Launch particles straight up
                spread: 180, // Spread to cover a wide area
                startVelocity: 60, // Fast initial velocity to reach the top
                gravity: 0.8, // Simulate gravity for natural fall
                origin: { x: 0.5, y: 0.6 }, // Start from the middle bottom
                colors: ['#ff0', '#0f0', '#00f', '#f00'], // Custom vibrant colors
            });

            shotsFired++;
        }, 250);
    });
</script>
@endsection
