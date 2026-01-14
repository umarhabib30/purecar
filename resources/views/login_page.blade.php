<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #f4f4f4; 
        }


.main-container {
    display: flex;
    justify-content: center;
    align-items: center;

    padding: 80px 20px;
    background-size: cover;
    background-position: center;
    position: relative;
    color: white;
    min-height: 100%; 
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
        .form-options {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; font-size: 14px;
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
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                height: 22vh;
                padding: 30px;
                color: white;
                background-size: cover;
                background-position: center;
                border-bottom-left-radius: 30px;
                border-bottom-right-radius: 30px;
            }
            .mobile-header h1 { font-size: 28px; font-weight: bold; margin: 0; }
            .mobile-header p { font-size: 16px; margin: 5px 0 0; opacity: 0.9; }

            .auth-card {
                padding: 30px 20px;
                border-radius: 0;
                box-shadow: none;
                max-width: 100%;
            }
            .auth-card .subtitle, .auth-card h1 { display: none; }
            
            .final-link {
                display: block;
                text-align: center;
                font-size: 16px;
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
    @php
        $loginImage = $sections->where('section', 'extraimages')->where('name', 'login_image')->first();
        $bgImageStyle = $loginImage && $loginImage->value ? "background-image: url('" . asset('images/page_sections/' . $loginImage->value) . "');" : "background-color: #333;";
    @endphp

    <div class="main-container" style="{{ $bgImageStyle }}">

        <div class="top-nav">
            <a href="/" class="logo"><img src="assets/logodark.svg" alt="Post author" class="author-pic"></a>
            <a href="/signup_page" style="color:white">Don't have an account? <strong class="register-btn" style="margin-left:10px;">Register</strong></a>
        </div>
   

      <div class="mobile-header" style="{{ $bgImageStyle }}">
            <h1 style="text-shadow: 2px 2px 6px rgba(0,0,0,0.7);">Please Log In</h1>
            <p style="text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">Enter your details to login.</p>
        </div>


        <div class="auth-card">
            <h1>Login to your account</h1>
            <p class="subtitle">Enter your details to login.</p>
            
            <form action="{{route('login_data')}}" method="POST">
                @csrf

                @if (session('message'))
                    <p class="alert alert-danger">{{ session('message') }}</p>
                @endif
                @if (session('message2'))
                    <p class="alert alert-success">{{ session('message2') }}</p>
                @endif

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" required >
                    @error('email')
                        <div class="text-danger mt-1">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="passBox">Password</label>
                    <div class="password-container">
                        <input id="passBox" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required >
                        <i id="togglePassword" class="fas fa-eye password-toggle-icon"></i>
                    </div>
                     @error('password')
                        <div class="text-danger mt-1">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                        <label class="form-check-label" for="rememberMe">Keep me logged in</label>
                    </div>
                    <a href="{{route('custom.password.request')}}">Forgot password?</a>
                </div>

                <div class="form-actions">
                    <div class="action-btn-wrapper">
                        <button type="submit" class="action-btn">
                            <span>Login</span>
                            <span style="width: 50px; height:30px; display:flex; align-items:center; justify-content:center;">

    <i style="background-color:white; color:black; width:26px; height:26px; border-radius:50%; display:flex; align-items:center; justify-content:center;" class="fas fa-arrow-right"></i>

</span>
                        </button>
                    </div>


                    <div class="social-buttons-wrapper">
                        <div class="social-login-btn " onclick="window.location.href='{{ url('auth/google') }}'">
                            <img src="{{ asset('assets/google-icon.png') }}" alt="Google">
                  
                        </div>
                         <div style="width:10px;"></div>
                        <div class="social-login-btn" onclick="window.location.href='{{ url('auth/facebook') }}'" >
                            <img src="{{ asset('assets/fb-icon.png') }}" alt="Facebook">
              
                        </div>
                    </div>
                </div>
                
                <div class="final-link">
                    <span>Don't have an account? <a href="/signup_page">Sign Up</a></span>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('passBox');
            const icon = this;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>