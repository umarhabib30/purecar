    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create a new account</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
        <style>
            body, html {
                height: 100%;
                margin: 0;
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                background-color: #f4f4f4; 
            }

            /* OPTION 1: Replace the old .main-container with this */
    .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        /* REMOVE min-height: 100vh; */
        padding: 80px 20px; /* Increase vertical padding */
        background-size: cover;
        background-position: center;
        position: relative;
        color: white;
        min-height: 100%; /* Ensures it still covers the background well */
    }

            .top-nav, .bottom-nav {
                position: absolute;
                width: calc(100% - 80px);
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
                left: 50%;
                transform: translateX(-50%);
            }
            .top-nav { top: 0; }
            .bottom-nav { bottom: 0; }
            
            .logo { font-weight: bold; font-size: 24px; letter-spacing: 2px; }

            .register-btn {
                background-color: white;  color: black;
                padding: 8px 16px; border-radius: 5px; text-decoration: none; transition: background-color 0.3s;
            }
            .mobile-header { display: none; }

            /* --- Unified Auth Card (for both Login and Signup) --- */
            .auth-card {
                background: white; color: #333;
                padding: 30px; /* Standardized */
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 450px; /* Standardized */
                text-align: center;
               
            }
            .auth-card h1 { font-size: 28px; font-weight: bold; margin-bottom: 10px; }
            .auth-card .subtitle { color: #888; margin-bottom: 30px; }
            .auth-card form { text-align: left; }

            /* --- Form Elements Styling --- */
            .form-group { margin-bottom: 20px; position: relative; }
            .form-group label { font-weight: 600; margin-bottom: 8px; display: block; font-size: 14px; }
            .form-control {
                height: 48px; border: 1px solid #ddd; border-radius: 50px;
                padding: 10px 15px; width: 100%;
            }
            .password-container { position: relative; }
            .password-toggle-icon {
                position: absolute; top: 50%; right: 15px;
                transform: translateY(-50%); cursor: pointer; color: #aaa;
            }
            a { color: #333; text-decoration: none; font-weight: 600; }
            .divider { text-align: center; margin: 15px 0; color: #ccc; font-size: 12px; }
            .final-link { display: none; }

            /* --- Buttons --- */
            .social-login-btn, .action-btn {
                display: flex; align-items: center; justify-content: center;
                width: 100%; padding: 12px; border-radius: 50px;
                font-weight: 600; font-size: 16px; cursor: pointer;
                border: 1px solid #ddd; background: white; margin-bottom: 15px;
                transition: background-color 0.3s;
            }
            .social-login-btn img { width: 20px; margin-right: 10px; }
            .social-login-btn:hover { background-color: #f7f7f7; }
            .action-btn {
                background: black; color: white; border: none; justify-content: space-between;
            }
            .action-btn:hover { background: #333; }
            
            /* --- Button Order Logic (Desktop) --- */
            .form-actions { display: flex; flex-direction: column; }
            .social-buttons-wrapper { order: 2; } 
            .divider { order: 1; }
            .action-btn-wrapper { order: 3; }

            @media (max-width: 768px) {
                .main-container {
                    display: block; height: auto; padding: 0; background-image: none !important;
                }
                .top-nav, .bottom-nav { display: none; }

                .mobile-header {
                    display: flex; flex-direction: column; justify-content: flex-end;
                    height: 22vh; padding: 30px; color: white;
                    background-size: cover; background-position: center;
                    border-bottom-left-radius: 30px; border-bottom-right-radius: 30px;
                }
                .mobile-header h1 { font-size: 28px; font-weight: bold; margin: 0; }
                .mobile-header p { font-size: 16px; margin: 5px 0 0; opacity: 0.9; }

                .auth-card {
                    padding: 30px 20px; border-radius: 0; box-shadow: none;
                    max-width: 100%;
                }
                .auth-card .subtitle, .auth-card h1 { display: none; }
                
                .final-link {
                    display: block; text-align: center;  font-size: 16px;
                }
                
                /* --- Button Order Logic (Mobile) --- */
                .action-btn-wrapper { order: 1; }
                .divider { order: 2; }
                .social-buttons-wrapper { order: 3; }
            }
            .action-btn span{
                justify-content:center;
                display:flex;
                width: 100%;
            }
              .honeypot {
        display: none;
    }

      .social-login-btn {
    display: flex;
    align-items: center;
    justify-content: center;
  
    height: 50px;   /* optional, to make them uniform */
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    border: 1px solid #ddd;
    background: white;

    transition: background-color 0.3s;
}

.social-buttons-wrapper {
    display: flex;
    justify-content: center; /* keep them centered in the row */
     margin-bottom: 15px;
}

.social-login-btn img {
    width: 20px;
    margin-right: 0; /* remove text spacing */
}
        </style>
    </head>
    <body>

        @if(session('message1'))
            <div id="error-message" class="position-fixed top-0 start-0 w-100 bg-danger text-white text-center fw-bold" style="z-index: 10050;">{{ session('message1') }}</div>
        @endif
        @if(session('message'))
            <div id="success-message" class="position-fixed top-0 start-0 w-100 bg-success text-white text-center p-3 fw-bold" style="z-index: 10050;">{{ session('message') }}</div>
        @endif

        @php
            $signupImage = $sections->where('section', 'extraimages')->where('name', 'signup_image')->first();
            $bgImageStyle = $signupImage && $signupImage->value ? "background-image: url('" . asset('images/page_sections/' . $signupImage->value) . "');" : "background-color: #333;";
        @endphp

        <div class="main-container" style="{{ $bgImageStyle }}">
            
            <div class="top-nav">
                <a href="/" class="logo"><img src="assets/logodark.svg" alt="Post author" class="author-pic"></a>
                <a href="/login_page" style="color:white">Already have an account? <strong class="register-btn" tyle="margin-left:10px;">Login</strong></a>
            </div>
         

            <div class="mobile-header" style="{{ $bgImageStyle }}">
                <h1 style="text-shadow: 2px 2px 6px rgba(0,0,0,0.7);">Create a new account</h1>
                <p style="text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">Enter your details to register.</p>
            </div>

            <div class="auth-card">
                <h1>Create a new account</h1>
                <p class="subtitle">Enter your details to register.</p>
                
                <form action="{{route('signup_data')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" required placeholder="e.g. John Doe">
                        @error('name') <div class="text-danger mt-1">{{$message}}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" required placeholder="e.g. john.doe@example.com">
                        @error('email') <div class="text-danger mt-1">{{$message}}</div> @enderror
                    </div>
                          <div class="honeypot">
                    <input type="text" name="honeypot" value="">
                </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-container">
                            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="••••••••••">
                            <i id="togglePassword" class="fas fa-eye password-toggle-icon"></i>
                        </div>
                        @error('password') <div class="text-danger mt-1">{{$message}}</div> @enderror
                    </div>

                    <div class="form-actions">
                        <div class="action-btn-wrapper">
                            <button type="submit" class="action-btn">
                                <span>Sign Up</span>
                                <span style="width: 50px; height:30px; display:flex; align-items:center; justify-content:center;">

                                <i style="background-color:white; color:black; width:26px; height:26px; border-radius:50%; display:flex; align-items:center; justify-content:center;" class="fas fa-arrow-right"></i>

                                </span>
                            </button>
                        </div>

              

                        <div class="social-buttons-wrapper">
                            <div class="social-login-btn" onclick="window.location.href='{{ url('auth/google') }}'">
                                <img src="{{ asset('assets/google-icon.png') }}" alt="Google">
                       
                            </div>
                                    <div style="width:10px;"></div>
                            <div class="social-login-btn" onclick="window.location.href='{{ url('auth/facebook') }}'">
                                <img src="{{ asset('assets/fb-icon.png') }}" alt="Facebook">
                
                            </div>
                        </div>
                    </div>
                    
                    <div class="final-link">
                        <span>Already have an account? <a href="/login_page">Login</a></span>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Auto-hide session messages
            setTimeout(() => {
                const errorMsg = document.getElementById('error-message');
                const successMsg = document.getElementById('success-message');
                if (errorMsg) errorMsg.style.display = 'none';
                if (successMsg) successMsg.style.display = 'none';
            }, 3000);

            function togglePasswordVisibility(fieldId, iconId) {
                const passwordField = document.getElementById(fieldId);
                const icon = document.getElementById(iconId);
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            document.getElementById('togglePassword').addEventListener('click', function() {
                togglePasswordVisibility('password', 'togglePassword');
            });
            
            // Added listener for the new confirmation field
            document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
                togglePasswordVisibility('password_confirmation', 'togglePasswordConfirm');
            });
        </script>
    </body>
    </html>