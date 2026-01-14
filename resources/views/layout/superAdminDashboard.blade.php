<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/landing_page_setting.css')}}">
    <link rel="stylesheet" href="{{asset('css/profile_setting.css')}}">
    <link rel="stylesheet" href="{{asset('css/tagsandcategories.css')}}">
    <link rel="stylesheet" href="{{asset('css/contact_setting.css')}}">
    <link rel="stylesheet" href="{{asset('css/add_blog.css')}}">
    <link rel="stylesheet" href="{{asset('css/blog_setting.css')}}">
    <link rel="stylesheet" href="{{asset('css/post_setting.css')}}">
    <link rel="stylesheet" href="{{asset('css/add_post.css')}}">
    <link rel="stylesheet" href="{{asset('css/packages.css')}}">
    <link rel="stylesheet" href="{{asset('css/posts.css')}}">
    <!-- Include CSS and JS for Summernote -->
    <link rel="stylesheet" href="{{asset('css/summernote.css')}}">
    <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}" type="image/jpeg">
    <style>
       .dashboard .sidebar {
            width: 250px;
            height: 100%;
        }
        .close-btn{
            display: none;
        }
        @media screen and (max-width: 999px) {
            #sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.2);
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
                z-index: 999;
                transition: opacity 0.3s ease-in-out;
            }
            #sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
            #sidebar {
                position: fixed;
                top: 0;
                right: 0;
                width: 280px;
                min-height: 100vh;
                overflow-y: scroll;
                -webkit-overflow-scrolling: touch;
                background: rgba(255, 255, 255);
                backdrop-filter: blur(10px);
                color: black;
                padding: 10px;
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
                z-index: 1000;
                box-shadow: -4px 0px 10px rgba(0, 0, 0, 0.2);
                border-left: 1px solid rgba(255, 255, 255, 0.2);
            }
            #sidebar.show {
                transform: translateX(0);
            }
            .close-btn {
                display: block;
                font-size: 24px;
                margin-right: 15px;
                margin-bottom: 5px;
                background: none;
                border: none;
                cursor: pointer;
                color: white;
                background-color: black;
                border-radius: 10px;
                padding: 0px 10px;
            }
            #sidebar-toggle {
                display: inline-block;
                padding: 6px;
                border-radius: 10px;
                background-color: black;
                color: white;
                border: none;
                cursor: pointer;
                font-size: 16px;
            }
            #sidebar::-webkit-scrollbar {
                width: 8px;
            }
            #sidebar::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.05);
            }
            #sidebar::-webkit-scrollbar-thumb {
                background: rgba(0, 0, 0, 0.3);
                border-radius: 10px;
            }
            #sidebar:hover::-webkit-scrollbar-thumb {
                background: rgba(0, 0, 0, 0.5);
            }
        }

        @media screen and (min-width: 1000px) {
            #sidebar-toggle {
                display: none;
            }
        }
        .dashboard .content {
            padding: 20px;
        }
        .dashboard .nav-link {
            color: #333;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
        }
        .dashboard  .nav-link:hover {
            background-color: #f8f9fa;
        }
        .dashboard  .nav-link.active {
            background-color: #e6e6e6;
            color: #000;
            border-radius: 10px;
        }
        .dashboard  .icon {
            width: 20px;
            margin-right: 10px;
        }
        .dashboard  .dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .dashboard  .logout-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 40px;
            width: 540px;
            text-align: center;
        }
        .dashboard  .logout-container img {
            width: 116px;
            height: 116px;
            margin-bottom: 40px;
        }
        .dashboard  .logout-container .main-text {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 24px;
        }
        .dashboard  .logout-container .sub-text {
            font-size: 16px;
            color: #848B9D;
            margin-bottom: 39px;
        }
        .dashboard .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .dashboard .btn-container button {
            flex: 1;
            height: 56px;
            border-radius: 12px;
            font-size: 18px;
            cursor: pointer;
            border: none;
        }
        .dashboard .btn-cancel {
            background-color: #FAFAFA;
            color: #000;
        }
        .dashboard .btn-confirm {
            background-color: #000;
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg mt-lg-2 ps-3 pe-3">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold" href="{{url('/')}}"><img class="logo img-fluid" src="{{ asset('assets/logo.png') }}" alt=""></a>
          <div style="display: flex; justify-content:center; align-items:center; gap:4px;">
              <button id="sidebar-toggle">
                  <span style="font-size: 11px;">
                      DB Menu
                    </span>
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
          </div>
          <div class="collapse navbar-collapse d-lg-flex gap-lg-4" id="navbarSupportedContent">
            <ul class="mb-2 navbar-nav me-auto mb-lg-0 pe-lg-5 d-lg-flex gap-lg-2 align-items-lg-center justify-content-lg-end w-100">
            <li class="nav-item">
               <a class="nav-link" href="{{url('/')}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('forum.index')}}">Forum</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('event.index')}}">Events</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('blog.index')}}">Blogs</a>
            </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('faqs.index') }}">FAQs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('contact_us')}}">Contact Us</a>
              </li>
              @if (!Auth::check())
              <li class="nav-item">
                <a class="nav-link" href="{{route('signup_view')}}">Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">Login</a>
              </li>
              @endif
            </ul>
          </div>
        </div>
    </nav>
  <div class="dashboard ">
    <div class="d-flex">
        <div id="sidebar-overlay">
            <div id="sidebar" class="sidebar">
                <div style="display: flex; justify-content:end; align-items:center;">
                    <button class="close-btn" id="close-btn">X</button>
                </div>
                <ul class="p-1 nav flex-column">
    <li class="nav-item">
        <a href="{{ route('admin_dashboard')}}" class="nav-link {{ request()->is('admin_dashboard') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-tachometer-alt text-gray-500 me-2"></i> Dashboard
        </a>
    </li>
     <li class="nav-item">
        <a href="{{ route('inquiries.index') }}" class="nav-link {{ request()->is('inquiries.index') ? 'active' : '' }}" data-page="landing.html" id="landing-link">
          <i class="fas fa-envelope text-gray-500 me-2"></i> Inquiries
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('page-sections.index')}}" class="nav-link {{ request()->is('Landing-Page-setting') ? 'active' : '' }}" data-page="landing.html" id="landing-link">
            <i class="fas fa-layer-group text-gray-500 me-2"></i> Page Sections
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('list-brands.index')}}" class="nav-link {{ request()->is('list-brands') ? 'active' : '' }}" data-page="landing.html" id="landing-link">
            <i class="fas fa-tags text-gray-500 me-2"></i> Brands
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('company-details')}}" class="nav-link {{ request()->is('company-details') ? 'active' : '' }}" data-page="profile.html" id="profile-link">
            <i class="fas fa-building text-gray-500 me-2"></i> Company Details
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('list-event')}}" class="nav-link {{ request()->is('list-event') ? 'active' : '' }}" data-page="profile.html" id="profile-link">
            <i class="fas fa-calendar-alt text-gray-500 me-2"></i> Events
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-blogs')}}" class="nav-link {{ request()->is('Blogs-Setting') || request()->is('Add-Blog') ? 'active' : '' }}" data-page="blogs.html" id="blog-link">
            <i class="fas fa-blog text-gray-500 me-2"></i> Blogs
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-authors')}}" class="nav-link {{ request()->is('Blogs-Setting') || request()->is('Add-Blog') ? 'active' : '' }}" data-page="blogs.html" id="blog-link">
            <i class="fas fa-user-edit text-gray-500 me-2"></i> Authors
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-blog-categories')}}" class="nav-link {{ request()->is('Blogs-Setting') || request()->is('Add-Blog') ? 'active' : '' }}" data-page="blogs.html" id="blog-link">
            <i class="fas fa-list-alt text-gray-500 me-2"></i> Blog Categories
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-blog-tags')}}" class="nav-link {{ request()->is('Blogs-Setting') || request()->is('Add-Blog') ? 'active' : '' }}" data-page="blogs.html" id="blog-link">
            <i class="fas fa-tags text-gray-500 me-2"></i> Blog Tags
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('packages.index')}}" class="nav-link {{ request()->is('Blogs-Setting') || request()->is('Add-Blog') ? 'active' : '' }}" data-page="blogs.html" id="blog-link">
            <i class="fas fa-box text-gray-500 me-2"></i> Packages
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-forum-topics')}}" class="nav-link {{ request()->is('list-forum-topics') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-comments text-gray-500 me-2"></i> Forum
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-reports')}}" class="nav-link {{ request()->is('list-reports') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-file-alt text-gray-500 me-2"></i> Reports
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-faqs')}}" class="nav-link {{ request()->is('list-faqs') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-question-circle text-gray-500 me-2"></i> FAQs
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('add-dealer')}}" class="nav-link {{ request()->is('add-dealer') ? 'active' : '' }}" data-page="profile.html" id="profile-link">
            <i class="fas fa-user-plus text-gray-500 me-2"></i>Add Dealer
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-users')}}" class="nav-link {{ request()->is('list-users') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-users text-gray-500 me-2"></i> Users
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-users_non')}}" class="nav-link {{ request()->is('list-users_non') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-user-times text-gray-500 me-2"></i> Non Verified Users
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-coupons')}}" class="nav-link {{ request()->is('list-coupons') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-gift text-gray-500 me-2"></i>Coupons
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-ads')}}" class="nav-link {{ request()->is('list-ads') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-ad text-gray-500 me-2"></i> Adverts
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/set-price')}}" class="nav-link {{ request()->is('set-price') }}" data-page="post.html" id="post-link">
            <i class="fas fa-car text-gray-500 me-2"></i> Cheapest Cars
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/admin_reviews')}}" class="nav-link {{ request()->is('admin_reviews') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-star text-gray-500 me-2"></i> Reviews
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/changepasswordadmin')}}" class="nav-link {{ request()->is('admin_reviews') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
            <i class="fas fa-key text-gray-500 me-2"></i> Change Password
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/db-management')}}" class="nav-link {{ request()->is('admin_reviews') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
             <i class="fas fa-server text-gray-500 me-2"></i> DB Managemnet
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-businesses')}}" class="nav-link {{ request()->is('list-businesses') ? 'active' : '' }}" data-page="businesses.html" id="businesses-link">
            <i class="fas fa-briefcase text-gray-500 me-2"></i> Business Listings
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-business-types')}}" class="nav-link {{ request()->is('list-business-types') ? 'active' : '' }}" data-page="business-types.html" id="business-types-link">
            <i class="fas fa-list-ul text-gray-500 me-2"></i> Business Types
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/list-business-locations')}}" class="nav-link {{ request()->is('list-business-locations') ? 'active' : '' }}" data-page="business-locations.html" id="business-locations-link">
            <i class="fas fa-map-marker-alt text-gray-500 me-2"></i> Business Locations
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url('/settingsadmin')}}" class="nav-link {{ request()->is('admin_reviews') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">
             <i class="fas fa-cog text-gray-500 me-2"></i> Settings
        </a>
    </li>
      <li class="nav-item">
        <a href="{{route('api.index')}}" class="nav-link {{ request()->is('api-index') ? 'active' : '' }}" id="api-link">
            <i class="fas fa-plug text-gray-500 me-2"></i> Api Connection
        </a>
    </li>
     <li class="nav-item">
        <a href="{{route('admin.normalization_rules.index')}}" class="nav-link {{ request()->is('normalization-rules') ? 'active' : '' }}" id="api-link">
            <i class="fas fa-sliders-h text-gray-500 me-2"></i> Normalization Rules
        </a>
    </li>
     <li class="nav-item">
        <a href="{{route('admin.notes.index')}}" class="nav-link {{ request()->is('notes') ? 'active' : '' }}" id="notes-link">
            <i class="fas fa-note-sticky text-gray-500 me-2"></i> Notes Management
        </a>
    </li>
    <li class="nav-item">
     <a href="{{route('logout')}}" class="nav-link {{ request()->is('admin_reviews') || request()->is('Add-Post') ? 'active' : '' }}" data-page="post.html" id="post-link">

            <i class="fas fa-sign-out-alt text-gray-500 me-2"></i> Logout
        </a>
    </li>
</ul>

            </div>
        </div>
        <!-- Sidebar -->
        <!-- Main Content -->
        <div class="p-0 pt-2 content" id="main-content" style="overflow:hidden; width:100%; ">
            <!-- Content will be loaded here -->
            @yield('body')
        </div>
    </div>
    </div>
    <script>
        const sidebarOverlay = document.getElementById("sidebar-overlay");
        const sidebar = document.getElementById("sidebar");
        const sidebarToggle = document.getElementById("sidebar-toggle");
        const closeButton = document.getElementById("close-btn");

        sidebarToggle.addEventListener("click", function () {
            sidebarOverlay.classList.add("show");
            sidebar.classList.add("show");
        });
        function closeSidebar() {
            sidebarOverlay.classList.remove("show");
            sidebar.classList.remove("show");
        }
        closeButton.addEventListener("click", closeSidebar);
        sidebarOverlay.addEventListener("click", function (event) {
            if (event.target === sidebarOverlay) {
                closeSidebar();
            }
        });
    </script>
    <script src="{{asset('js/landing_page_setting.js')}}"></script>
    <script src="{{asset('js/profile_setting.js')}}"></script>
    <script src="{{asset('js/tagsandcategories.js')}}"></script>
    <script src="{{asset('js/add_post.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
