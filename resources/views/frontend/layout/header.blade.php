<nav class="navbar navbar-default navbar-trans navbar-expand-lg top-header fixed-top {{url()->current() == url('/')?'':'navbar-another'}}">
    <div class="container">       
      <a class="navbar-brand text-brand" href="{{url('/')}}">
        <img src="{{url('frontend/images/logo.png')}}">
      </a>   
      <div class="navbar-collapse collapse justify-content-center">     
        <div class="search-location">
          <input type="text" name="location" id="search_address" placeholder="{{__('Search Location')}}">
          <i class="fa fa-map-marker"></i>
        </div>
      </div>
      <button type="button" class="btn btn-b-n navbar-toggle-box-collapse d-none d-md-block search-btn" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-expanded="false">
        <span class="fa fa-search" aria-hidden="true"></span>
      </button>
      @if(Auth::guard('appuser')->check())  
        <div class="dropdown ml-2 profileDropdown"> 
            <a class="dropdown-toggle" href="javascript:void(0)" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="header-profile-img" src="{{url('images/upload/'.Auth::guard('appuser')->user()->image)}}">
            </a>
            <div class="dropdown-menu" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="{{url('user/profile')}}">{{__('Profile')}}</a>
              <a class="dropdown-item" href="{{url('my-tickets')}}">{{__('My Tickets')}}</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">{{__('Logout')}}</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
        </div>
      
      @endif
     
    </div>
</nav>

<nav class="navbar navbar-default navbar-trans navbar-expand-lg menu-header second-menu">
  <div class="container">
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-expanded="false">
      <span class="fa fa-search" aria-hidden="true"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarDefault">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'home'  ? 'active' : ''}}" href="{{url('/')}}"><i class="fa fa-home"></i>{{__('Home')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'event'  ? 'active' : ''}}" href="{{url('all-events')}}"><i class="fa fa-calendar"></i>{{__('Events')}}</a>
        </li>       
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ $activePage == 'category'  ? 'active' : ''}}" href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bars"></i>{{__('Explore Category')}}
          </a>
          <?php $category = App\Models\Category::where('status',1)->orderBy('id','DESC')->get(); ?>
          <div class="dropdown-menu active" aria-labelledby="navbarDropdown">
            @foreach ($category as $item)
              <a class="dropdown-item {{ request()->is('events-category/'.$item->id.'/'. preg_replace('/\s+/', '-', $item->name))  ? 'active' : ''}}" href="{{url('events-category/'.$item->id.'/'. preg_replace('/\s+/', '-', $item->name))}}">{{$item->name}}</a>
            @endforeach
            <a class="dropdown-item {{ request()->is('all-category')  ? 'active' : ''}}" href="{{url('all-category')}}">{{__('All Category')}}</a>           
          </div>
        </li>
      
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'blog'  ? 'active' : ''}}" href="{{url('all-blogs')}}"><i class="fa fa-file"></i>{{__('Blogs')}}</a>
        </li>          
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'contact'  ? 'active' : ''}}" href="{{url('contact')}}"><i class="fa fa-id-badge"></i>{{__('Contact')}}</a>
        </li>
        @if(!Auth::guard('appuser')->check())
          @php
              Auth::logout();
          @endphp
        <li class="nav-item">
          <a class="nav-link" href="{{url('user/login')}}"><i class="fa fa-lock"></i>{{__('Sign in')}}</a>
        </li>
        @else 
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'ticket'  ? 'active' : ''}}" href="{{url('my-tickets')}}"><i class="fa fa-ticket"></i>{{__('My Tickets')}}</a>
        </li>
        @endif
      </ul>
    </div>
   
  </div>
</nav>
  
  @if(url()->current() == url('/'))
  
  <?php $banner = App\Models\Banner::where('status',1)->orderBy('id','DESC')->get(); ?>
    <div class="intro intro-carousel">
      <div id="carousel" class="owl-carousel owl-theme">
        @foreach ($banner as $item)
          <div class="carousel-item-a intro-item bg-image" style="background-image: url({{url('images/upload/'.$item->image)}})">
            <div class="overlay overlay-a"></div>
            <div class="intro-content display-table">
              <div class="table-cell">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="intro-body">                  
                        <h1 class="intro-title mb-4">
                          <span class="color-b">{{explode(' ',$item->title)[0]}} </span>
                          @foreach (explode(' ',$item->title) as $item)
                            {{$loop->iteration>1?$item:''}}
                          @endforeach
                        </h1>
                        <p class="intro-subtitle intro-price">
                          <a href="{{url('all-events')}}"><span class="price-a">{{__('Book Now')}}</span></a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>    
        @endforeach             
      </div>
    </div>

  @endif
