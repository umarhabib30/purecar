@extends('layout.layout')
<title> Contact PureCar | Get in Touch with Us</title>
<meta name="description" content=" Reach out to Car Finder Ni for inquiries, support, or feedback. We're here to assist you with your automotive needs.">
@section('body')
<body style="background-color: #F6F6FA;">
{{-- <style>
.contact-row {
    display: flex;
    align-items: center;
    height: 40px;
    margin-bottom: 10px;
}

.contact-row .icon {
    width: 24px;
    height: 24px;
    margin-right: 10px;
}

.contact-row p {
    margin: 0;
    font-size: 14px;
    color: #333;
}

#contact_container {
    transform: scale(0.9,1);
    transform-origin: top center;
}

.contact-row {
    display: flex;
    padding: 28px 24px;
    margin-bottom: 24px;
    border-radius: 20px;
    align-items: center;
    gap: 16px;
    background-color: #fff;
    min-width: 300px;
    width: 70%;
    box-sizing: border-box;
}
@media (max-width: 767px) {
        #contact_container {
            margin: 0 !important;
            padding: 0 !important;
        }
        #responsiveheading{
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }
        #responsivep{
            margin-top: 0 !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }
        .contact-row{
            overflow: hidden !important;
            width: 100% !important;
        }
}
</style> --}}
{{-- new css for contact page ............... --}}
<style>
    .contact-page-container{
        display: flex;
        justify-content:center;
        align-items: center;
        padding-top:30px;
    }
    .contact-page-inner-container{
        display: flex;
        justify-content:space-evenly;
        align-items: start;
        gap: 2%;
        width: 80%;
    }
    .contact-page-heading-desktop{
        display: block;
    }
    .contact-page-heading-mobile{
        display: none;
    }
    .contact-page-contact-section{
        width: 35%;
        height: 500px;   
        background: black !important;
        color: white;
        padding: 20px;
        text-align: start;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }
    .contact-page-contact-detail{
        display: flex;
        align-items: center;      
        gap: 10px;
        margin-bottom: 10px;               
    }
    .contact-page-contact-detail p{
        margin: 0px;
        padding: 0px;
    }
    .contact-page-social-items{
        position: absolute;
        bottom: 5px;    
    }
    .contact-page-contact-small-circle{
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.235);
        margin-right: 10px;
        position: absolute;
        left: 55%;
        top: 65%;
    }
    .contact-page-contact-big-circle{
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.235);
        margin-right: 10px;
        position: absolute;
        left: 60%;
        top: 70%;
    }
    .contact-page-icons {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        width: 40px;
        height: 40px;
    }
    .contact-page-social-items-div{
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    .contact-page-icons:hover {
        background: white;
        padding: 5px;
        border-radius: 50%;
    }

    .contact-page-icons:hover img {
        width: 30px;
        height: 30px;
        color: black !important;
    } 
    .contact-page-form-section{
        width:63%;
        padding: 20px;
    }
    .contact-page-form-first-info{
        display: flex;
        gap: 5%;
        margin-bottom: 20px;
    }
    .contact-page-form-Name{
        display: flex;
        flex-direction: column;
        width: 50%;
        color: #757575;
    }
    .contact-page-form-input{
        border:none;
        background: none;
        border-bottom: 2px solid #757575 !important;
        padding: 2px 0;
    }
    .contact-page-form-input:focus{
        border:none !important;
        outline:none !important;
        border-bottom: 2px solid #757575 !important;
    }
    .contact-page-form-otherDetail{
        display: flex;
        flex-direction: column;
        width: 100%;
        margin-bottom: 20px;
        color: #757575;
    }
    .submit-button-div{
        display: flex;
        justify-content: end;
        align-items: center;
    }
    .submit-button{
        border: none;
        background: black !important;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }
    @media screen and (max-width:767px){
        .contact-page-container{
            padding-top: 20px; 
        }
        .contact-page-inner-container{
            display: flex;
            flex-direction: column;
            justify-content:space-evenly;
            align-items: center;
            gap: 2%;
            width: 90%;
        }    
        .contact-page-heading-desktop{
            display: none;
        }
        .contact-page-heading-mobile{
            display: block;
            margin-top: 20px;
        }
        .contact-page-contact-section{
            width: 100%;
            max-height: fit-content;   
            background: black !important;
            color: white;
            padding: 20px;
            text-align: start;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }
        .mobile-paragraph{
            text-align: center;
        }
        .contact-page-contact-detail{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;      
            gap: 10px;
            margin-bottom: 10px;               
        }
        .contact-page-social-items{
            position: inherit;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding: 0;
        }
        .contact-page-form-section{
            width:100%;
            padding: 20px;
        }
        .contact-page-form-first-info{
            gap: 4%;
        }
        .contact-page-form-Name{
            width: 48%;
        }
        .submit-button{
            width: 100%;
        }
        .mobile-spacing-logo{
            margin-top: 60px;
        }
    }   
</style>
<div id="" class="mb-0 contact-page-container">
    <div class="contact-page-inner-container">
        <h3 id="" class="contact-page-heading-mobile"></h3>
        <div class="contact-page-contact-section" id="" style="">    
            <h3 id="" class="contact-page-heading-desktop">Contact Details</h3>
            <p id="" class="mobile-paragraph">Have a question, or just want to say hello? We'd love to hear from you! Reach out to us using
                the contact information below.</p>
            <div class="contact-page-contact-detail">
                <img src="assets/mail-icon.png" alt="#" class="">
                <p>{{ getCompanyDetail('email') }}</p>
            </div>
            <div class="contact-page-contact-detail">
                <img src="assets/phone-icon.png" alt="#" class="">
                <p>{{ getCompanyDetail('phone') }}</p>
            </div>
            <div class="contact-page-contact-detail">
                <img src="assets/location-icon.png" alt="#" class="">
                <p>{{ getCompanyDetail('address') }}</p>
            </div>
            <div class="contact-page-social-items mobile-spacing-logo">
                <div class="contact-page-social-items-div">
                    {{-- <h4>Follow us</h4> --}}
                    <a href="{{ getCompanyDetail('facebook') }}" class="contact-page-icons"><img src="assets/facebook.png" style="width: 28px; height:28px;" alt="#"></a>
                    <a href="{{ getCompanyDetail('instagram') }}" class="contact-page-icons"><img src="assets/Instagram.png" alt="#" style="width: 28px; height:28px;"></a>
                    <a href="{{ getCompanyDetail('x') }}" class="contact-page-icons"><img src="assets/twitter.png" alt="#" style="width: 28px; height:28px;"></a>                    
                    <a href="{{ getCompanyDetail('linkedin') }}" class="contact-page-icons"><img src="assets/tiktoklogo.png" alt="#" style="width: 28px; height:28px;"></a>
                </div>
            </div>
            <div class="contact-page-contact-small-circle"></div>
            <div class="contact-page-contact-big-circle"></div>
        </div>
        <div id="" class="contact-page-form-section">
            {{-- <h3>Get in Touch</h3>
            <p class="">Our team aims to respond promptly to all emails during our business hours. Your message is
                important to us, and we will make every effort to address your needs effectively.</p> --}}
                <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="contact-page-form-first-info">
                    <div class="contact-page-form-Name">
                        <label for="name" style="font-size:22px;">First name</label>
                        <input type="text" name="name" placeholder="Enter Name" class="contact-page-form-input">
                    </div>
                    <div class="contact-page-form-Name">
                        <label for="lastName" style="font-size:22px;">Last name</label>
                        <input type="text" name="lastName" placeholder="Enter Name" class="contact-page-form-input">
                    </div>
                </div>
                <div class="contact-page-form-otherDetail">
                        <label for="email" style="font-size:22px;">Email</label>
                        <input type="email" name="email" placeholder="Contact@personal.com" class="contact-page-form-input">                    
                </div>
                {{-- <div class="contact-page-form-otherDetail">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" placeholder="07737652785" class="contact-page-form-input">                    
                </div> --}}
    
                <div class="contact-page-form-otherDetail">
                    <label for="message" style="font-size:22px;">Message</label>
                    <textarea name="message" placeholder="Write here" rows="6" class="contact-page-form-input"></textarea>
                </div>
                <div class="submit-button-div">
                    <button class="submit-button" type="submit">SEND MESSAGE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection