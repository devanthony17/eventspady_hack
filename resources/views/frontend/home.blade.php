@extends('frontend.master', ['activePage' => 'home'])

@section('content')
      <section class="section-property section-t8 section-b4">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="title-wrap d-flex justify-content-between">
                <div class="title-box">
                  <h2 class="title-a">{{__('Latest Events')}}</h2>
                </div>
               
              </div>
            </div>
          </div>
          <div id="" class="event-section owl-theme">
            <div class="row">            
              @foreach ($events as $item)
                @if($loop->iteration <= 6)
                <div class="carousel-item-b col-lg-4 col-md-6 col-sm-6 mb-4">
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
                          <h2 class="card-title-a">
                            <a href="{{url('event/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->name))}}">{{ $item->name}}</a>
                          </h2>
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
                @endif
              @endforeach  
            </div>         
          </div>
        </div>
      </section> 

    <section class="section-news section-t4 section-b4 mt-4 bg-gray">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">{{__('Featured Category')}}</h2>
              </div>            
            </div>
          </div>
        </div>
        <div id="" class="category-section">
          <div class="row">          
            @foreach ($category as $item)
              <div class="carousel-item-c col-lg-3 col-md-6 col-sm-6">
                <div class="card-box-b card-shadow news-box radius-10">
                  <div class="img-box-b">
                    <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-b img-fluid">
                  </div>
                  <div class="card-overlay">
                    <div class="card-header-b">                     
                      <div class="card-title-b">
                        <h2 class="title-2">
                          <a href="{{url('events-category/'.$item->id.'/'. preg_replace('/\s+/', '-', $item->name))}}">{{$item->name}}</a>
                        </h2>
                      </div>                     
                    </div>
                  </div>
                </div>
              </div>
            @endforeach    
          </div>               
        </div>
      </div>
    </section>

    <section class="section-blog section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">{{__('Our Latest Blog')}} </h2>
              </div>            
            </div>
          </div>
        </div>       
        <div id="blog-carousel" class="owl-carousel owl-theme blog-section">
          @foreach ($blog as $item)
            <div class="carousel-item-c">
              <div class="fav-section">  
                @if(Auth::guard('appuser')->check())                                     
                  <button type="button" onclick="addFavorite({{$item->id}},'blog')" class="btn p-0"> <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite_blog)))==true?'active':''}}"></i></button>
                @else 
                  <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                @endif
              </div>
              <div class="card-box-b card-shadow news-box radius-10">
                <div class="img-box-b">
                  <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-b img-fluid">
                </div>
                <div class="card-overlay"></div>               
              </div>
              <div class="card-header-b">
                <div class="card-title-b">
                  <h2 class="title-2">
                    <a href="{{url('blog-detail/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->title))}}" title="{{$item->title}}">{{strlen($item->title)>=50? substr($item->title,0,50).'...':$item->title}} </a>
                  </h2>
                </div>
                <div class="card-category-b">
                  <span><i class="fa fa-sitemap mt-6 float-left"></i>{{$item->category->name}}</span>
                  <span class="date-b"><i class="fa fa-calendar"></i>{{$item->created_at->format('d M.Y')}}</span>
                </div>            
              </div>
            </div> 
          @endforeach
        </div>
      </div>
    </section>
@endsection