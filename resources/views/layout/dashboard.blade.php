<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/ProfilePage1.css')}}">
  <link rel="stylesheet" href="{{asset('css/ProfilePage2.css')}}">
  <link rel="stylesheet" href="{{asset('css/MyListingPage.css')}}">
  <link rel="stylesheet" href="{{asset('css/SubmitAdvertPage.css')}}">
  <link rel="stylesheet" href="{{asset('css/SubmitAdvertPage2.css')}}">
  <link rel="stylesheet" href="{{asset('css/MyFavoritePage.css')}}">
  <link rel="stylesheet" href="{{asset('css/ChangePasswordPage.css')}}">
  <link rel="stylesheet" href="{{asset('css/FAQSPage.css')}}">
  <link rel="stylesheet" href="{{asset('css/logoutPage.css')}}">
  <link rel="stylesheet" href="{{asset('css/statistics.css')}}">
  <link rel="stylesheet" href="{{asset('css/statistics.css')}}">
  <link rel="stylesheet" href="{{asset('css/packages.css')}}">
  <link rel="stylesheet" href="{{asset('css/stripe.css')}}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}" type="image/jpeg">
   <style>
        *{
            font-family: 'Nunito Sans', 'Lato', sans-serif !important;
        }
        .fa, .fas, .far, .fal, .fab {  
            font-family: "Font Awesome 6 Free" !important;  
        }
 
        ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
        }
        ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb:hover {
        background: #555;
        }
       .dashboard .sidebar {
            width: 250px;
            height: 100vh;
        }
        @media screen and (min-width: 768px) {
            .dashboard .content {
                padding: 20px;
            }
        }
        @media screen and (max-width: 767px) {
            .dashboard .content {
                padding: 6px;
            }
        }
        .dashboard .nav-link {
            color: #333;
            display: flex;
            align-items: center;
            padding: 10px 12px;
            text-decoration: none;
        }
        .dashboard  .nav-link:hover {
            background-color: #edf3ff ;
            border-radius: 10px;
        }
        .dashboard  .nav-link.active {
            background-color: #edf3ff ;
            color: #000;
            border-radius: 10px;
        }
        .dashboard .nav-link:focus {
            outline: none;
            background-color: #edf3ff  !important;
            color: #000 !important;
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
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 300px;
            border-radius: 20px;
        }
        .modal-icon {
            width: 100px; /* Increased image size */
            height: 100px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .button-container {
            display: flex;
            justify-content: center; /* Align buttons side by side */
            gap: 10px; /* Space between buttons */
        }
        .btnmodel {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 120px
        }
        .btn-dark {
            background-color: #343a40;
            color: white;
        }
        .btn-light {
            background-color: #f8f9fa;
            color: black;
        }
        #main-content{
            width:80%;
        }
        /* #sidebar-overlay{
            width: 20%;
        } */
        @media screen and (min-width:990px){
            .desktop-menu-2{
                display: inline-block;
            }
            #logout-bottom{
                /* border-top: 2px solid white; */
                margin-left: 5px;
            }
        }
        @media screen and (max-width:990px){
            .desktop-menu-2{
                display: none;
            }
        }
        .close-btn{
            display: none;
        }
        .user-name-email{
            display: none;
        }
        @media screen and (max-width: 990px) {
            #main-content{
                width:100%;
            }
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
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                width: 75vw;
                min-height: 100vh;
                max-height: 100vh;
                overflow-y: scroll;
                -webkit-overflow-scrolling: touch;
                /* background: rgba(255, 255, 255); */
                background: white;
                backdrop-filter: blur(10px);
                /* color: black; */
                color: black;
                padding: 10px;
                transform: translateX(100%);
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
                z-index: 1000;
                box-shadow: -4px 0px 10px rgba(0, 0, 0, 0.2);
                border-left: 1px solid rgba(255, 255, 255, 0.2);
            }
            .dashboard .nav-link {
                color: white;
            }
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 1;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            #sidebar.show {
                animation: slideIn 0.5s ease-in-out forwards;
            }
            #sidebar.hide {
                animation: slideOut 0.5s ease-in-out forwards;
            }
            .close-btn {
                display: block;
                position: absolute;
                right: 0px;
                top:  5px;
                font-size: 24px;
                margin-right: 15px;
                margin-bottom: 20px;
                border: none;
                cursor: pointer;
                color: white;
                background-color: white;
                border-bottom-right-radius: 25px;
                padding-top:4px;
                padding-left: 10px;
                padding-right: 10px;
                padding-bottom: 8px;
                z-index: 1100;
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
            #logout-bottom{
                /* border-top: 2px solid white; */
                margin-bottom: 40px;
            }
            .user-name-email{
                display: block;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                margin-top: 0px;
                padding: 10px;
                /* border-bottom: 2px solid white; */
            }

            /* below is the header changing for mobiles */
            .container-fluid{
                background:rgba(0, 0, 0);
                height: 60px;
                margin-top: 0;
       
            }
                .nav-link.active {
                        background-color: #edf3ff !important;
                        color: black !important;
                    }

               
                /* Default (Inactive) state */
                .nav-link {
                    color: black !important;
                }    
              
                .nav-link:focus {
    background-color: black !important;
    color: white !important;
}


        }
        @media screen and (min-width: 991px) {
            #sidebar-toggle {
                display: none;
            }
           



        }


        #cancelLogout {
    background-color: #fff !important;
    color: #000 !important;
    border: 2px solid #000 !important;
    padding: 8px 20px !important;
    font-size: 14px !important;
    font-weight: bold !important;
    border-radius: 5px !important;
    width: 100px;
}

