@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Add Banner'),
        'headerData' => __('Banner') ,
        'url' => 'banner' ,
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8"><h2 class="section-title"> {{__('Add banner')}}</h2></div>
        </div>
       @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                    <form method="post" action="{{url('banner')}}" enctype="multipart/form-data" >
                        @csrf

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group center">
                                    <label>{{__('Image')}}</label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label"> <i class="fas fa-plus"></i></label>
                                        <input type="file" name="image" id="image-upload" />
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label>{{__('Title')}}</label>
                                    <input type="text" name="title" placeholder="{{__('Title')}}" value="{{old('title')}}" class="form-control @error('title')? is-invalid @enderror">
                                    @error('title')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{__('Description')}}</label>
                                    <textarea name="description" placeholder="{{__('Description')}}" class="form-control @error('description')? is-invalid @enderror">{{old('description')}}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>{{__('status')}}</label>
                                    <select name="status" class="form-control select2">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
