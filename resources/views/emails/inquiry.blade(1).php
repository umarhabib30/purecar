<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <style type="text/css">
        table {border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}
    </style>


</head>
<body style="margin: 0; padding: 20px; background-color: #f4f4f4; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        
        <!-- Header Logo -->
        <tr>
            <td style="background-color: #000000; text-align: center; padding: 20px 0;">
                <img src="https://purecar.co.uk/assets/front.png" alt="PureCar Logo" style="max-width: 100px; height: 50px; display: block; margin: 0 auto;">
            </td>
        </tr>

        <!-- Car Hero Section with Overlay -->
        <tr>
            <td style="padding: 0; position: relative;">
                <!-- Background image with overlay as a single unit -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image: url('{{ $details['car_image'] ?? 'https://via.placeholder.com/600x400?text=Car+Image' }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-color: #333333;">
                    <tr>
                        <td style="padding: 0;">
                            <!-- Dark overlay using background color on table cell -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: rgba(0, 0, 0, 0.65);">
                                <tr>
                                    <td align="center" style="padding: 80px 20px; text-align: center;">
                                        <h1 style="font-size: 36px; font-weight: 700; margin: 0 0 15px 0; text-transform: uppercase; letter-spacing: 2px; color: #ffffff; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">ADVERT INQUIRY</h1>
                                        <p style="font-size: 18px; margin: 8px 0; color: #ffffff; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">You Have Received A New Inquiry</p>
                                        <p style="font-size: 18px; margin: 8px 0; color: #ffffff; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">For Your <strong style="font-size: 20px; font-weight: 700;">{{ $details['advert_name'] }}</strong></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Content Section -->
        <tr>
            <td style="padding: 40px 30px;">
                
           
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="padding-bottom: 25px;">
                            <h2 style="font-size: 28px; font-weight: 700; color: #333333; margin: 0; text-transform: uppercase; letter-spacing: 1px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Sender Details</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #e8e9f3; border-radius: 8px; padding: 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #d0d1e0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="font-weight: 700; color: #333333; font-size: 16px; width: 100px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Name:</td>
                                                <td style="color: #555555; font-size: 16px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">{{ $details['full_name'] }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #d0d1e0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="font-weight: 700; color: #333333; font-size: 16px; width: 100px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Email:</td>
                                                <td style="color: #555555; font-size: 16px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">
                                                    <a href="mailto:{{ $details['email'] }}" style="color: #0066cc; text-decoration: none;">{{ $details['email'] }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="font-weight: 700; color: #333333; font-size: 16px; width: 100px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Phone:</td>
                                                <td style="color: #555555; font-size: 16px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">
                                                    <a href="tel:{{ $details['phone_number'] }}" style="color: #0066cc; text-decoration: none;">{{ $details['phone_number'] }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Message Section -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 40px;">
                    <tr>
                        <td align="center" style="padding-bottom: 25px;">
                            <h2 style="font-size: 28px; font-weight: 700; color: #333333; margin: 0; text-transform: uppercase; letter-spacing: 1px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Message</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f9f9f9; border-left: 4px solid #000000;  padding: 25px; border-radius: 4px;">
                            <p style="color: #333333; font-size: 16px; line-height: 1.8; margin: 0; white-space: pre-wrap; word-wrap: break-word; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">{{ $details['message'] }}</p>
                        </td>
                    </tr>
                </table>

                <!-- CTA Button (commented out in original) -->
                <!-- <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 30px;">
                    <tr>
                        <td align="center" style="padding: 30px 0;">
                            <a href="{{ url('/car-for-sale/' . $details['car_slug']) }}" style="display: inline-block; background-color: #000000; color: #ffffff; padding: 14px 35px; text-decoration: none; border-radius: 4px; font-weight: 700; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">View Full Advert</a>
                        </td>
                    </tr>
                </table> -->

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #000000; color: #ffffff; text-align: center; padding: 20px;">
                <p style="margin: 0; color: #ffffff; font-size: 14px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">&copy; 2025 PureCar. All Rights Reserved.</p>
            </td>
        </tr>

    </table>
</body>
</html>