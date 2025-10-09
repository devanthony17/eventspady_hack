@extends('frontend.master', ['activePage' => 'orgDetail'])

@section('content')
    @include('frontend.layout.breadcrumbs', [
        'title' => $data->first_name.' '.$data->last_name,            
        'page' => $data->first_name.' '.$data->last_name,            
    ]) 
  
    <section class="agent-single">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="agent-avatar-box">
                            <img src="{{url('images/upload/'.$data->image)}}" alt="" class="agent-avatar w-100 img-fluid">
                        </div>
                        </div>
                        <div class="col-md-5 section-md-t3">
                            <div class="agent-info-box">
                                <div class="agent-title">
                                <div class="title-box-d">
                                    <h3 class="title-d">{{$data->first_name.' '.$data->last_name}}
                                    <br> {{$data->name}}
                                    </h3>
                                </div>
                                </div>
                                <div class="agent-content mb-3">
                                    <p class="content-d color-text-a"> {{$data->bio}} </p>
                                    <div class="info-agents color-a">
                                        <p>
                                            <strong>{{__('Phone')}}: </strong>
                                            <span class="color-text-a"> {{$data->phone}}</span>
                                        </p>
                                        @if($data->country!=null)
                                        <p>
                                            <strong>{{__('From')}}: </strong>
                                            <span class="color-text-a"> {{$data->country}}</span>
                                        </p>
                                        @endif
                                        <p>
                                        <strong>{{__('Email')}}: </strong>
                                        <span class="color-text-a"> {{$data->email}}</span>
                                        </p> 
                                        @if(Auth::guard('appuser')->check())
                                            <button type="button" onclick="follow({{$data->id}})" class="btn btn-a mt-2">{{in_array($data->id,array_filter(explode(',',Auth::guard('appuser')->user()->following)))==true?__('Unfollow'):__('Follow').' +'}}</button>                                                               
                                        @else 
                                            <button type="button" class="btn btn-a mt-2"><a href="{{url('user/login')}}">Follow +</button>                                                               
                                        @endif
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            

                <div class="col-md-12 section-t8">
                    <div class="title-box-d">
                    <h3 class="title-d">{{__('My Events')}} ({{$data->total_event}})</h3>
                    </div>
                </div>

                <div class="property-grid grid">
                    <div class="container">
                      <div class="row">
                      
                
                        @foreach ($data->events as $item)
                            <div class="col-md-4 events">
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
                                                <h4 class="card-info-title">{{__('People')}}</h4>
                                                <span>{{$item->people}}</span>
                                              </li>
                                              <li>
                                                <h4 class="card-info-title">{{__('Sold')}}</h4>
                                                <span>{{$item->sold_ticket.' ticket'}} </span>
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
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <nav class="pagination-a">          
                            {{ $data->events->links() }}
                          </nav>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection