<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="javascript:void(0)" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>      
    </ul>
     
   
  </form>
  <ul class="navbar-nav navbar-right">    
    @if(Auth::user()->hasRole('organization'))
    <li>
      @php
        $notification = \App\Models\Notification::where('organizer_id',Auth::user()->id)->orderBy('id','DESC')->get();
      @endphp

      <a href="javascript:void(0)" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">{{__('Notifications')}}
          <div class="float-right">            
          </div>
        </div>
         
          @if(count($notification)==0)
            <div class="dropdown-list-content dropdown-list-icons"> 
              <a href="javascript:void(0)" class="dropdown-item">             
                <div class="dropdown-item-desc">
                  <h6>{{__('No notification found')}}</h6>
                </div>
              </a> 
            </div>
          @else 
            <div class="dropdown-list-content dropdown-list-icons"> 
              @foreach ($notification as $item)
                @if($item->user!=null)
                @if($loop->iteration<=3)
                  <a href="javascript:void(0)" class="dropdown-item">
                    <div class="dropdown-item-icon bg-danger text-white">                    
                      <img class="avatar" src="{{url('images/upload/'.$item->user->image)}}">
                    </div>
                    <div class="dropdown-item-desc">
                        {{$item->message}}
                        <div class="time">{{$item->created_at->diffForHumans()}}</div>
                    </div>
                  </a> 
                @endif
                @endif
              @endforeach  
            </div>
            <div class="dropdown-footer text-center">
              <a href="{{url('notification')}}">{{__('View All')}} <i class="fas fa-chevron-right"></i></a>
            </div>
          @endif
      </div>
    </li>
    @endif
    <?php $lang = session('locale')==null?"English":session('locale'); ?>
    @php
        $languages = \App\Models\Language::where('status',1)->get();
    @endphp
    <li class="dropdown"><a href="javascript:void(0)" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img src="{{url('images/upload/'.$lang.'.png')}}" class="mr-1 flag-icon">
      <div class="d-sm-none d-lg-inline-block"></div></a>
      <div class="dropdown-menu dropdown-menu-right">
        @foreach ($languages as $language)
          <a href="{{url('change-language/'.$language->name)}}" class="dropdown-item has-icon">
            <img src="{{url('images/upload/'.$language->image)}}" class="mr-2 flag-icon"> {{$language->name}}
          </a>
        @endforeach
      </div>
    </li>

    <li class="dropdown"><a href="javascript:void(0)" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <img alt="image" src="{{url('images/upload/'.Auth::user()->image)}}" class="rounded-circle mr-1">
      <div class="d-sm-none d-lg-inline-block">{{Auth::user()->name}}</div></a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">{{__('Welcome')}} {{Auth::user()->name}}!</div>
        <a href="{{url('profile')}}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> {{__('Profile')}}
        </a>  
        @if(Auth::user()->hasRole('admin')) 
        <a href="{{url('admin-setting')}}" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> {{__('Settings')}}
        </a>
        <a href="{{url('license-setting')}}" class="dropdown-item has-icon">
          <i class="fas fa-shield-alt"></i> {{__('License Setting')}}
        </a>
        @endif
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> {{__('Logout')}}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>