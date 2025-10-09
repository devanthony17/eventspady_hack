@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Notification Template'),            
    ]) 

    <div class="section-body">       
       
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
            <div class="col-12">
              <div class="card">     
                <div class="card-header">
                    <h5>{{__('Notification Template')}}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4 mt-2">
                        <div class="col-lg-8"><h2 class="section-title mt-0"> {{__('Notification Template')}}</h2></div>
                        <div class="col-lg-4 text-right">
                            @can('notification_template_create')
                            <button class="btn btn-primary add-button"><a href="{{url('notification-template/create')}}"><i class="fas fa-plus"></i> {{__('Add New')}}</a></button>                
                            @endcan
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="template-left">
                                @foreach ($data as $item)
                                    @if($loop->iteration==1)
                                        <?php $template = $item;?>
                                    @endif
                                    <div class="template-row mb-4">                                      
                                        <button onclick="notificationDetail({{$item->id}});" class="btn btn-primary template-btn"> {{$item->title}}</button>    
                                    </div>
                                @endforeach                                
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <form action="{{url('notification-template/'.$template->id)}}" id="edit-template-form" method="post">
                                @csrf 
                                @method('PUT')
                                <div class="form-group">
                                    <label>{{__('Subject')}}</label>
                                    <input type="text" name="subject" placeholder="{{__('Subject')}}" value="{{isset($template) ? $template->subject: ''}}" class="form-control @error('subject')? is-invalid @enderror">
                                    @error('subject')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>{{__('Email Content')}}</label>
                                    <textarea name="mail_content" Placeholder ="{{__('Email Content')}}" class="textarea_editor @error('mail_content')? is-invalid @enderror">
                                        {{isset($template) ? $template->mail_content: ''}}
                                    </textarea>
                                    @error('mail_content')
                                        <div class="invalid-feedback block">{{$message}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>{{__('App notification message Content')}}</label>
                                    <textarea name="message_content" id="message_content" placeholder="{{__('App notification message Content')}}" class="form-control @error('message_content')? is-invalid @enderror">{{isset($template) ? $template->message_content: ''}}</textarea>
                                    @error('message_content')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                                <div class="form-group">                            
                                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>                                    
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2">
                            <h5 class="text-muted">{{__('Email Placeholder')}}</h5>
                            <div class="email-holder"> 
                                <span class="d-block" data-toggle="tooltip" data-title="Customer Name" data-original-title="" title="">
                                    <button class="btn" type="button">@{{user_name}}</button>
                                </span>
                                <span class="d-block" data-toggle="tooltip" data-title="Organizer Name" data-original-title="" title="">
                                    <button class="btn" type="button">@{{organizer_name}}</button>
                                </span>
                                <span class="d-block" data-toggle="tooltip" data-title="Application Name" data-original-title="" title="">
                                    <button class="btn" type="button">@{{app_name}}</button>
                                </span>
                                <span class="d-block" data-toggle="tooltip" data-title="Event Name" data-original-title="" title="">
                                    <button class="btn" type="button">@{{event_name}}</button>
                                </span>
                                <span class="d-block" data-toggle="tooltip" data-title="Event date" data-original-title="" title="">
                                    <button class="btn" type="button">@{{date}}</button>
                                </span>
                                <span class="d-block" data-toggle="tooltip" data-title="Number of purchased tickets" data-original-title="" title="">
                                    <button class="btn" type="button">@{{quantity}}</button>
                                </span>
                                <span class="d-block" data-toggle="tooltip" data-title="Password" data-original-title="" title="">
                                    <button class="btn" type="button">@{{password}}</button>
                                </span>                               
                            </div>
                        </div>
                    </div>                                               

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
