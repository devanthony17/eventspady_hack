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
          --middle_light_primary_color: <?php echo $primary_color.'85' ?>; 
    }
  </style>

    <main id="main">
   <div class="Flex-nqja63-0 styled__FormLayoutContainer-mxvrth-0 dyOnPt">
       <div class="styled__DesktopContainer-sc-1nt3iyl-1 eVYhre">  
        
            <a href="{{url()->previous()}}">
            <svg class="Icon-c98r68-0 dmBUzh Icon-c98r68-1 hFwlVf" viewBox="0 0 24 24">
                <path fill="#101928" fill-rule="evenodd" d="M8.707 4.293a1 1 0 00-1.414 0l-7 7A1.006 1.006 0 000 12l.004-.086a1.006 1.006 0 00-.003.054L0 12a1.018 1.018 0 00.146.52 1.035 1.035 0 00.147.187l-.08-.09.007.008.073.082 7 7a1 1 0 001.414-1.414L3.415 13H21a1 1 0 00.993-.883L22 12a1 1 0 00-1-1H3.415l5.292-5.293a1 1 0 00.083-1.32z">
                </path>
            </svg>
            </a>
            <a class="BaseLogo-r1a8fi-0 kIkgUX styled__StyledLogo-sc-1nt3iyl-2 oZWmv"><img src="{{url('frontend/images/logo.png')}}"> </a>
        </div>

        @yield('content')

        <p class="text-center mt-4">
           {{\App\Models\Setting::find(1)->footer_copyright}}{{__(' Made with')}} <i class="fa fa-heart text-danger"></i> {{__('By')}} <a href="https://thirstydevs.com">SaaSMonks.</a>
        </p>
    </div>
    </main> 

  <a href="javascript:void(0)" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{url('frontend/js/jquery.min.js')}}"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="{{url('frontend/js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script> 
  <script src="{{url('frontend/js/jquery.easing.min.js')}}"></script>
  <script src="{{url('frontend/js/validate.js')}}"></script>
  <script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
  <script src="{{url('frontend/js/scrollreveal.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{url('frontend/js/main.js')}}"></script>
  <script src="{{url('frontend/js/custom.js')}}"></script>

</body>
</html>