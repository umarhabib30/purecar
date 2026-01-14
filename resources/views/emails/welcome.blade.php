<!DOCTYPE html>
<html>

<head>
    <title>Welcome to PureCar – A Better Way to Buy & Sell Cars in NI!</title>
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
        <h1>Welcome to PureCar – A Better Way to Buy & Sell Cars in NI!</h1>
        <p>Dear {{ $data->name }},</p>
        <p>
            Thank you for signing up to PureCar! We truly appreciate you taking the time to check out our platform. Our
            mission is simple – to provide Northern Ireland with a fresh, fair, and cost-effective way to buy and sell
            cars.
        </p>
        <p>
            Whether you're a private seller or a dealer, we believe that selling a car shouldn’t cost a fortune.
        </p>
        <p>
            Our goal is to keep the platform accessible and affordable, so everyone who posts an advert on our website
            can do so without feeling overcharged or taken advantage of.
        </p>
        <p>
            The more people who support PureCar, the bigger the impact we can make in the industry. By uploading your
            cars and spreading the word, you're helping to shape a marketplace that puts buyers and sellers first,
            making car sales fairer for everyone.
        </p>
        <p>
            We’re excited to have you on board and can’t wait to see your listings! If you have any questions or need
            assistance, feel free to reach out.
        </p>

        <p><strong>Username:</strong> {{ $data->email }}</p>
        <p><strong>Password:</strong> {{ $data->plain_password }}</p>

        <p>The PureCar Team</p>
        <div class="footer">
            <p>&copy; 2025 PureCar. All rights reserved.</p>
        </div>
    </div>
</body>

</html>