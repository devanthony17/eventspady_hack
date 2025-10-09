@extends('frontend.master', ['activePage' => 'blog'])

@section('content')
 
    @include('frontend.layout.breadcrumbs', [
        'title' => __('Our Latest Blog'),            
        'page' => __('Blogs'),            
    ]) 

  
<section class="property-grid grid">
    <div class="container">
      <div class="row">
     
        @foreach ($blogs as $item)
            <div class="col-lg-4">
              <div class="owl-theme blog-section mb-5">                
                  <div class="carousel-item-c">
                    
                    <div class="card-box-b card-shadow news-box radius-10">
                      <div class="fav-section">                     
                        @if(Auth::guard('appuser')->check())                                     
                          <button type="button" onclick="addFavorite({{$item->id}},'blog')" class="btn p-0">
                            <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite_blog)))==true?'active':''}}"></i>
                          </button>
                        @else 
                          <button type="button" class="btn p-0">
                            <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a>
                          </button>
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
                          <a href="{{url('blog-detail/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->title))}}" title="{{$item->title}}">{{strlen($item->title)>=50? substr($item->title,0,50).'...':$item->title}} </a>
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
      </div>

    </div>
</section>

@endsection