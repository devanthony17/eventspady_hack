@extends('frontend.master', ['activePage' => 'profile'])

@section('content')
  
    <section class="agent-single">
        <div class="profile-top-section" style="background-image: url('https://wallpapercave.com/wp/q1QDvC6.jpg')"> 
            <div class="profile-overly"></div>
        </div>
        <div class="container">
            <div class="row">

                
                <div class="col-lg-4 profile-left">
                    <div class="profile-image text-center">
                        <img src="{{url('images/upload/'.$user->image)}}" id="imagePreview" class="avatar">
                        <div class="edit-profile-img"> 
                          <form method="post" action="#" id="imageUploadForm" enctype="multipart/form-data" >
                            @csrf 
                            <input type="file" name="image" id="imgUpload" class="hide">
                          </form>
                            <span id="OpenImgUpload"><i class="fa fa-camera"></i></span>
                        </div>
                    </div>
                    <div class="user-description">
                        <h4 class="text-center mb-1">{{$user->name.' '.$user->last_name}}</h4>
                        <p class="text-center mb-1"><i class="fa fa-map-marker pr-2"></i>{{$user->address}}</p>
                        <p class="text-center"><i class="fa fa-envelope pr-2"></i>{{$user->email }}</p>
                        
                    </div>
                    <div class="user-description bio-section px-5 mt-4">
                        @if($user->bio==null)
                        <p class="text-center">
                            <input type="text" name="bio" placeholder="{{ __('Your Bio') }}" class="bio-control hide">
                            <button class="btn btn-bio">{{__('Add Bio')}} <i class="fa fa-pencil pl-1"></i></button>
                        </p>
                        @else
                            <p class="detail-bio">{{$user->bio}}</p>
                        @endif                      
                    </div>
                    <div class="profile-left-link px-5 mt-4"> 
                      <p><a href="{{url('change-password')}}"> {{__('Change Password')}}</a></p>
                      <p><a href="{{url('my-tickets')}}"> {{__('My Tickets')}}</a></p>
                      <p><a href="{{url('update_profile')}}"> {{__('Update Profile')}}</a></p>
                    </div>
                </div>
                <div class="col-lg-8 profile-right">  
                    <div class="row">
                      <div class="col-12">
                        @if (session('status'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                              {{ session('status') }}                              
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                        @endif
                      </div>  
                    </div>                      
                    <ul class="nav nav-pills-a nav-pills mb-4 section-t1" id="pills-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="saved-event-tab" data-toggle="pill" href="#saved-event" role="tab" aria-controls="saved-event" aria-selected="true">{{__('saved Events')}}</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="saved-blog-tab" data-toggle="pill" href="#saved-blog" role="tab" aria-controls="saved-blog" aria-selected="false">{{__('Saved Blogs')}}</a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" id="following-tab" data-toggle="pill" href="#following" role="tab" aria-controls="following" aria-selected="false">{{__('Following')}}</a>
                        </li>               
                    </ul>
                    
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="saved-event" role="tabpanel" aria-labelledby="saved-event-tab">                  
                            <div class="row">                            
                                @if(count($user->saved_event) == 0)
                                  <div class="col-lg-12 text-center">
                                    <div class="empty-state">
                                      <img src="{{url('frontend/images/empty.png')}}">
                                      <h6 class="mt-4"> {{__('No Saved Events found')}}!</h6>
                                    </div>
                                  </div>  
                                @else
                                  @foreach ($user->saved_event as $item)
                                    <div class="col-md-4 events mb-4">
                                        <div class="fav-section">  
                                          @if(Auth::guard('appuser')->check())                                     
                                            <button type="button" onclick="addFavorite({{$item->id}},'event')" class="btn p-0"> <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite)))==true?'active':''}}"></i></button>
                                          @else 
                                            <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                                          @endif
                                        </div>
                                        <div class="card-box-a card-shadow">
                                        <div class="img-box-a">
                                            <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-a img-fluid">
                                        </div>
                                        <div class="card-overlay">
                                            <div class="card-overlay-a-content">
                                            <div class="card-header-a">
                                                <h2 class="card-title-a"><a href="{{url('event/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->name))}}">{{$item->name}}</a></h2>
                                            </div>
                                            <div class="card-body-a">
                                                <div class="price-box d-flex">
                                                <span class="price-a">{{$item->start_time->format('l').', '.$item->start_time->format('d F Y')}}</span>
                                                </div>
                                                <a href="{{url('event/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->name))}}" class="link-a">{{__('More Detail')}}
                                                <span class="ion-ios-arrow-forward"></span>
                                                </a>
                                            </div>
                                            <div class="card-footer-a">
                                                <ul class="card-info d-flex justify-content-around">                        
                                                    <li>
                                                        <h4 class="card-info-title">{{__('Type')}}</h4>
                                                        <span>{{$item->category->name}}</span>
                                                    </li>                                                                                                         
                                                    <li>
                                                        <h4 class="card-info-title">{{__('Available')}}</h4>
                                                        <span>{{$item->available_ticket.' ticket'}}</span>
                                                    </li>  
                                                </ul>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                  @endforeach
                                @endif              
                            </div>          
                        </div>
                        <div class="tab-pane fade" id="saved-blog" role="tabpanel" aria-labelledby="saved-blog-tab">
                            <div class="row">  
                                @if(count($user->saved_blog) == 0)
                                    <div class="col-lg-12 text-center">
                                        <div class="empty-state">
                                            <img src="{{url('frontend/images/empty.png')}}">
                                            <h6 class="mt-4"> {{__('No Saved Blog found')}}!</h6>
                                        </div>
                                    </div>  
                                @else   
                                  @foreach ($user->saved_blog as $item)
                                    <div class="col-lg-4">
                                      <div class="owl-theme blog-section mb-4">                
                                          <div class="carousel-item-c">                                            
                                            <div class="card-box-b card-shadow news-box">
                                              <div class="fav-section">                     
                                                @if(Auth::guard('appuser')->check())                                     
                                                  <button type="button" onclick="addFavorite({{$item->id}},'blog')" class="btn p-0"> <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite_blog)))==true?'active':''}}"></i></button>
                                                @else 
                                                  <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                                                @endif
                                              </div>
                                              <div class="img-box-b">
                                                <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-b img-fluid">
                                              </div>
                                              <div class="card-overlay"></div>               
                                            </div>
                                            <div class="card-header-b">
                                              <div class="card-title-b">
                                                <h2 class="title-2">
                                                  <a href="javascript:void(0)" title="{{$item->title}}">{{strlen($item->title)>=40? substr($item->title,0,40).'...':$item->title}} </a>
                                                </h2>
                                              </div>
                                              <div class="card-category-b">
                                                <span><i class="fa fa-sitemap"></i>{{$item->category->name}}</span>
                                                <span class="date-b"><i class="fa fa-calendar"></i>{{$item->created_at->format('d M.Y')}}</span>
                                              </div>                     
                                            </div>
                                          </div> 
                                        
                                      </div>
                                    </div>
                                  @endforeach  
                                @endif            
                            </div>                 
                        </div>    
                        <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="following-tab">
                           @foreach ($user->following as $item)
                            <div class="row org-list mb-3 pb-3">
                                <div class="col-lg-2">
                                    <img class="w-100 avatar" src="{{url('images/upload/'.$item->image)}}">
                                </div>  
                                <div class="col-lg-7">
                                    <h5 class="mt-2">{{$item->first_name.' '.$item->last_name}}</h5>    
                                    <p>{{$item->email}}</p>
                                </div>  
                                <div class="col-lg-3">
                                    <button type="button" onclick="follow({{$item->id}})" class="btn btn-primary mt-3"> {{__('Unfollow')}}</button>
                                </div>
                            </div>    
                           @endforeach                   
                        </div>                           
                    </div> 

                </div>
            </div>
        </div>
    </section>


@endsection