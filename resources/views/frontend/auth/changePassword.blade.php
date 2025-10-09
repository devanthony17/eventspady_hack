@extends('frontend.auth.app')

@section('content')
  
    <div class="Card-sc-8zkhaa-0 styled__StyledCard-mxvrth-1 fogDtz">
        <form action="{{url('change-password')}}" method="post"  data-qa="form-login" name="login">
        @csrf
            <p data-qa="title" class="Text-st1i2q-0 styled__Title-sc-1subqgs-0 jTZzYs">{{__('Change Password')}}</p>            
            <div class="NGrUbJBA _1Z8A3Tz5 _1FaKA6Nk _3cNt_ILG LoginForm__StyledGrid-sc-1jdwe0j-1 iPBaVu">
                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Current Password')}}</label></div>
                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                        <input class="RJT7RW5k" required name="old_password" type="password" placeholder="{{__('Your Current Password')}}">
                    </div>
                    @error('old_password')
                        <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                    @endif
                    @if(Session::has('error_msg'))                            
                        <div class="_2OcwfRx4 text-danger mt-1" data-qa="email-status-message"><strong>{{Session::get('error_msg')}}</strong></div>
                    @endif
                </div>
                <div class="_1RLMtIP3 Qso_pkui mb-4">
                    <div class="_2iCrTJcD"> <label class="_2x_Fz5Ot" data-qa="label-name">{{__('New Password')}}</label> </div>
                    <div class="_2fessCXR p2xx3nlH">
                        <input class="RJT7RW5k" required name="password" type="password" placeholder="{{__('New password')}}">
                    </div>
                    @error('password')
                        <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                    @endif
                </div>
                <div class="_1RLMtIP3 Qso_pkui mb-4">
                    <div class="_2iCrTJcD"> <label class="_2x_Fz5Ot" data-qa="label-name">{{__('Confirm Password')}}</label> </div>
                    <div class="_2fessCXR p2xx3nlH">
                        <input class="RJT7RW5k" required name="password_confirmation" type="password" placeholder="{{__('Confirm password')}}">
                    </div>
                    @error('password_confirmation')
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