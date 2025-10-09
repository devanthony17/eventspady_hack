<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{\App\Models\Setting::find(1)->app_name}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
    {!! JsonLdMulti::generate() !!}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
  <!-- Favicons -->
  <link href="{{ url('images/upload/'.\App\Models\Setting::find(1)->favicon)}}" rel="icon" type="image/png">  

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
  <link href="{{url('frontend/css/ionicons.min.css')}}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />   
  <link href="{{url('frontend/css/animate.min.css')}}" rel="stylesheet">
  <link href="{{url('frontend/css/font-awesome.min.css')}}" rel="stylesheet">  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="{{url('frontend/css/owl.carousel.min.css')}}" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <!-- Template Main CSS File -->
  <link href="{{url('frontend/css/style.css')}}" rel="stylesheet">
  <link href="{{url('frontend/css/custom.css')}}" rel="stylesheet">
  @if(session('direction') == "rtl")
    <link rel="stylesheet" href="{{url('frontend/css/rtl.css')}}">
  @endif
</head>

<body>
  <?php	$primary_color = \App\Models\Setting::find(1)->primary_color;    ?>  

	<style>
		:root{
        --primary_color: <?php echo $primary_color ?>;
        --light_primary_color: <?php echo $primary_color.'1a' ?>;
        --profile_primary_color: <?php echo $primary_color.'52' ?>;
        --middle_light_primary_color: <?php echo $primary_color.'85' ?>;
    }
  </style>
  <input type="hidden" name="base_url" id="base_url" value="{{url('/')}}">
  <input type="hidden" name="currency" id="currency" value="{{$currency}}">
  <input type="hidden" name="default_lat" id="default_lat" value="{{\App\Models\Setting::find(1)->default_lat}}">
  <input type="hidden" name="default_long" id="default_long" value="{{\App\Models\Setting::find(1)->default_long}}">
  <input type="hidden" name="rtl_direction" class="rtl_direction" value="{{ session('direction') == 'rtl' ? 'true' : 'false' }}">
  
  @include('frontend.layout.search')
  @include('frontend.layout.header')
    <main id="main">
        @yield('content')
    </main>
  @include('frontend.layout.footer')

  <a href="javascript:void(0)" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{url('frontend/js/jquery.min.js')}}"></script>
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="{{url('frontend/js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script> 
  <script src="{{url('frontend/js/jquery.easing.min.js')}}"></script>
  <script src="{{url('frontend/js/validate.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
  <script src="{{url('frontend/js/scrollreveal.min.js')}}"></script>
  <script src="{{url('frontend/js/map.js')}}"></script>
  
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <?php $client_id = \App\Models\PaymentSetting::find(1)->paypalClientId;
        $cur = \App\Models\Setting::find(1)->currency;
        $map_key = \App\Models\Setting::find(1)->map_key;
  ?>            
  @if($client_id!=null)
    <script src="https://www.paypal.com/sdk/js?client-id={{$client_id}}&currency={{$cur}}"  data-namespace="paypal_sdk"></script>
  @endif
  <script src="https://maps.googleapis.com/maps/api/js?key={{$map_key}}&callback=initAutocomplete&libraries=places" async defer></script>        
  <script src="{{url('frontend/js/main.js')}}"></script>
  <script src="{{url('frontend/js/custom.js')}}"></script>
</body>

</html>