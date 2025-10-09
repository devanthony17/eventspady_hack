@extends('frontend.auth.app')

@section('content')
  
    <div class="Card-sc-8zkhaa-0 styled__StyledCard-mxvrth-1 fogDtz">
        <form action="{{url('update_user_profile')}}" method="post"  data-qa="form-login" name="login">
        @csrf
            <p data-qa="title" class="Text-st1i2q-0 styled__Title-sc-1subqgs-0 jTZzYs">{{__('Update User Profile')}}</p>            
            <div class="NGrUbJBA _1Z8A3Tz5 _1FaKA6Nk _3cNt_ILG LoginForm__StyledGrid-sc-1jdwe0j-1 iPBaVu">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                            <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('First Name')}}</label></div>
                            <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                <input autocomplete="off" class="RJT7RW5k" required name="name" type="text" value="{{ $user->name }}" placeholder="{{ __('First Name') }}">
                            </div>
                            @error('name')
                                <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                            @endif                   
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                            <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Last Name')}}</label></div>
                            <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                <input autocomplete="off" class="RJT7RW5k" required name="last_name" value="{{$user->last_name}}"  type="text" placeholder="{{ __('Last Name') }}">
                            </div>
                            @error('last_name')
                                <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                            @endif                   
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                            <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Email')}}</label></div>
                            <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                <input autocomplete="off" class="RJT7RW5k" required name="email" type="email" value="{{$user->email}}" readonly placeholder="{{ __('Your Email') }}">
                            </div>
                            @error('email')
                                <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                            @endif                   
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                            <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Phone')}}</label></div>
                            <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                <input autocomplete="off" class="RJT7RW5k" required name="phone" type="text" value="{{$user->phone}}"  placeholder="{{ __('Contact') }}">
                            </div>
                            @error('phone')
                                <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                            @endif                   
                        </div>
                    </div>
                </div>
               
                <div class="_1RLMtIP3 Qso_pkui mb-4">
                    <div class="_2iCrTJcD"> <label class="_2x_Fz5Ot" data-qa="label-name">{{__('Select Language')}}</label> </div>
                    <div class="_2fessCXR p2xx3nlH">
                        <select required name="language" class="form-control select2">
                            <option value="">{{ __('Select default Language') }}</option>
                            @foreach ($languages as $language)
                                <option value="{{$language->name}}"{{$language->name==$user->language?'Selected' : ''}}>{{$language->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('password')
                        <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                    @endif
                </div>
            </div>
           
            <div class="Flex-nqja63-0 styled__ButtonWrapper-sc-1vy69nr-0 lhtHXX">
                <button type="submit" data-qa="login-button" class="styled__ButtonWrapper-sc-56doij-3 hnulbU">
                    {{__('Change')}}
                </button>
            </div>
          
        </form>
    </div>
  


@endsection