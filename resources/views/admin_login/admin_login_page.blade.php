<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/login_page.css') }}">
    <style>
     
        #login-body {
    display: flex;
    height: 100vh;
    align-items: center;
    
    margin: 0;
    overflow: hidden;
}

#login-section {
    display: flex;
    flex-direction: column;
    justify-content: center; 
    padding: 1rem;
}

.form-control {
    height: 40px;
    padding: 6px 12px;
    font-size: 14px;
}

.password-container {
    margin-top: 10px;
}


.under-inputs {
    margin-top: 10px;
}

#login-google, #login-fb {
    margin: 10px 0;
}

button {
    margin-top: 10px;
}
    </style>
</head>
<body>

    <div id="login-body">
    <div class="p-2" style="position: absolute; top: 10px; left: 10px; z-index: 10000;">
        <a href="{{ url('/') }}" style="text-decoration: none;">
            <svg class="text-dark" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
            </svg>
        </a>
    </div>
       
        <div class="bg-img" style="width: 50%; position: relative; overflow: hidden;">

    
    
  
@php
    $loginImage = $sections->where('section', 'extraimages')->where('name', 'login_image')->first();
@endphp

@if($loginImage && $loginImage->value)
    <img src="{{ asset('images/page_sections/' . $loginImage->value) }}" alt="Login Background" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
@else
    <div style="width: 100%; height: 100%; background: #ccc; position: absolute; top: 0; left: 0;">
        <p style="text-align: center; padding: 1rem; color: #555;">No background image found.</p>
    </div>
@endif

</div>

      
        <div id="login-section" style="width: 50%; padding: 2rem; display: flex; flex-direction: column;  margin-top: 60px;">
            <h1>Log in</h1>
            <form action="{{route('Admin_login_data')}}" method="POST">
                @csrf

                @if (session('message'))
                    <p class="alert alert-danger bg-danger text-white fw-bold">{{ session('message') }}</p>
                @else
                    <p id="h1-subtext">Fill in your email and password</p>
                @endif

                @if(session('message1'))
                    <div class="alert alert-danger bg-danger text-white fw-bold">
                        {{ session('message1') }}
                    </div>
                @endif

                <input class="mb-0 form-control @error('email') is-invalid @enderror" style="height:40px;" type="email" placeholder="Email" name="email" value="{{old('email')}}">
                @error('email')
                    <div class="text-danger">{{$message}}</div>
                @enderror

                <div class="password-container" style="position: relative;">
                    <input class="mb-0 mt-3 form-control @error('password') is-invalid @enderror" id="passBox" style="height:40px;" type="password" placeholder="Password" name="password">
                    <i id="togglePassword" class="fa fa-eye-slash" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 24px; transition: all 0.3s ease;"></i>

                    @error('password')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="under-inputs" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="remember-me" style="display: flex; align-items: center;">
                    <input 
                        type="checkbox" 
                        id="rememberMe" 
                        name="rememberMe" 
                        style="width: 15px; height: 15px; cursor: pointer; accent-color: rgb(15, 15, 16); border: 1px solid #ccc; border-radius: 3px; vertical-align: middle; margin-top:17px;">
                    <label for="rememberMe" style="vertical-align: middle; margin-left: 5px;">Remember me</label>
                </div>


                    <p class="forgot-password mt-3"><a href="{{route('custom.password.request')}}">Forgot Password</a></p>
                </div>

               

                <button type="submit">Continue</button>
                
            </form>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginForm = document.getElementById("loginForm");
            const rememberMeCheckbox = document.getElementById("rememberMe");
            const emailField = document.getElementById("email");
            const passwordField = document.getElementById("password");

         
            if (localStorage.getItem("rememberMe") === "true") {
                emailField.value = localStorage.getItem("email");
                passwordField.value = localStorage.getItem("password");
                rememberMeCheckbox.checked = true;
            }

           
            loginForm.addEventListener("submit", function (e) {
                if (rememberMeCheckbox.checked) {
               
                    localStorage.setItem("rememberMe", "true");
                    localStorage.setItem("email", emailField.value);
                    localStorage.setItem("password", passwordField.value);
                } else {
             
                    localStorage.removeItem("rememberMe");
                    localStorage.removeItem("email");
                    localStorage.removeItem("password");
                }
            });
        });
    </script>
    <script>
  
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('passBox');
        const icon = document.getElementById('togglePassword');

        if (passwordField.type === 'password') {
            passwordField.type = 'text'; 
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye'); 
        } else {
            passwordField.type = 'password'; 
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash'); 
        }
    });
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>
</html>
