@extends('frontend.master', ['activePage' => 'blog'])

@section('content')
 
    @include('frontend.layout.breadcrumbs', [
        'title' => strlen($data->title)>=45? substr($data->title,0,45).'..':$data->title,            
        'page' => __('Blog Detail'),            
    ]) 

  <section class="news-single nav-arrow-b">
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
    
        <div class="col-sm-12">
          <div class="news-img-box">
            <img src="{{url('images/upload/'.$data->image)}}" alt="" class="img-fluid w-100">
          </div>
        </div>
        <div class="col-md-12  col-lg-12 ">
          <div class="post-information">
            <ul class="list-inline mb-0 color-a">
           
              <li class="list-inline-item mr-3">
                <strong>{{__('Category')}}: </strong>
                <span class="color-text-a ml-1">{{$data->category->name}}</span>
              </li>
              <li class="list-inline-item">
                <strong>{{__('Date')}}: </strong>
                <span class="color-text-a ml-1">{{$data->created_at->format('d F.Y')}}</span>
              </li>
            </ul>
          </div>
          <div class="post-content color-text-a mt-2">
            <p class="post-intro">{{$data->title}} </p>
            <p>{{$data->description}}</p>
            <ul class="tags">
              
                <li><a href="javascript:void(0)" class="tag">{{$data->category->name}}</a></li>
                @foreach (array_filter(explode(',',$data->tags)) as $item)                            
                    <li><a href="javascript:void(0)" class="tag">{{$item}}</a></li>
                @endforeach                        
            </ul>          
          </div>
        </div>
      
      </div>
    </div>
  </section>

@endsection