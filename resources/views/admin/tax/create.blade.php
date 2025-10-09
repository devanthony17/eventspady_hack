@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Add Tax'),  
        'headerData' => __('Tax') ,
        'url' => 'tax' ,          
    ]) 

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8"><h2 class="section-title"> {{__('Add Tax')}}</h2></div>         
        </div>       
       
        <div class="row">
            <div class="col-12">
              <div class="card">     
                <div class="card-body">
                    <form method="post" action="{{url('tax')}}">
                        @csrf
                        <div class="form-group">
                            <label>{{__('Name')}}</label>
                            <input type="text" name="name" placeholder="{{__('Name')}}" value="{{old('name')}}" class="form-control @error('name')? is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{__('Charges')}}</label>
                            <input type="number" min="1" name="price" placeholder="{{__('Charges')}}" value="{{old('price')}}" class="form-control @error('price')? is-invalid @enderror">
                            @error('price')
                                <div class="invalid-feedback">{{$message}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{__('status')}}</label>
                            <select name="status" class="form-control select2">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0" {{old('status')=="0"?'selected':''}}>{{ __('Inactive') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{$message}}</div>
                            @endif
                        </div>
                     
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox"  name="allow_all_bill" value="1" class="custom-control-input" tabindex="3" id="allow_all_bill">
                              <label class="custom-control-label" for="allow_all_bill">{{__('Allow this tax in all bills')}}</label>
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
