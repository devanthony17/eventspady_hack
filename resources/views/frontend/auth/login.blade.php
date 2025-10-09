@extends('frontend.auth.app')

@section('content')
  
    <div class="Card-sc-8zkhaa-0 styled__StyledCard-mxvrth-1 fogDtz">
        <form action="{{url('user/login')}}" method="post"  data-qa="form-login" name="login">
        @csrf
            <p data-qa="title" class="Text-st1i2q-0 styled__Title-sc-1subqgs-0 jTZzYs">{{__('Log in with email')}} </p>
            <input type="hidden" value="{{url()->previous()}}" name="url" >
            <div class="NGrUbJBA _1Z8A3Tz5 _1FaKA6Nk _3cNt_ILG LoginForm__StyledGrid-sc-1jdwe0j-1 iPBaVu">
                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Email address')}}</label></div>
                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                        <input autocomplete="off" class="RJT7RW5k" required name="email" type="email" placeholder="{{ __('Your email address') }}">
                    </div>
                    @error('email')
                        <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                    @endif
                    @if(Session::has('error_msg'))                            
                        <div class="_2OcwfRx4 text-danger mt-1" data-qa="email-status-message"><strong>{{Session::get('error_msg')}}</strong></div>
                    @endif
                </div>
                <div class="_1RLMtIP3 Qso_pkui mb-4">
                    <div class="_2iCrTJcD"> <label class="_2x_Fz5Ot" data-qa="label-name">{{__('Password')}}</label> </div>
                    <div class="_2fessCXR p2xx3nlH">
                        <input autocomplete="off" class="RJT7RW5k" required name="password" type="password" placeholder="{{ __('Your password') }}">
                    </div>
                    @error('password')
                        <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                    @endif
                </div>
            </div>
            <p class="_9t1fKU5Y _2UdNcEai LoginForm__StyledForgotPassword-sc-1jdwe0j-0 egGnFL">
                <a href="{{url('user/resetPassword')}}" data-qa="forgot-password-link" class="_2sZS6sEx XMtNYrVY _37Xq1GQz _2r41poQM k2GDOOsu _2nu1E8dp">
                    <span class="_3Li0AqmO"> {{__('Forgot password')}}? </span>
                </a>
            </p>
            <div class="Flex-nqja63-0 styled__ButtonWrapper-sc-1vy69nr-0 lhtHXX">
                <button type="submit" data-qa="login-button" class="styled__ButtonWrapper-sc-56doij-3 hnulbU">
                    {{__('Log in')}}
                </button>
            </div>
            <div class="styled__Container-sc-1hvy7mz-0 gszpcs text-center">
                <p class="Text-st1i2q-0 styled__Description-sc-1hvy7mz-1 haeOQU"> {{__("Don't have a")}} {{App\Models\Setting::find(1)->app_name}} {{__("account")}}?</p>
                <a class="_3Li0AqmO" href="{{url('user/register')}}">{{__('Sign up now')}}</a>
            </div>
        </form>
    </div>
    <div class="Card-sc-8zkhaa-0 styled__StyledCard-mxvrth-1 fogDtz">
        <p class="Text-st1i2q-0 nWXFK">{{__('Become a partner')}}</p>
        <p class="Text-st1i2q-0 dNmkeH text-center">
            {{__('Create your event with')}} {{\App\Models\Setting::find(1)->app_name}} by <br>
            <a href="{{url('user/org-register')}}" target="_blank" class="Link-sc-2rq62z-0 khXLMG">{{__('signing up as a Organizer')}}</a>
        </p>
    </div>


@endsection