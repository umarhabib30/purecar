

<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
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
        <h1>Payment Successful</h1>
        <p>Dear {{ $userName }},</p>
        <p>Your payment has been received successfully.</p>

      
        <table>
            <tr>
                <th>Package Name</th>
                <td>{{ $packageName }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>£{{ number_format($packagePrice, 2) }}</td>
            </tr>
            <tr>
                <th>Expiry Date</th>
                <td>{{ \Carbon\Carbon::parse($expiryDate)->format('d/m/Y') }}</td>
            </tr>
        </table>

      
        <p>Thank you for using our service!</p>
	<div class="footer">
        <p>&copy; 2025 PureCar. All rights reserved.</p>
        
    </div>
    </div>

    
</body>
</html>
