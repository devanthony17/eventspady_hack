@extends('frontend.master', ['activePage' => 'event'])

@section('content')
 
    @include('frontend.layout.breadcrumbs', [
        'title' => $data->name,            
        'page' => __('Event Detail'),            
    ]) 

  <section class="property-single nav-arrow-b">
    <div class="container">
      <div class="row">
          <div class="col-lg-12">
            @if (session('status'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('status') }}                 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
            @endif
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12" >
            <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
                <div class="carousel-item-b">
                  <img src="{{url('images/upload/'.$data->image)}}" alt="">
                </div>
                @foreach (explode(',',$data->gallery) as $item)
                    <div class="carousel-item-b">
                        <img src="{{url('images/upload/'.$item)}}" alt="">
                    </div> 
                @endforeach
              </div>
          </div>
        
        <div class="col-sm-12">                   
            <div class="row justify-content-between">
                <div class="col-lg-7">
                    <div class="title-box-d">
                        <h3 class="title-d">{{$data->name}}</h3>
                        <p class="mb-0">{{__('By')}}: <a href="{{url('organization/'.$data->organization->id.'/'.$data->organization->first_name.'-'.$data->organization->last_name)}}">{{$data->organization->first_name.' '.$data->organization->last_name}}</a></p>
                    </div>                    
                    <div class="rating mb-2"> 
                       @for ($i = 1; $i <= 5; $i++)
                          <i class="fa fa-star {{$data->rate>=$i?'active':''}}"></i>
                       @endfor
                    </div>
                    <div class="property-description">
                        <p class="description color-text-a mb-4">
                            {!!$data->description!!}
                        </p>   
                        <ul class="tags">
                            @if($data->type=="online")
                            <li><a href="javascript:void(0)" class="tag">{{__('Online event')}}</a></li>
                            @endif
                            <li><a href="javascript:void(0)" class="tag">{{$data->category->name}}</a></li>
                            @foreach (array_filter(explode(',',$data->tags)) as $item)                            
                                <li><a href="javascript:void(0)" class="tag">{{$item}}</a></li>
                            @endforeach                        
                        </ul>                                                       
                    </div>
                </div>    
                <div class="col-lg-5">
                    <div class="property-summary">
                       
                        <div class="summary-list">
                          <div class="summery-top">
                            <span class="event-date-time">{{$data->start_time->format('l').', '.$data->start_time->format('M d, Y h:i a').'  to'}} </span>
                            <span class="event-date-time">{{$data->end_time->format('l').', '.$data->end_time->format('M d, Y h:i a')}} </span>
                            
                            <span class="event-date-time">
                              @if($data->type=="online")
                              {{__('Online Event')}}
                              @else 
                                <i class="fa fa-map-marker text-primary pr-2"></i>{{$data->address}} 
                              @endif
                            </span>
                            <p class="mt-2"><i class="fa fa-users pr-2 text-primary "></i>{{$data->people .' People'}}</p>
                          </div>
                          <div class="summery-org mt-4">
                            <h4 class="mb-4"> {{__('Organised by')}}</h4>
                            <div class="row">
                              <div class="col-3">
                                <img  class="org-img" src="{{url('images/upload/'.$data->organization->image)}}">
                              </div>
                              <div class="col-9">
                                <p class="mb-0">{{$data->organization->first_name.' '.$data->organization->last_name}}</p>
                                <p>{{$data->organization->name.' Organization'}}</p>
                                
                              </div>
                              <div class="col-12 mt-3">
                                <span>{{$data->organization->bio}}</span>
                                <button class="btn d-block pl-0 mt-3 text-primary"><a href="{{url('organization/'.$data->organization->id.'/'.$data->organization->first_name.'-'.$data->organization->last_name)}}"> {{__('Profile')}}</a></button>
                              </div>
                            </div>
                          </div>
                         
                        </div>
                      </div>
                </div>
                    
            </div>
        </div>
        <div class="col-md-12 ticket-section">
            <div class="title-box-d">
                <h3 class="title-d">{{__('Tickets on sale')}}</h3>
            </div>
            <ul class="nav nav-pills-a nav-pills mb-4 section-t1" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="pills-video-tab" data-toggle="pill" href="#pills-video" role="tab" aria-controls="pills-video" aria-selected="true">{{__('Paid')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-plans-tab" data-toggle="pill" href="#pills-plans" role="tab" aria-controls="pills-plans" aria-selected="false">{{__('Free')}}</a>
                </li>               
            </ul>
            
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">                  
                  <div class="row">
                    @if(count($data->paid_ticket)==0)
                      <div class="col-lg-12 text-center">
                        <div class="empty-state">
                          <img src="{{url('frontend/images/empty.png')}}">
                          <h6 class="mt-4"> {{__('No Paid Tickets found')}}!</h6>
                        </div>
                      </div>                     
                    @else
                      @foreach ($data->paid_ticket as $item)
                        <div class="col-lg-4">
                          <article class="ticket">
                            <header class="ticket__wrapper">
                              <div class="ticket__header">
                                <span>{{$item->ticket_number}}</span>
                                @if($item->type=="free")
                                <span>{{__('FREE')}}</span>
                                @else
                                  <span>{{$currency.$item->price}}</span>
                                @endif     
                              </div>
                            </header>
                            <div class="ticket__divider">
                              <div class="ticket__notch"></div>
                              <div class="ticket__notch ticket__notch--right"></div>
                            </div>
                            <div class="ticket__body">
                              <section class="ticket__section">
                                <h3>{{$item->name}}</h3>
                                <p>{{$item->description}}</p>                            
                              </section>
                              <section class="ticket__section">
                                <h3>{{__('Sales')}}</h3>
                                <p class="mb-0"><span>{{__('Start')}} : </span>{{$item->start_time->format('Y-m-d h:i a')}}</p>
                                <p class="mb-0"><span>{{__('end')}} : </span>{{$item->end_time->format('Y-m-d h:i a')}}</p>
                                @if($item->available_qty <= 0)                                
                                @else
                                  <p><span>{{__('Quantity')}} : </span>{{$item->available_qty.' pcs left'}}</p>                              
                                @endif
                              </section>                          
                            </div>
                            <footer class="ticket__footer text-right">  
                              @if($item->available_qty <= 0)
                              <p class="mt-1 mb-1 text-center coupon-data">{{__('Sold Out')}}</p>  
                              @else
                                @if(Auth::guard('appuser')->check())
                                  <a href="{{url('checkout/'.$item->id)}}"><button class="btn btn-a" >{{__('Book Now')}}</button></a>
                                @else
                                  <a href="{{url('user/login')}}"><button class="btn btn-a" >{{__('Book Now')}}</button></a>
                                @endif
                              @endif
                            </footer>
                          </article>
                        </div>                     
                      @endforeach
                    @endif   
                  </div>            
                </div>
                <div class="tab-pane fade" id="pills-plans" role="tabpanel" aria-labelledby="pills-plans-tab">
                  <div class="row">
                    @if(count($data->free_ticket)==0)
                      <div class="col-lg-12 text-center">
                        <div class="empty-state">
                          <img src="{{url('frontend/images/empty.png')}}">
                          <h6 class="mt-4"> {{__('No Free Tickets found')}}!</h6>
                        </div>
                      </div>                     
                    @else
                      @foreach ($data->free_ticket as $item)
                        <div class="col-lg-4">
                          <article class="ticket">
                            <header class="ticket__wrapper">
                              <div class="ticket__header">
                                <span>{{$item->ticket_number}}</span>
                                @if($item->type=="free")
                                <span>FREE</span>
                                @else
                                  <span>{{$currency.$item->price}}</span>
                                @endif     
                              </div>
                            </header>
                            <div class="ticket__divider">
                              <div class="ticket__notch"></div>
                              <div class="ticket__notch ticket__notch--right"></div>
                            </div>
                            <div class="ticket__body">
                              <section class="ticket__section">
                                <h3>{{$item->name}}</h3>
                                <p>{{$item->description}}</p>                            
                              </section>
                              <section class="ticket__section">
                                <h3>{{__('Sales')}}</h3>
                                <p class="mb-0"><span>{{__('Start')}} : </span>{{$item->start_time->format('Y-m-d h:i a')}}</p>
                                <p class="mb-0"><span>{{__('end')}} : </span>{{$item->end_time->format('Y-m-d h:i a')}}</p>
                                @if($item->available_qty <= 0)
                                                         
                                @else
                                  <p><span>{{__('Quantity')}} : </span>{{$item->available_qty.' pcs left'}}</p>                              
                                @endif
                              </section>                          
                            </div>
                            <footer class="ticket__footer text-right"> 
                              @if($item->available_qty <= 0)
                              <p class="mt-1 mb-1 text-center coupon-data">Sold Out</p>  
                              @else
                                @if(Auth::guard('appuser')->check())
                                  <a href="{{url('checkout/'.$item->id)}}"><button class="btn btn-a">{{__('Book Now')}}</button></a>
                                @else
                                  <a href="{{url('user/login')}}"><button class="btn btn-a">{{__('Book Now')}}</button></a>
                                @endif    
                              @endif                                                
                            </footer>
                          </article>
                        </div>                     
                      @endforeach
                    @endif
                  </div>                   
                </div>                            
            </div> 
            
        </div>
     
        <div class="col-md-12 col-lg-12 mt-8">
          <div class="form-comments">
            <div class="title-box-d">
              <h3 class="title-d"> {{__('Report Event')}}</h3>
            </div>
            <form class="form-a" method="post" action="{{url('report-event')}}"> 
              @csrf
              <div class="row">
                
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label for="inputName">{{__('Enter name')}}</label>
                    <input type="text" name="name" class="form-control form-control-lg form-control-a" id="inputName" placeholder="{{ __('Name *') }}" required>
                  </div>
                </div>
                <input type= "hidden" name="event_id" value="{{$data->id}}">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label for="inputEmail1">{{__('Enter email')}}</label>
                    <input type="email" name="email" class="form-control form-control-lg form-control-a" id="inputEmail1" placeholder="{{ __('Email *') }}" required>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label for="inputUrl">{{__('Reason')}}</label>
                    <select class="form-control form-control-lg form-control-a select2" name="reason" required>
                      <option value=""> {{ __('Select Reason') }}</option>
                      <option value="Canceled Event">{{ __('Canceled Event') }}</option>
                      <option value="Copyright or Trademark Infringement">{{ __('Copyright or Trademark Infringement') }}</option>
                      <option value="Fraudulent of Unauthorized Event">{{ __('Fraudulent of Unauthorized Event') }}</option>
                      <option value="Offensive or Illegal Event">{{ __('Offensive or Illegal Event') }}</option>
                      <option value="Spam">{{ __('Spam') }}</option>
                      <option value="Other">{{ __('Other') }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label for="textMessage">{{__('Enter message')}}</label>
                    <textarea id="textMessage" required class="form-control" placeholder="{{ __('Comment *') }}" name="message" cols="45" rows="5" required></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <button type="submit" class="btn btn-a">{{__('Send Message')}}</button>
                </div>
              </div>
            </form>
          </div>
          <div class="title-box-d mt-8">
          <h3 class="title-d">{{__('Reviews')}} ({{count($data->review)}})</h3>
          </div>
          <div class="box-comments">
            <ul class="list-comments">
              @if (count($data->review)==0)              
                <div class="empty-state text-center">
                  <img src="{{url('frontend/images/empty.png')}}">
                  <h6 class="mt-4"> {{__('No Reviews found')}}!</h6>
                </div>                
              @else
                @foreach ($data->review as $item)
                  <li>
                    <div class="comment-avatar">
                      <img src="{{$item->user->imagePath .'/'.$item->user->image }}" alt="">
                    </div>
                    <div class="comment-details">
                      <h4 class="comment-author"> {{$item->user->name .' '.$item->user->last_name }} </h4>
                      <span> {{\Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i a')}} </span>
                      <p class="comment-description">
                        {{$item->message}}
                      </p>
                    </div>
                  </li>
                @endforeach
              @endif                                    
            </ul>
          </div>
         
        </div>


      </div>
    </div>
  </section>

@endsection