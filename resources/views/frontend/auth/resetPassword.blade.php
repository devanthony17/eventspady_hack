@extends('frontend.auth.app')

@section('content')
  
    <div class="Card-sc-8zkhaa-0 styled__StyledCard-mxvrth-1 fogDtz">
        <form action="{{url('user/resetPassword')}}" method="post"  data-qa="form-login" name="login">
        @csrf
            <p data-qa="title" class="Text-st1i2q-0 styled__Title-sc-1subqgs-0 jTZzYs">{{__('Forgot password?')}} </p>
            <input type="hidden" value="{{url()->previous()}}" name="url" >
            <div class="NGrUbJBA _1Z8A3Tz5 _1FaKA6Nk _3cNt_ILG LoginForm__StyledGrid-sc-1jdwe0j-1 iPBaVu">
                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Email address')}}</label></div>
                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                        <input autocomplete="off" class="RJT7RW5k" required name="email" type="email" placeholder="{{ __('Enter registered email') }}">
                    </div>
                    @error('email')
                        <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                    @endif                    
                    @if(Session::has('success_msg'))                            
                    <div class="text-success mt-3" data-qa="email-status-message"><strong>{{Session::get('success_msg')}}</strong></div>
                    @endif
                    @if(Session::has('error_msg'))                            
                        <div class="_2OcwfRx4 text-danger mt-3" data-qa="email-status-message"><strong>{{Session::get('error_msg')}}</strong></div>
                    @endif
                </div>
              
            </div>
        
            <div class="Flex-nqja63-0 styled__ButtonWrapper-sc-1vy69nr-0 lhtHXX">
                <button type="submit" data-qa="login-button" class="styled__ButtonWrapper-sc-56doij-3 hnulbU">
                   {{__('Reset password')}}
                </button>
            </div>
            <div class="styled__Container-sc-1hvy7mz-0 gszpcs text-center">
              
                <a class="_3Li0AqmO" href="{{url('user/login')}}">{{__('Back to login')}}</a>
            </div>
        </form>
    </div>
   


@endsection