@extends('layout.dashboard')
@section('body')
<style>
     @media (max-width: 767px) {
   
   #outer-container{
       Background: white !important;
      
      
   }
}
</style>
@php
if (Session::has('facebook_coupon_used')) {
            $couponUsed = Session::get('facebook_coupon_used');
            Session::put('saved_coupon', $couponUsed); 
           
        }
@endphp

<section class="SubmitAdvertPage">
    <div id="outer-container">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('payment_id'))
        <script>
            localStorage.setItem('payment_id', '{{ session('
            payment_id ') }}');
        </script>
        @endif
        @if (Session::has('payment_completed') && Session::get('payment_completed') === true)
    

        <div class="fetch-Car-form ">
        <h1 class="pl-4 heading d-none d-sm-block">Fetch Car</h1>
            <form action="{{url('/fetchVehicleData')}}" method="GET">
                                <div class="input-label-fields">
                                    <div class="input-group">
                                        <label for="license-plate">Plate</label>
                                        <input type="text" name="license_plate" placeholder="" style="width:100%;">
                                        @error('license_plate')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="input-group">
                                        <label for="miles">Miles</label>
                                        <input type="number" name="miles" id="miles" placeholder="" inputmode="numeric" style="width:100%;" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        @error('miles')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>
                                    <div id="btn-container" class="pb-3 pt-3">
                                        <button>Search</button>
                                    </div>
            </form>
        </div>
        @else
        <p class="text-success">Please pay for the advert to fetch car details</p>
        @endif
    </div>
</section>

@endsection