#confirmLogout {
    background-color: #000 !important;
    color: #fff !important;
    border: 2px solid #000 !important;
    padding: 8px 20px !important;
    font-size: 14px !important;
    font-weight: bold !important;
    width: 100px;
    border-radius: 5px !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-content {
        width: 90% !important;
    }
}

.menu-upper-text{
    padding-left: 15px;
    color: #79797b;
    padding-top: 10px !important;
    margin-bottom: 0px !important;
    font-weight: 600px;

   
}
.menu-dealer-text{
    color: #79797b
}

@media (min-width: 769px) {
    .sidebar-area-icon {
       display: none !important;
    }
}


    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg mt-lg-2 ps-lg-3 pe-lg-3 pt-0">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold d-none d-md-block" href="{{url('/')}}"><img class="logo img-fluid" src="{{asset('assets/logowhite.svg')}}" alt=""></a>
          <a class="navbar-brand fw-bold d-lg-none"   href="{{url('/')}}"><img src="{{ asset('assets/logodark.svg') }}"></a>

          
          <div>
              <button class="navbar-toggler  d-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <button id="sidebar-toggle" style="background: none; border: none; color: white; font-size: 30px; cursor: pointer; padding-right: 15px;">
              <span class="text-white">☰</span>
            </button>
            
          </div>
          <div class="desktop-menu-1 collapse navbar-collapse d-lg-flex gap-lg-4" id="navbarSupportedContent">
            <ul class="mb-2 navbar-nav me-auto mb-lg-0 pe-lg-5 d-lg-flex gap-lg-2 align-items-lg-center justify-content-lg-end w-100">
                <ul class="mb-2 navbar-nav me-auto mb-lg-0 pe-lg-5 d-lg-flex gap-lg-2 align-items-lg-center justify-content-lg-end w-100">
               
                    <li class="nav-item">
                     <a class="nav-link" href="{{url('/')}}">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('forum.index')}}">Forum</a>
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
                        <a class="nav-link" href="#">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    @endif
                </ul>
                    <a href="javascript:void(0);" style="min-width: 140px; margin-right: 15px;" class="pt-2 pb-2 text-white btn bg-dark" type="submit" onclick="redirectToPage()">Sell Car</a>
          </div>
        </div>
      </nav>
  <div class="dashboard ">
    <div class="d-flex ">
        <!-- Sidebar -->
        <div id="sidebar-overlay" style="padding-left: 20px;">


         <div class="sidebar-area-icon " style="
        position: fixed;
        left: 12.5%; /* Center in the remaining 25% space (25/2 = 12.5%) */
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 1001;
        background: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        cursor: pointer;
        transition: all 0.3s ease;
    "
    id="navbar-icon"
    >
        <!-- You can use Font Awesome icons or any icon -->
   
              <img src="{{asset('assets/icons/arrow-right.svg')}}">
   
    </div>
            <div id="sidebar" class="sidebar">
                <div>
                     <div style="display: flex; align-items:center;">
                        <button class="close-btn" id="close-btn"></button>
                        <!-- <div class="user-name-email"> -->
                          
                                <!-- <div class="row align-items-center" style="display: flex; align-items: flex-start;"> -->
            <!-- <div class="col-auto">
                <div style="background-color: gray; width:50px; height:50px; border-radius:50%; overflow:hidden; object-fit:cover;">
                    <img style="object-fit: cover; width:50px; height:50px;" src="{{ auth()->user()->image ? asset('images/users/' . auth()->user()->image) : asset('assets/upload-icon.png') }}" alt="user-profile-img">
                </div>
            </div> -->
            <!-- <div class="col">
                <h2 style="font-size: 18px; margin: 0; line-height: 1;">
                    {{ Auth::user()->name}}
                </h2>
            

                  <a href="@if(Auth::user()->role == 'private_seller'){{ url('/private_seller') }}@else{{ url('/car_dealer') }}@endif"
                            style="text-decoration: none;">
                                <p class="mt-3" style="color: #314354">View Profile ➔</p>
                            </a>
            </div>
          
        </div>
                        
                       
                            
                        </div>
                    </div> -->
 </div>
                   
                    <ul class="p-1 nav flex-column">
                        <li class="nav-item d-block d-md-none">
                            <a href="{{url('/')}}" class="nav-link {{ request()->is('home') ? 'active' : '' }}" data-page="DashboardPage.html" id="dashboard-link">
                                <img src="{{asset('assets/icons/dashboard_inactive.svg')}}" class="icon" id="dashboard-icon" alt="Dashboard">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/dashboard')}}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" data-page="DashboardPage.html" id="dashboard-link">
                                <img src="{{asset('assets/icons/analytics-svgrepo-com.svg')}}" class="icon" id="dashboard-icon" alt="Dashboard">
                                Dashboard
                            </a>
                        </li>
                        <p class="menu-upper-text">Cars</p>
                        <style>
                            .submit-active-tab .nav-link.active{
                                background-color: green !important;
                                 color: white !important;

                            }
                             .submit-active-tab .nav-link{ 
                                background-color: green;
                                border-radius: 10px !important;
                                color: white !important;

                            }
                            @media screen and (max-width: 990px){
                                .submit-active-tab .nav-link.active {
                                    background-color: green !important;
                                 color: white !important;
                            }
                        }
                        </style>
                        <li class="nav-item submit-active-tab">
                           <a href="{{route('packages.select')}}" class="nav-link {{ request()->is('packages/select') || request()->is('submitadvert1') || request()->is('submitadvert2') || request()->is('pay/cancel') || request()->is('pay/success') ? 'active' : '' }}"
                                data-page="advert.html" id="advert-link">
                                    <img src="{{asset('assets/icons/advert_inactive.svg')}}" class="icon" id="advert-icon" alt="Advert" style="filter: brightness(0) invert(1);">
                                    Submit Advert
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{route('my_listing')}}" class="nav-link {{ Route::is('my_listing') ? 'active' : '' }}" data-page="listings.html" id="listings-link">
                                <img src="{{asset('assets/icons/listings_inactive.svg')}}" class="icon" id="listings-icon" alt="Listings">
                                My Listings
                            </a>
                        </li>
                          <li class="nav-item">
                             <a href="{{route('sold_cars')}}" class="nav-link {{ Route::is('sold_cars') ? 'active' : '' }}" data-page="listings.html" id="listings-link">
                              <img src="{{asset('assets/icons/material-symbols_car-tag.svg')}}" class="icon" id="favourite-icon" alt="Favourite">
                                Sold Cars
                            </a>
                        </li>
                          <li class="nav-item">
                            <a href="{{url('/advert/showfavorite')}}" class="nav-link {{ request()->is('advert/showfavorite') ? 'active' : '' }}" data-page="favourite.html" id="favourite-link">
                                <img src="{{asset('assets/icons/favourite_inactive.svg')}}" class="icon" id="favourite-icon" alt="Favourite">
                                My Favourite
                            </a>
                        </li>

                        <p class="menu-upper-text">Help</p>

                          <li class="nav-item">
                            <a href="{{ route('faqs.sellers')}}" class="nav-link {{ request()->is('faqs-sellers') ? 'active' : '' }}" data-page="faq.html" id="faq-link">
                                <img src="{{asset('assets/icons/faq_inactive.svg')}}" class="icon" id="faq-icon" alt="FAQ">
                                FAQs
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{url('/support')}}" class="nav-link {{ request()->is('support') ? 'active' : '' }}" data-page="support.html" id="support-link">
                        <img src="{{asset('assets/icons/material-symbols_chat.svg')}}" class="icon" id="support-icon" alt="support">
                                Support
                            </a>
                        </li>

                        <p class="menu-upper-text">Account</p>
                          <li class="nav-item">
                            <a href="{{url('/changepassword')}}" class="nav-link {{ request()->is('changepassword') ? 'active' : '' }}" data-page="password.html" id="password-link">
                                <img src="{{asset('assets/icons/password_inactive.svg')}}" class="icon" id="password-icon" alt="Password">
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="@if(Auth::user()->role == 'private_seller'){{ url('/private_seller') }}@else{{ url('/car_dealer') }}@endif"
                                class="nav-link @if(Auth::user()->role == 'private_seller'){{ request()->is('private_seller') ? 'active' : '' }}@else{{ request()->is('car_dealer') ? 'active' : '' }}@endif" data-page="profile.html" id="profile-link">
                                    <img src="{{asset('assets/icons/profile_inactive.svg')}}" class="icon" id="profile-icon" alt="Profile">
                                    My Profile
                            </a>
                        </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link {{ request()->is('logout') ? 'active' : '' }}" id="logout-link">
                        <img src="{{asset('assets/icons/logout_inactive.svg')}}" class="icon" id="logout-icon" alt="Logout">
                        Logout
                    </a>
                        </li>
                    
                       
                      
                      
                     
                        
            
                    
                      
                      
                    </ul>
                </div>
             
            </div>

            
        </div>
     
      
                        <!-- Popup Modal -->
                        <div id="logoutModal" class="modal">
                            <div class="modal-content">
                                <img src="{{asset('assets/loginmodelicon.png')}}" alt="Are you sure?" class="modal-icon">
                                <p>Are you sure you want to logout?</p>
                                <div class="button-container">
                                    <button id="cancelLogout" class="btnmodel btn-light">Cancel</button>
                                    <button id="confirmLogout" class="btnmodel btn-dark">Yes</button>
                                </div>
                            </div>
                        </div>
        <!-- Main Content -->
        <div class="pt-2 content" id="main-content">
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
    const navbarIcon = document.getElementById("navbar-icon");

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
    navbarIcon.addEventListener("click", closeSidebar);
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    function handleSellerTypeClick(sellerType) {
    // Create a new URL based on the clicked seller type
    let url = sellerType === 'private_seller' ? '{{ url('private_seller') }}' : '{{ url('car_dealer') }}';
    // Redirect to the URL
    window.location.href = url;
}
</script>
    <script>
        document.querySelectorAll('.toggle-answer').forEach(image => {
            image.addEventListener('click', function () {
                const answerDiv = document.getElementById('answer-' + this.dataset.index);
                if (answerDiv.style.display === 'none' || !answerDiv.style.display) {
                    answerDiv.style.display = 'block';
                } else {
                    answerDiv.style.display = 'none';
                }
            });
        });
        //model
        document.getElementById('logout-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('logoutModal').style.display = 'flex';
});
document.getElementById('confirmLogout').addEventListener('click', function() {
    window.location.href = '{{ route('logout') }}';
});
document.getElementById('cancelLogout').addEventListener('click', function() {
    document.getElementById('logoutModal').style.display = 'none';
});
    </script>
    <script>
        function redirectToPage() {
            @auth
                // Redirect to the submit_advert route if the user is logged in
                window.location.href = "{{ route('packages.select') }}";
            @endauth
            @guest
                // Redirect to the login route if the user is not logged in
                window.location.href = "{{ route('login') }}";
            @endguest
        }
    </script>
    <script></script>
</body>
</html>