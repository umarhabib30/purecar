@extends('layout.dashboard')
@section('body')

<div class="">

    <div id="outer-container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        <h2 class="d-none d-md-block" style="font-size: 28px; font-weight: 600;">Support</h2>
        <div class="row" style="background: white; margin-left: 0 !important;">
            <div class="col-md-6 left-section mobileimage">
                <img src="{{ asset('assets/CustomersupportinITindustry.png') }}" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 right-section">
                <h2>Reach Out!</h2>
                <p>Have questions or need assistance with our site? Our support team is ready to help you with
                    anything from account issues to car-related inquiries.</p>
                    <form action="{{ route('support.send') }}" method="POST">
                        @csrf
                        <div class="pb-2">
                            <label for="name" class="pb-1">Name</label>
                            <input type="text" class="form-control my-2" name="name" value="{{ old('name', $name) }}" placeholder="">
                        </div>

                        <div class="pb-2">
                            <label for="email" class="pb-1">Email</label>
                            <input type="email" class="form-control my-2" name="email" value="{{ old('email', $email) }}" placeholder="">
                        </div>

                        <div class="pb-2">
                            <label for="message" class="pb-1">Message</label>
                            <textarea name="message" class="form-control my-2" placeholder="" rows=5 required></textarea>
                        </div>
                        <div class="d-flex justify-content-between buttonmobile">
                            <button type="submit" class="btn btn-dark text-white btn-custom">Send Message</button>
                            
                            @php
                                $whatsappNumber = env('WHATSAPP_NUMBER');
                            @endphp
                                <!-- <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsappNumber) }}" class="btn btn-light text-black border border-dark btn-custom">Whatsapp</a> -->
                           
                        </div>
                    </form>

            </div>

        </div>
    </div>
</div>
@php
    $whatsappNumber = env('WHATSAPP_NUMBER');
@endphp

<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsappNumber) }}" 
   target="_blank" 
   class="whatsapp-icon">
   <div id="whatsapp-lottie"></div>
</a>

<!-- Load Lottie Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var container = document.getElementById("whatsapp-lottie");
        
        if (container) {
            lottie.loadAnimation({
                container: container,
                renderer: "svg",
                loop: true,
                autoplay: true,
                path: "{{ asset('assets/whatsapp.json') }}" // Load local JSON file
            });
        } else {
            console.error("WhatsApp Lottie container not found.");
        }
    });
</script>

<style>
    .whatsapp-icon {
        position: fixed;
        bottom: 30px;
        right: 10px;
        z-index: 1000;
        width: 100px;
        height: 100px;
    }

    #whatsapp-lottie {
        width: 100%;
        height: 100%;
    }
</style>
<style>
.btn-custom {
    width: 30%;
    border-radius: 12px;
}




@media screen and (max-width:767px) {
    .buttonmobile {
        flex-direction: column;
        gap: 10px;
    }

    .btn-custom {
        width: 100%;
    }

    #outer-container {
        background: white;
    }

    .mobileimage {
        display: none;
    }
}

@media screen and (min-width:768px) {
    .right-section {
        padding-top: 40px;
        padding-bottom: 40px;
    

    }

    .left-section {
        padding-top: 40px;
        padding-bottom: 40px;

    }

    #outer-container {
       
        
        padding-left: 50px;
        padding-right: 50px;
        padding-bottom: 50px;
    }
}
</style>
@endsection