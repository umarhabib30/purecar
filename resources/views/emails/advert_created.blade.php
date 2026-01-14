<!DOCTYPE html>
<html>
<head>
    <title>Advert Created Successfully</title>
    <style>
         *{
            font-family: 'Nunito Sans', 'Lato', sans-serif !important;
        }
        .fa, .fas, .far, .fal, .fab {  
            font-family: "Font Awesome 6 Free" !important;  
        }
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        background: #ffffff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header-logo {
        text-align: center;
       background-color: #000000;
        padding-top: 10px;
      
   }
    
    .header-logo img {
        max-width: 200px;
    }

    h1,
    h2 {
        color: #333333;
    }

    p {
        color: #555555;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        padding: 10px;
        color: #ffffff;
        font-size: 14px;
    }

    .footer a {
        color: #ffffff;
        text-decoration: none;
    }
    </style>
</head>
<body>
    <div class="container">
	<div class="header-logo">
            <img src="https://purecar.co.uk/assets/logodark.png" alt="CarKings Logo">
        </div>
        <h1>Advert Created Successfully</h1>
        <p>Dear {{ $advert->owner }},</p>
        <p>Your advert for the <strong>{{ $advert->name }}</strong> has been created successfully!</p>

  
       
        <div style="display: flex; gap: 10px; align-items: center;">
            <strong>Ad Expiry:</strong>
            <span>{{ \Carbon\Carbon::parse($advert->expiry_date)->format('d/m/Y') }}</span>
        </div>
           

        

         <a href="{{ $carUrl }}" 
            class="button" 
            style="text-decoration: none; background: #000; color: white; padding: 10px 20px; margin-top:30px; border-radius: 5px; display: inline-block;">
            View Your Ad
            </a>


       
	<div class="footer">
        <p>&copy; 2025 PureCar. All rights reserved.</p>
        
    </div>
    </div>

    
</body>
</html>
