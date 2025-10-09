@extends('frontend.master', ['activePage' => 'category'])

@section('content')
 
    @include('frontend.layout.breadcrumbs', [
        'title' => __('Featured Category'),            
        'page' => __('Category'),            
    ]) 

<section class="property-grid grid">
    <div class="container">
      <div class="row">
        <div id="" class="category-section">
            <div class="row">
              @foreach ($data as $item)
                <div class="carousel-item-c col-lg-4 col-md-6 col-sm-12">
                  <div class="card-box-b card-shadow news-box box-shadow radius-10">
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

    </div>
</section>

@endsection