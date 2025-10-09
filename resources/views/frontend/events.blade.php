@extends('frontend.master', ['activePage' => 'event'])

@section('content')
 
    @include('frontend.layout.breadcrumbs', [
        'title' => __('Events'),            
        'page' => __('Events'),            
    ]) 

<section class="property-grid grid">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 all-event">
          <div class="grid-option">  
            <p>{{count($events)}} {{__('events found')}}</p>   
            <div class="dropdown">
              <a class="dropdown-toggle" href="javascript:void(0)" id="filterDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-filter"></i></a>
              <div class="dropdown-menu" aria-labelledby="filterDropdown">
                <a class="dropdown-item" href="{{url('event-type/all')}}">{{__('All')}}</a>
                <a class="dropdown-item" href="{{url('event-type/online')}}">{{__('Online Events')}}</a>
                <a class="dropdown-item" href="{{url('event-type/offline')}}">{{__('Venue')}}</a>                
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="grid-option">

            <div id="filterChipsContainer" class = "chip-group" style = "display:inline-flex;">
              @if(isset($category)) 
              <div class ="chip">
                <span>{{$category->name}}</span>
                <button class="chip-button" type="button" id="category-{{$category->id}}" aria-label="Remove chip"><i class="fa fa-times-circle"></i></button>
              </div>
              @endif  
              @if(isset($type))
              <div class ="chip">
                <span>{{$type}}</span>
                <button class="chip-button" type="button" id="type-{{$type}}" aria-label="Remove chip"><i class="fa fa-times-circle"></i></button>
              </div>
              @endif
              @if(isset($chip) && count($chip)>0)
                @foreach ($chip as $item)
                  <div class ="chip">
                    <span>{{$item}}</span>
                    <button class="chip-button" type="button" id="chip-{{$item}}" aria-label="Remove chip"><i class="fa fa-times-circle"></i></button>
                  </div>  
                @endforeach
              @endif
            </div>  
          </div>
        </div>
        @if(count($events) == 0)
          <div class="col-lg-12 text-center">
            <div class="empty-state">
              <img src="{{url('frontend/images/empty.png')}}">
              <h6 class="mt-4"> {{__('No Events found')}}!</h6>
            </div>
          </div>  
        @else
          @foreach ($events as $item)
            <div class="col-md-4 events">
                <div class="fav-section">  
                  @if(Auth::guard('appuser')->check())                                     
                    <button type="button" onclick="addFavorite({{$item->id}},'event')" class="btn p-0"> <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite)))==true?'active':''}}"></i></button>
                  @else 
                    <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                  @endif
                </div>
                <div class="card-box-a card-shadow box-shadow radius-10">
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
        @endif              
      </div>
  
    </div>
</section>

@endsection