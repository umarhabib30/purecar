@extends('layout.layout')
<title>{{ $blog->title }} | Pure Car Blog</title>

<meta name="robots" content="noindex, nofollow">

<meta name="description" content="{{ Str::limit(strip_tags($blog->content), 160, '') }}">
<!-- facebook tags  -->
<meta property="og:title" content="{{ $meta_title }}" />
<meta property="og:description" content="{{ $meta_description }}" />
<meta property="og:image" content="{{ $meta_image }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="{{ $meta_type }}" />
<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $meta_title }}">
<meta name="twitter:description" content="{{ $meta_description }}">
<meta name="twitter:image" content="{{ $meta_image }}">
@section('body')

<section class="pt-5 BlogSection">
    <div class="container">
    <div id="copy-message" class="alert alert-success" style="display: none; position: fixed; top: 20px; right: 20px;">
    Link copied!
</div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Blog Header -->
                <div class="mb-4 text-center blog-header">
                    <h1 class="display-4 fw-bold" style="font-size: 30px;">{{ $blog->title }}</h1>
                    <img
                        class="mb-3 rounded img-fluid"
                        src="{{ asset('images/blogs/'. $blog->featured_image) }}"
                        alt="Blog Header Image"
                        style="width: 80%; max-height: 400px; object-fit: cover;">
                    <p class="text-muted text-start">Published on: {{ $blog->created_at->format('F d, Y') }}</p>
                </div>

                <!-- Blog Content -->
                <div class="blog-content" style="padding: auto;">
                    {!! nl2br($blog->content) !!}
                </div>

                <!-- Author Section -->
                <div class="my-4 blog-credits d-flex align-items-center">
                    <img
                        src="{{ asset('images/authors/'.$blog->nameAuthor->image) }}"
                        alt="Author Image"
                        class="img-thumbnail me-3"
                        style="width: 60px; height: 60px;">
                    <div>
                        <p class="mb-0">Written by</p>
                        <p class="fw-bold">{{ $blog->nameAuthor->name }}</p>
                    </div>
                </div>
            <!-- for now the comment section is commented we will consider this in future -->
                <!-- Comments Section -->
                <!-- <div class="mt-5 blog-comments">
                    <h3 class="mb-4">Comments</h3>
                    @foreach($blog->blogComments as $comment)
                        <div class="mb-3 card">
                            <div class="card-body">
                                <p class="mb-0">{{ $comment['comment'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div> -->

                <!-- Leave a Comment Section -->
                <!-- <div id="comments" class="mt-5">
                    <h5 class="mb-4">Leave a Comment</h5>
                    <div class="mb-3">
                        <textarea
                            class="form-control"
                            id="comment"
                            name="comment"
                            placeholder="Write a comment..."
                            rows="4"></textarea>
                    </div> -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div id="share-section" class="text-end">
                            <!-- <h5 class="mb-2"><strong>Share this post</strong></h5> -->
                            <div class="gap-3 d-flex">
            <a href="javascript:void(0);" class="btn" data-url="{{ url()->current() }}" onclick="copyToClipboard(this)">
                <img
                    src="{{ asset('assets/facebook.png') }}"
                    alt="Facebook"
                    class="img-fluid"
                    style="width: 30px;">
            </a>
            <a href="javascript:void(0);" class="btn" data-url="{{ url()->current() }}" onclick="copyToClipboard(this)">
                <img
                    src="{{ asset('assets/linkedin.png') }}"
                    alt="LinkedIn"
                    class="img-fluid"
                    style="width: 30px;">
            </a>
            <a href="javascript:void(0);" class="btn" data-url="{{ url()->current() }}" onclick="copyToClipboard(this)">
                <img
                    src="{{ asset('assets/Instagram.png') }}"
                    alt="Instagram"
                    class="img-fluid"
                    style="width: 30px;">
            </a>
            <a href="javascript:void(0);" class="btn" data-url="{{ url()->current() }}" onclick="copyToClipboard(this)">
                <img
                    src="{{ asset('assets/twitter.png') }}"
                    alt="Twitter"
                    class="img-fluid"
                    style="width: 30px;">
            </a>
        </div>
                        </div>
                        <!-- <button id="comment-submit-button" class="btn btn-primary">Submit</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="copy-message" class="alert alert-success" style="display: none; position: fixed; bottom: 20px; right: 20px;">
    Link copied!
</div>
</section>
  <section class="text-center" style="margin-top:10px;">
             <h1 class="business-name">Browse Cars for Sale</h1>
        <div class="card-list-container">
            <div class="grid-for-car-cards">
                
                    @foreach ($data as $car_data)
                        <div class="my-3">
                            <a href="{{ route('advert_detail', ['slug' => $car_data['slug']]) }}"
                                class="text-decoration-none text-dark">
                                <div class="main_car_card">
                                    <div>
                                        <div class="car_card_main_img">
                                            <div class="car_card_inner_img">
                                                <div class="car_card_background_img" style="background-image: url('{{ asset('' . e($car_data['image'])) }}');">
                                                </div>
                                                <img src="{{ asset('' . e($car_data['image'])) }}" alt="Car Image"
                                                    onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                                    onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
                                                    class="car_card_front_img">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 card-contain">
                                        <p class="car_tittle text-truncate">{{ e($car_data['make'] ?? 'Unknown make') }}
                                            {{ e($car_data['model'] ?? 'N/A') }} {{ e($car_data['year'] ?? 'N/A') }}</p>
                                        <p class="car_varient text-truncate">
                                            @if (empty($car_data['Trim']) || $car_data['Trim'] == 'N/A')
                                                         {{ strtoupper($car_data['variant']) }}
                                            @else
                                                 {{ strtoupper(e($car_data['Trim'])) }}
                                            @endif
                                        </p>
                                        <div class="car_detail">
                                            <div class="text-center car_detail-item">{{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}</div>
                                            <div class="text-center car_detail-item">{{ e($car_data['fuel_type'] ?? 'N/A') }}</div>
                                            <div class="text-center car_detail-item">{{ e($car_data['gear_box'] ?? 'N/A') }}</div>
                                        </div>
                                     
                                
                                        <div class="height"></div>
                                        <div class="car_detail_bottom">
                                            <p class="car_price">
                                                {{ e(isset($car_data['price']) && $car_data['price'] > 0 ? '£' . number_format($car_data['price'], 0, '.', ',') : 'POA') }}
                                            </p>
                                            <p class="car_location">
                                                {{ $car_data['user']['location'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                
            </div>
            
        </div>
       

    </section>
<!-- Fullscreen Image Viewer Model -->
<div id="fullscreenViewer" class="fullscreen-viewer">
    <span class="close-btnmodel" onclick="closeFullScreen()">&times;</span>
    <button class="prev-btn" onclick="changeImage(-1)">&#10094;</button>
    <img id="fullscreenImage" class="fullscreen-image">
    <button class="next-btn" onclick="changeImage(1)">&#10095;</button>
</div>

<style>
    /* Fullscreen Viewer Styles */
    .fullscreen-viewer {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .fullscreen-image {
        max-width: 90%;
        max-height: 80vh;
    }

    .close-btnmodel {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    .prev-btn, .next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 30px;
        color: white;
        background: none;
        border: none;
        cursor: pointer;
    }

    .prev-btn { left: 20px; }
    .next-btn { right: 20px; }

    /* Mobile Responsive */
    @media (max-width: 600px) {
        .fullscreen-image {
            max-width: 95%;
            max-height: 70vh;
        }
        .prev-btn, .next-btn { font-size: 25px; }
        .close-btnmodel { font-size: 25px; }
    }
</style>
<script>
    let images = [];
let currentIndex = 0;

// Wait for DOM content to load
document.addEventListener("DOMContentLoaded", function () {
    setupImageClickListeners(); // Initial setup for existing images

    // Observe changes in the blog content (for dynamically loaded content)
    const blogContent = document.querySelector(".blog-content");
    if (blogContent) {
        const observer = new MutationObserver(setupImageClickListeners);
        observer.observe(blogContent, { childList: true, subtree: true });
    }

    // Close fullscreen when clicking outside the image
    document.getElementById("fullscreenViewer").addEventListener("click", function (event) {
        if (event.target === this) {
            closeFullScreen();
        }
    });
});

// Function to attach click events to images inside the blog content
function setupImageClickListeners() {
    images = Array.from(document.querySelectorAll('.blog-content img')); // Select all images in the blog content

    images.forEach(img => {
        img.classList.add("blog-image"); // Add a class if not present
        img.style.cursor = "pointer"; // Change cursor to indicate clickability

        // Ensure event listeners are added only once
        img.removeEventListener("click", openFullScreen);
        img.addEventListener("click", function () {
            openFullScreen(img);
        });
    });
}

function openFullScreen(img) {
    const viewer = document.getElementById('fullscreenViewer');
    const fullscreenImg = document.getElementById('fullscreenImage');

    currentIndex = images.indexOf(img);
    fullscreenImg.src = img.src;
    viewer.style.display = "flex";
}

function closeFullScreen() {
    document.getElementById('fullscreenViewer').style.display = "none";
}

function changeImage(direction) {
    currentIndex += direction;

    if (currentIndex < 0) {
        currentIndex = images.length - 1;
    } else if (currentIndex >= images.length) {
        currentIndex = 0;
    }

    document.getElementById('fullscreenImage').src = images[currentIndex].src;
}

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#comment-submit-button').click(function() {
            var commentText = $('#comment').val();
            var blogId = {{ $blog->id }};

            if (commentText.trim() === "") {
                alert("Comment cannot be empty.");
                return;
            }

            $.ajax({
                url: '/comments/' + blogId,
                type: 'POST',
                data: {
                    comment: commentText,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#comment').val('');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Something went wrong. Please try again.");
                }
            });
        });
    });
    function copyToClipboard(button) {
        // Get the URL from the button's data-url attribute
        var urlToCopy = button.getAttribute('data-url');

        // Use the Clipboard API to copy the URL
        navigator.clipboard.writeText(urlToCopy).then(function() {
            // Show success message
            var copyMessage = document.getElementById('copy-message');
            copyMessage.style.display = 'block';

            // Hide the message after 2 seconds
            setTimeout(function() {
                copyMessage.style.display = 'none';
            }, 2000);
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
        });
    }
</script>


@endsection
