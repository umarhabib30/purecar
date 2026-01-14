<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <style type="text/css">
        table {border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}
        
        /* Gmail-specific fixes */
        body {
            margin: 0 !important;
            padding: 0 !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            width: 100% !important;
        }
        
        /* Ensure all tables respect max-width in Gmail */
        table[class="main-table"] {
            width: 100% !important;
            max-width: 600px !important;
        }
        
        /* Prevent text overflow */
        * {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        /* Mobile Responsive Styles */
        @media only screen and (max-width: 600px) {
            body {
                padding: 0 !important;
            }
            
            /* Gmail wrapper adjustments */
            body > table {
                padding: 10px 0 !important;
                width: 100% !important;
            }
            
            body > table > tbody > tr > td {
                padding: 0 !important;
            }
            
            .main-table {
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            
            .hero-padding {
                padding: 40px 15px !important;
            }
            
            /* Ensure text doesn't overflow */
            .hero-h1,
            .hero-p,
            .hero-strong {
                max-width: 100% !important;
                word-wrap: break-word !important;
                overflow-wrap: break-word !important;
            }
            
            .hero-h1 {
                font-size: 24px !important;
                letter-spacing: 1px !important;
                margin: 0 0 10px 0 !important;
            }
            
            .hero-p {
                font-size: 14px !important;
                margin: 6px 0 !important;
            }
            
            .hero-strong {
                font-size: 16px !important;
            }
            
            .content-padding {
                padding: 25px 15px !important;
            }
            
            .section-heading {
                font-size: 20px !important;
                letter-spacing: 0.5px !important;
                padding-bottom: 15px !important;
            }
            
            .details-box {
                padding: 20px 15px !important;
            }
            
            .detail-row-table {
                width: 100% !important;
            }
            
            .detail-row-table tr {
                display: block !important;
            }
            
            .detail-label {
                width: 100% !important;
                max-width: 100% !important;
                font-size: 14px !important;
                padding-bottom: 8px !important;
                padding-right: 0 !important;
                display: block !important;
            }
            
            .detail-value {
                width: 100% !important;
                max-width: 100% !important;
                font-size: 14px !important;
                word-break: break-word !important;
                padding-left: 0 !important;
                padding-top: 0 !important;
                display: block !important;
            }
            
            .message-box {
                padding: 20px 15px !important;
                border-left-width: 3px !important;
            }
            
            .message-text {
                font-size: 14px !important;
                line-height: 1.6 !important;
            }
            
            .footer-padding {
                padding: 15px !important;
            }
            
            .footer-text {
                font-size: 12px !important;
            }
            
            .section-margin {
                margin-top: 30px !important;
            }
            
            /* Force table cells to stack on mobile */
            .detail-label,
            .detail-value {
                display: block !important;
                width: 100% !important;
            }
        }
        
        @media only screen and (max-width: 480px) {
            .hero-padding {
                padding: 30px 12px !important;
            }
            
            .hero-h1 {
                font-size: 20px !important;
            }
            
            .hero-p {
                font-size: 13px !important;
            }
            
            .content-padding {
                padding: 20px 12px !important;
            }
            
            .section-heading {
                font-size: 18px !important;
            }
            
            .details-box {
                padding: 15px 12px !important;
            }
        }
    </style>


</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">
    <!-- Gmail wrapper table for proper centering -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 20px 0; margin: 0; width: 100%;">
        <tr>
            <td align="center" style="padding: 0; margin: 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" class="main-table" style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <!-- Car Hero Section with Overlay -->
        <tr>
            <td style="padding: 0; position: relative;">
                <!-- Background image with overlay as a single unit -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 600px; background-image: url('{{ $details['car_image'] ?? 'https://via.placeholder.com/600x400?text=Car+Image' }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-color: #333333;">
                    <tr>
                        <td style="padding: 0;">
                            <!-- Dark overlay using background color on table cell -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; background-color: rgba(0, 0, 0, 0.65);">
                                <tr>
                                    <td align="center" class="hero-padding" style="padding: 80px 20px; text-align: center; word-wrap: break-word; max-width: 100%;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 100%;">
                                            <tr>
                                                <td align="center" style="padding: 0; word-wrap: break-word; overflow-wrap: break-word;">
                                                    <h1 class="hero-h1" style="font-size: 36px; font-weight: 700; margin: 0 0 15px 0; text-transform: uppercase; letter-spacing: 2px; color: #ffffff; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif; word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;">ADVERT INQUIRY</h1>
                                                    <p class="hero-p" style="font-size: 18px; margin: 8px 0; color: #ffffff; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif; word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;">You have received a new inquiry</p>
                                                    <p class="hero-p" style="font-size: 18px; margin: 8px 0; color: #ffffff; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif; word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;">For your <strong class="hero-strong" style="font-size: 20px; font-weight: 700; word-wrap: break-word; overflow-wrap: break-word;">{{ $details['advert_name'] }}</strong></p>
                                                </td>
                                            </tr>
                                        </table>
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
            <td class="content-padding" style="padding: 40px 30px;">
                
           
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" class="section-heading" style="padding-bottom: 25px;">
                            <h2 class="section-heading" style="font-size: 28px; font-weight: 700; color: #333333; margin: 0; text-transform: uppercase; letter-spacing: 1px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Sender details</h2>
                        </td>
                    </tr>
                    <tr>
                        <td class="details-box" style="background-color: #e8e9f3; border-radius: 8px; padding: 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #d0d1e0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="detail-row-table">
                                            <tr>
                                                <td class="detail-label" style="font-weight: 700; color: #333333; font-size: 16px; width: 100px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Name:</td>
                                                <td class="detail-value" style="color: #555555; font-size: 16px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">{{ $details['full_name'] }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #d0d1e0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="detail-row-table">
                                            <tr>
                                                <td class="detail-label" style="font-weight: 700; color: #333333; font-size: 16px; width: 100px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Email:</td>
                                                <td class="detail-value" style="color: #555555; font-size: 16px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">
                                                    <a href="mailto:{{ $details['email'] }}" style="color: #0066cc; text-decoration: none; word-break: break-all;">{{ $details['email'] }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="detail-row-table">
                                            <tr>
                                                <td class="detail-label" style="font-weight: 700; color: #333333; font-size: 16px; width: 100px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Phone:</td>
                                                <td class="detail-value" style="color: #555555; font-size: 16px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">
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
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="section-margin" style="margin-top: 40px;">
                    <tr>
                        <td align="center" class="section-heading" style="padding-bottom: 25px;">
                            <h2 class="section-heading" style="font-size: 28px; font-weight: 700; color: #333333; margin: 0; text-transform: uppercase; letter-spacing: 1px; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">Message</h2>
                        </td>
                    </tr>
                    <tr>
                        <td class="message-box" style="background-color: #f9f9f9; border-left: 4px solid #000000;  padding: 25px; border-radius: 4px;">
                            <p class="message-text" style="color: #333333; font-size: 16px; line-height: 1.8; margin: 0; white-space: pre-wrap; word-wrap: break-word; font-family: 'Nunito Sans', 'Lato', Arial, sans-serif;">{{ $details['message'] }}</p>
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

                </table>
            </td>
        </tr>
    </table>
</body>
</html>