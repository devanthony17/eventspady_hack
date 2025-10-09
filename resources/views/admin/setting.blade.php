@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
        'title' => __('Setting'),
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Admin Setting') }}</h2>
                </div>
                <div class="col-lg-4 text-right">
                </div>
            </div>

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
                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('General') }}</h4>
                            <p>{{ __('General settings such as, site title, site description, logo and so on.') }}</p>
                            <a href="#general-setting" aria-controls="general-setting" role="button" data-toggle="collapse"
                                class="card-cta" aria-expanded="false">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i>
                            </a>
                            <div class="collapse mt-3" id="general-setting">
                                <form method="post" action="{{ url('save-general-setting') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('App Name') }}</label>
                                        <div class="col-sm-12 col-md-9">
                                            <input type="text" required name="app_name" placeholder="{{ __('Name') }}"
                                                value="{{ $setting->app_name }}"
                                                class="form-control @error('app_name')? is-invalid @enderror">
                                            @error('app_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label
                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Email') }}</label>
                                            <div class="col-sm-12 col-md-9">
                                                <input type="email" name="email" placeholder="{{ __('Email') }}"
                                                    value="{{ $setting->email }}"
                                                    class="form-control @error('email')? is-invalid @enderror">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mb-4">
                                                <label
                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Logo') }}</label>
                                                <div class="col-sm-12 col-md-9">
                                                    <div id="image-preview" class="image-preview setting-logo-preview"
                                                        style="background-image: url({{ url('images/upload/' . $setting->logo) }})">
                                                        <label for="image-upload" id="image-label"> <i
                                                                class="fas fa-plus"></i></label>
                                                        <input type="file" name="logo" id="image-upload" />
                                                    </div>
                                                    @error('logo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label
                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('favicon') }}</label>
                                                    <div class="col-sm-12 col-md-9">
                                                        <div id="image-preview" class="image-preview setting-favicon-preview"
                                                            style="background-image: url({{ url('images/upload/' . $setting->favicon) }})">
                                                            <label for="image-upload" id="image-label"> <i
                                                                    class="fas fa-plus"></i></label>
                                                            <input type="file" name="favicon" id="image-upload" />
                                                        </div>
                                                        @error('favicon')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-4">
                                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                        <div class="col-sm-12 col-md-7">
                                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-user-secret"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4>{{ __('Organizer Setting') }}</h4>
                                            <p>{{ __('organizer app settings such as, organizer privacy policy and terms of use.') }}</p>
                                            <a href="#organization-setting" aria-controls="organization-setting" role="button"
                                                data-toggle="collapse" class="card-cta"
                                                aria-expanded="false">{{ __('Change Setting') }} <i class="fas fa-chevron-right"></i></a>
                                            <div class="collapse mt-3" id="organization-setting">
                                                <form method="post" class="event-form"
                                                    action="{{ url('save-organization-setting') }}">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label class="col-form-label ">{{ __('Commission Type') }}</label>
                                                        <select required name="org_commission_type" class="form-control select2">
                                                            <option value="">{{ __('Select Commission Type') }}</option>
                                                            <option value="amount"
                                                                {{ $setting->org_commission_type == 'amount' ? 'selected' : '' }}>
                                                                {{ __('Amount') }}
                                                            </option>
                                                            <option value="percentage"
                                                                {{ $setting->org_commission_type == 'percentage' ? 'selected' : '' }}>
                                                                {{ __('Percentage') }}</option>
                                                        </select>
                                                        @error('org_commission_type')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">{{ __('Organizer Commission') }}</label>
                                                            <input type="number" name="org_commission" placeholder="{{ __('Organizer Commission') }}"
                                                                value="{{ $setting->org_commission }}"
                                                                class="form-control @error('org_commission')? is-invalid @enderror">
                                                            @error('org_commission')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ __('Privacy Policy') }}</label>
                                                                <textarea name="privacy_policy_organizer" Placeholder="{{ __('Privacy policy') }}"
                                                                    class="textarea_editor @error('privacy_policy_organizer')? is-invalid @enderror">
                                                                                                {{ $setting->privacy_policy_organizer }}
                                                                                            </textarea>
                                                                @error('privacy_policy_organizer')
                                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{ __('Terms of use') }}</label>
                                                                    <textarea name="terms_use_organizer" Placeholder="{{ __('Terms of use') }}"
                                                                        class="textarea_editor @error('terms_use_organizer')? is-invalid @enderror">
                                                                                                        {{ $setting->terms_use_organizer }}
                                                                                                    </textarea>
                                                                    @error('terms_use_organizer')
                                                                        <div class="invalid-feedback block">{{ $message }}</div>
                                                                        @endif
                                                                    </div>


                                                                    <div class="form-group">

                                                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card card-large-icons">
                                                        <div class="card-icon bg-primary text-white">
                                                            <i class="fas fa-user-check"></i>
                                                        </div>
                                                        <div class="card-body">
                                                            <h4>{{ __('Verification') }}</h4>
                                                            <p>{{ __('User Verification settings such as, enable verification and verify user by email or phone.') }}
                                                            </p>
                                                            <a href="#verification-setting" aria-controls="verification-setting" role="button"
                                                                data-toggle="collapse" class="card-cta"
                                                                aria-expanded="false">{{ __('Change Setting') }} <i class="fas fa-chevron-right"></i></a>
                                                            <div class="collapse mt-3" id="verification-setting">
                                                                <form method="post" action="{{ url('save-verification-setting') }}">
                                                                    @csrf
                                                                    <div class="form-group row mb-4">
                                                                        <label
                                                                            class="col-form-label text-md-right col-12 col-md-4">{{ __('Enable User Verification') }}</label>
                                                                        <div class="col-sm-12 col-md-8">
                                                                            <div class="custom-switches-stacked mt-2">
                                                                                <label class="custom-switch pl-0">
                                                                                    <input type="checkbox" name="user_verify"
                                                                                        {{ $setting->user_verify == '1' ? 'checked' : '' }} value="1"
                                                                                        class="custom-switch-input">
                                                                                    <span class="custom-switch-indicator"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-4">
                                                                        <label
                                                                            class="col-form-label text-md-right col-12 col-md-4">{{ __('Verify by Email') }}</label>
                                                                        <div class="col-sm-12 col-md-8">
                                                                            <div class="custom-switches-stacked mt-2">
                                                                                <label class="custom-switch pl-0">
                                                                                    <input type="radio" name="verify_by"
                                                                                        {{ $setting->verify_by == 'email' ? 'checked' : '' }}
                                                                                        value="email" class="custom-switch-input">
                                                                                    <span class="custom-switch-indicator"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-4">
                                                                        <label
                                                                            class="col-form-label text-md-right col-12 col-md-4">{{ __('Verify by Phone') }}</label>
                                                                        <div class="col-sm-12 col-md-8">
                                                                            <div class="custom-switches-stacked mt-2">
                                                                                <label class="custom-switch pl-0">
                                                                                    <input type="radio" name="verify_by"
                                                                                        {{ $setting->verify_by == 'phone' ? 'checked' : '' }}
                                                                                        value="phone" class="custom-switch-input">
                                                                                    <span class="custom-switch-indicator"></span>
                                                                                </label>
                                                                            </div>
                                                                            @error('verify_by')
                                                                                <div class="invalid-feedback block">{{ $message }}</div>
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                                            <div class="col-sm-12 col-md-7">
                                                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="card card-large-icons">
                                                            <div class="card-icon bg-primary text-white">
                                                                <i class="fas fa-hand-holding-usd"></i>
                                                            </div>
                                                            <div class="card-body">
                                                                <h4>{{ __('Payment Setting') }}</h4>
                                                                <p>{{ __('Payment settings include different payment gateway and which will display on app.') }}
                                                                </p>
                                                                <a href="#payment-setting" aria-controls="payment-setting" role="button" data-toggle="collapse"
                                                                    class="card-cta" aria-expanded="false">{{ __('Change Setting') }} <i
                                                                        class="fas fa-chevron-right"></i></a>
                                                                <div class="collapse mt-3" id="payment-setting">
                                                                    <form method="post" action="{{ url('save-payment-setting') }}">
                                                                        @csrf
                                                                        <div class="form-group row mb-4">
                                                                            <label
                                                                                class="col-form-label text-md-right col-12 col-md-3">{{ __('Cash on Delivery') }}</label>
                                                                            <div class="col-sm-12 col-md-9">
                                                                                <div class="custom-switches-stacked mt-2">
                                                                                    <label class="custom-switch pl-0">
                                                                                        <input type="checkbox" name="cod"
                                                                                            {{ $payment->cod == '1' ? 'checked' : '' }} value="1"
                                                                                            class="custom-switch-input">
                                                                                        <span class="custom-switch-indicator"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label
                                                                                class="col-form-label text-md-right col-12 col-md-3">{{ __('Stripe') }}</label>
                                                                            <div class="col-sm-12 col-md-9">
                                                                                <div class="custom-switches-stacked mt-2">
                                                                                    <label class="custom-switch pl-0">
                                                                                        <input type="checkbox" name="stripe"
                                                                                            {{ $payment->stripe == '1' ? 'checked' : '' }} value="1"
                                                                                            class="custom-switch-input">
                                                                                        <span class="custom-switch-indicator"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label
                                                                                class="col-form-label text-md-right col-12 col-md-3">{{ __('Paypal') }}</label>
                                                                            <div class="col-sm-12 col-md-9">
                                                                                <div class="custom-switches-stacked mt-2">
                                                                                    <label class="custom-switch pl-0">
                                                                                        <input type="checkbox" name="paypal"
                                                                                            {{ $payment->paypal == '1' ? 'checked' : '' }} value="1"
                                                                                            class="custom-switch-input">
                                                                                        <span class="custom-switch-indicator"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label
                                                                                class="col-form-label text-md-right col-12 col-md-3">{{ __('Flutterwave') }}</label>
                                                                            <div class="col-sm-12 col-md-9">
                                                                                <div class="custom-switches-stacked mt-2">
                                                                                    <label class="custom-switch pl-0">
                                                                                        <input type="checkbox" name="flutterwave"
                                                                                            {{ $payment->flutterwave == '1' ? 'checked' : '' }} value="1"
                                                                                            class="custom-switch-input">
                                                                                        <span class="custom-switch-indicator"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label
                                                                                class="col-form-label text-md-right col-12 col-md-3">{{ __('Razorpay') }}</label>
                                                                            <div class="col-sm-12 col-md-9">
                                                                                <div class="custom-switches-stacked mt-2">
                                                                                    <label class="custom-switch pl-0">
                                                                                        <input type="checkbox" name="razor"
                                                                                            {{ $payment->razor == '1' ? 'checked' : '' }} value="1"
                                                                                            class="custom-switch-input">
                                                                                        <span class="custom-switch-indicator"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label
                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Stripe secret key') }}</label>
                                                                            <div class="col-sm-12 col-md-9">
                                                                                <input type="text" name="stripeSecretKey" placeholder="{{ __('Stripe secret key') }}"
                                                                                    value="{{ $payment->stripeSecretKey }}"
                                                                                    class="form-control @error('stripeSecretKey')? is-invalid @enderror">
                                                                                @error('stripeSecretKey')
                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label
                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Stripe public key') }}</label>
                                                                                <div class="col-sm-12 col-md-9">
                                                                                    <input type="text" name="stripePublicKey" placeholder="{{ __('Stripe public key') }}"
                                                                                        value="{{ $payment->stripePublicKey }}"
                                                                                        class="form-control @error('stripePublicKey')? is-invalid @enderror">
                                                                                    @error('stripePublicKey')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row mb-4">
                                                                                    <label
                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Paypal Client ID') }}</label>
                                                                                    <div class="col-sm-12 col-md-9">
                                                                                        <input type="text" name="paypalClientId" placeholder="{{ __('Paypal Client ID') }}"
                                                                                            value="{{ $payment->paypalClientId }}"
                                                                                            class="form-control @error('paypalClientId')? is-invalid @enderror">
                                                                                        @error('paypalClientId')
                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row mb-4">
                                                                                        <label
                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Paypal Secret key') }}</label>
                                                                                        <div class="col-sm-12 col-md-9">
                                                                                            <input type="text" name="paypalSecret" placeholder="{{ __('Paypal Secret key') }}"
                                                                                                value="{{ $payment->paypalSecret }}"
                                                                                                class="form-control @error('paypalSecret')? is-invalid @enderror">
                                                                                            @error('paypalSecret')
                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row mb-4">
                                                                                            <label
                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Razorpay Publish key') }}</label>
                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                <input type="text" name="razorPublishKey" placeholder="{{ __('Razorpay Publish key') }}"
                                                                                                    value="{{ $payment->razorPublishKey }}"
                                                                                                    class="form-control @error('razorPublishKey')? is-invalid @enderror">
                                                                                                @error('razorPublishKey')
                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group row mb-4">
                                                                                                <label
                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Razorpay Secret key') }}</label>
                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                    <input type="text" name="razorSecretKey" placeholder="{{ __('Razorpay Secret key') }}"
                                                                                                        value="{{ $payment->razorSecretKey }}"
                                                                                                        class="form-control @error('razorSecretKey')? is-invalid @enderror">
                                                                                                    @error('razorSecretKey')
                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row mb-4">
                                                                                                    <label
                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Flutterwave public key') }}</label>
                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                        <input type="text" name="ravePublicKey" placeholder="{{ __('Flutterwave public key') }}"
                                                                                                            value="{{ $payment->ravePublicKey }}"
                                                                                                            class="form-control @error('ravePublicKey')? is-invalid @enderror">
                                                                                                        @error('ravePublicKey')
                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group row mb-4">
                                                                                                        <label
                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Flutterwave secret key') }}</label>
                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                            <input type="text" name="raveSecretKey" placeholder="{{ __('Flutterwave secret key') }}"
                                                                                                                value="{{ $payment->raveSecretKey }}"
                                                                                                                class="form-control @error('raveSecretKey')? is-invalid @enderror">
                                                                                                            @error('raveSecretKey')
                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group row mb-4">
                                                                                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                                                                            <div class="col-sm-12 col-md-7">
                                                                                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <div class="card card-large-icons">
                                                                                            <div class="card-icon bg-primary text-white">
                                                                                                <i class="fas fa-envelope"></i>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <h4>{{ __('Mail Notification') }}</h4>
                                                                                                <p>{{ __('Email SMTP configuration settings and email notifications related to email.') }}
                                                                                                </p>
                                                                                                <a href="#mail-setting" aria-controls="mail-setting" role="button" data-toggle="collapse"
                                                                                                    class="card-cta" aria-expanded="false">{{ __('Change Setting') }} <i
                                                                                                        class="fas fa-chevron-right"></i></a>
                                                                                                <div class="collapse mt-3" id="mail-setting">
                                                                                                    <form method="post" action="{{ url('save-mail-setting') }}">
                                                                                                        @csrf
                                                                                                        <div class="form-group row mb-4">
                                                                                                            <label
                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Enable Notification') }}</label>
                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                <div class="custom-switches-stacked mt-2">
                                                                                                                    <label class="custom-switch pl-0">
                                                                                                                        <input type="checkbox" name="mail_notification"
                                                                                                                            {{ $setting->mail_notification == '1' ? 'checked' : '' }}
                                                                                                                            value="1" class="custom-switch-input">
                                                                                                                        <span class="custom-switch-indicator"></span>
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group row mb-4">
                                                                                                            <label
                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mail Host') }}</label>
                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                <input type="text" name="mail_host" placeholder="{{ __('Mail Host') }}"
                                                                                                                    value="{{ $setting->mail_host }}"
                                                                                                                    class="form-control @error('mail_host')? is-invalid @enderror">
                                                                                                                @error('mail_host')
                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group row mb-4">
                                                                                                                <label
                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mail Port') }}</label>
                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                    <input type="number" name="mail_port" placeholder="{{ __('Mail Port') }}"
                                                                                                                        value="{{ $setting->mail_port }}"
                                                                                                                        class="form-control @error('mail_port')? is-invalid @enderror">
                                                                                                                    @error('mail_port')
                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                        @endif
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="form-group row mb-4">
                                                                                                                    <label
                                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mail Username') }}</label>
                                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                                        <input type="email" name="mail_username" placeholder="{{ __('Mail Username') }}"
                                                                                                                            value="{{ $setting->mail_username }}"
                                                                                                                            class="form-control @error('mail_username')? is-invalid @enderror">
                                                                                                                        @error('mail_username')
                                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                            @endif
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group row mb-4">
                                                                                                                        <label
                                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mail Password') }}</label>
                                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                                            <input type="password" name="mail_password" placeholder="{{ __('Mail Password') }}"
                                                                                                                                value="{{ $setting->mail_password }}"
                                                                                                                                class="form-control @error('mail_password')? is-invalid @enderror">
                                                                                                                            @error('mail_password')
                                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                @endif
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="form-group row mb-4">
                                                                                                                            <label
                                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Mail Sender Email') }}</label>
                                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                                <input type="email" name="sender_email" placeholder="{{ __('Mail Sender Email') }}"
                                                                                                                                    value="{{ $setting->sender_email }}"
                                                                                                                                    class="form-control @error('sender_email')? is-invalid @enderror">
                                                                                                                                @error('sender_email')
                                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                    @endif
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                                                                                                <div class="col-sm-12 col-md-7">
                                                                                                                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </form>
                                                                                                                    </div>

                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-lg-6">
                                                                                                            <div class="card card-large-icons">
                                                                                                                <div class="card-icon bg-primary text-white">
                                                                                                                    <i class="fas fa-bell"></i>
                                                                                                                </div>
                                                                                                                <div class="card-body">
                                                                                                                    <h4>{{ __('Push Notification') }}</h4>
                                                                                                                    <p>{{ __('OneSignal configuration settings and app push notifications setting.') }}</p>
                                                                                                                    <a href="#push-notification-setting" aria-controls="push-notification-setting" role="button"
                                                                                                                        data-toggle="collapse" class="card-cta"
                                                                                                                        aria-expanded="false">{{ __('Change Setting') }} <i
                                                                                                                            class="fas fa-chevron-right"></i></a>
                                                                                                                    <div class="collapse mt-3" id="push-notification-setting">
                                                                                                                        <form method="post" action="{{ url('save-pushNotification-setting') }}">
                                                                                                                            @csrf
                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                <label
                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Enable Notification') }}</label>
                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                    <div class="custom-switches-stacked mt-2">
                                                                                                                                        <label class="custom-switch pl-0">
                                                                                                                                            <input type="checkbox" name="push_notification"
                                                                                                                                                {{ $setting->push_notification == '1' ? 'checked' : '' }}
                                                                                                                                                value="1" class="custom-switch-input">
                                                                                                                                            <span class="custom-switch-indicator"></span>
                                                                                                                                        </label>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <p>{{ __('OneSignal configuration for user app:') }}</p>
                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                <label
                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal App Id') }}</label>
                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                    <input type="text" name="onesignal_app_id" placeholder="{{ __('OneSignal App Id') }}"
                                                                                                                                        value="{{ $setting->onesignal_app_id }}"
                                                                                                                                        class="form-control @error('onesignal_app_id')? is-invalid @enderror">
                                                                                                                                    @error('onesignal_app_id')
                                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                        @endif
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="form-group row mb-4">
                                                                                                                                    <label
                                                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal Project Number') }}</label>
                                                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                                                        <input type="text" name="onesignal_project_number"
                                                                                                                                            placeholder="{{ __('Onesignal Project Number') }}"
                                                                                                                                            value="{{ $setting->onesignal_project_number }}"
                                                                                                                                            class="form-control @error('onesignal_project_number')? is-invalid @enderror">
                                                                                                                                        @error('onesignal_project_number')
                                                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                            @endif
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="form-group row mb-4">
                                                                                                                                        <label
                                                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal Api key') }}</label>
                                                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                                                            <input type="text" name="onesignal_api_key" placeholder="{{ __('Onesignal Api key') }}"
                                                                                                                                                value="{{ $setting->onesignal_api_key }}"
                                                                                                                                                class="form-control @error('onesignal_api_key')? is-invalid @enderror">
                                                                                                                                            @error('onesignal_api_key')
                                                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                @endif
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="form-group row mb-4">
                                                                                                                                            <label
                                                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal Auth Key') }}</label>
                                                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                                                <input type="text" name="onesignal_auth_key" placeholder="{{ __('Onesignal Auth Key') }}"
                                                                                                                                                    value="{{ $setting->onesignal_auth_key }}"
                                                                                                                                                    class="form-control @error('onesignal_auth_key')? is-invalid @enderror">
                                                                                                                                                @error('onesignal_auth_key')
                                                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                    @endif
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <p>{{ __('OneSignal configuration for organizer app:') }}</p>
                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                <label
                                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal App Id') }}</label>
                                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                                    <input type="text" name="or_onesignal_app_id" placeholder="{{ __('OneSignal App Id') }}"
                                                                                                                                                        value="{{ $setting->or_onesignal_app_id }}"
                                                                                                                                                        class="form-control @error('or_onesignal_app_id')? is-invalid @enderror">
                                                                                                                                                    @error('or_onesignal_app_id')
                                                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                        @endif
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="form-group row mb-4">
                                                                                                                                                    <label
                                                                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal Project Number') }}</label>
                                                                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                                                                        <input type="text" name="or_onesignal_project_number"
                                                                                                                                                            placeholder="{{ __('Onesignal Project Number') }}"
                                                                                                                                                            value="{{ $setting->or_onesignal_project_number }}"
                                                                                                                                                            class="form-control @error('or_onesignal_project_number')? is-invalid @enderror">
                                                                                                                                                        @error('or_onesignal_project_number')
                                                                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                            @endif
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="form-group row mb-4">
                                                                                                                                                        <label
                                                                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal Api key') }}</label>
                                                                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                                                                            <input type="text" name="or_onesignal_api_key" placeholder="{{ __('Onesignal Api key') }}"
                                                                                                                                                                value="{{ $setting->or_onesignal_api_key }}"
                                                                                                                                                                class="form-control @error('or_onesignal_api_key')? is-invalid @enderror">
                                                                                                                                                            @error('or_onesignal_api_key')
                                                                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                @endif
                                                                                                                                                            </div>
                                                                                                                                                        </div>

                                                                                                                                                        <div class="form-group row mb-4">
                                                                                                                                                            <label
                                                                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Onesignal Auth Key') }}</label>
                                                                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                                                                <input type="text" name="or_onesignal_auth_key" placeholder="{{ __('Onesignal Auth Key') }}"
                                                                                                                                                                    value="{{ $setting->or_onesignal_auth_key }}"
                                                                                                                                                                    class="form-control @error('or_onesignal_auth_key')? is-invalid @enderror">
                                                                                                                                                                @error('or_onesignal_auth_key')
                                                                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                    @endif
                                                                                                                                                                </div>
                                                                                                                                                            </div>

                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                                                                                                                                <div class="col-sm-12 col-md-7">
                                                                                                                                                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </form>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="col-lg-6">
                                                                                                                                            <div class="card card-large-icons">
                                                                                                                                                <div class="card-icon bg-primary text-white">
                                                                                                                                                    <i class="fas fa-sms"></i>
                                                                                                                                                </div>
                                                                                                                                                <div class="card-body">
                                                                                                                                                    <h4>{{ __('SMS Notification') }}</h4>
                                                                                                                                                    <p>{{ __('SMS configuration settings of twillio SMS gateway.') }}</p>
                                                                                                                                                    <a href="#push-sms-setting" aria-controls="push-sms-setting" role="button"
                                                                                                                                                        data-toggle="collapse" class="card-cta"
                                                                                                                                                        aria-expanded="false">{{ __('Change Setting') }} <i
                                                                                                                                                            class="fas fa-chevron-right"></i></a>
                                                                                                                                                    <div class="collapse mt-3" id="push-sms-setting">
                                                                                                                                                        <form method="post" action="{{ url('save-sms-setting') }}">
                                                                                                                                                            @csrf
                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                <label
                                                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Enable SMS Notification') }}</label>
                                                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                                                    <div class="custom-switches-stacked mt-2">
                                                                                                                                                                        <label class="custom-switch pl-0">
                                                                                                                                                                            <input type="checkbox" name="sms_notification"
                                                                                                                                                                                {{ $setting->sms_notification == '1' ? 'checked' : '' }}
                                                                                                                                                                                value="1" class="custom-switch-input">
                                                                                                                                                                            <span class="custom-switch-indicator"></span>
                                                                                                                                                                        </label>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                <label
                                                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Twilio Account ID') }}</label>
                                                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                                                    <input type="text" name="twilio_account_id" placeholder="{{ __('Twilio Account ID') }}"
                                                                                                                                                                        value="{{ $setting->twilio_account_id }}"
                                                                                                                                                                        class="form-control @error('twilio_account_id')? is-invalid @enderror">
                                                                                                                                                                    @error('twilio_account_id')
                                                                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                        @endif
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="form-group row mb-4">
                                                                                                                                                                    <label
                                                                                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Twilio auth token') }}</label>
                                                                                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                                                                                        <input type="text" name="twilio_auth_token" placeholder="{{ __('Twilio auth token') }}"
                                                                                                                                                                            value="{{ $setting->twilio_auth_token }}"
                                                                                                                                                                            class="form-control @error('twilio_auth_token')? is-invalid @enderror">
                                                                                                                                                                        @error('twilio_auth_token')
                                                                                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                            @endif
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="form-group row mb-4">
                                                                                                                                                                        <label
                                                                                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Twilio phone number') }}</label>
                                                                                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                                                                                            <input type="text" name="twilio_phone_number" placeholder="{{ __('Twilio phone number') }}"
                                                                                                                                                                                value="{{ $setting->twilio_phone_number }}"
                                                                                                                                                                                class="form-control @error('twilio_phone_number')? is-invalid @enderror">
                                                                                                                                                                            @error('twilio_phone_number')
                                                                                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                @endif
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="form-group row mb-4">
                                                                                                                                                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                                                                                                                                            <div class="col-sm-12 col-md-7">
                                                                                                                                                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </form>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-lg-6">
                                                                                                                                                        <div class="card card-large-icons">
                                                                                                                                                            <div class="card-icon bg-primary text-white">
                                                                                                                                                                <i class="fas fa-tools"></i>
                                                                                                                                                            </div>
                                                                                                                                                            <div class="card-body">
                                                                                                                                                                <h4>{{ __('Additional Setting') }}</h4>
                                                                                                                                                                <p>{{ __('General setting such as currency, map key, default map coordinates and so on.') }}
                                                                                                                                                                </p>
                                                                                                                                                                <a href="#additional-setting" aria-controls="additional-setting" role="button"
                                                                                                                                                                    data-toggle="collapse" class="card-cta"
                                                                                                                                                                    aria-expanded="false">{{ __('Change Setting') }} <i
                                                                                                                                                                        class="fas fa-chevron-right"></i></a>
                                                                                                                                                                <div class="collapse mt-3" id="additional-setting">
                                                                                                                                                                    <form method="post" action="{{ url('additional-setting') }}">
                                                                                                                                                                        @csrf
                                                                                                                                                                        <div class="form-group row mb-4">
                                                                                                                                                                            <label
                                                                                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Currency') }}</label>
                                                                                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                                                                                <select required name="currency" class="form-control select2">
                                                                                                                                                                                    <option value="">{{ __('Select default currency') }}</option>
                                                                                                                                                                                    @foreach ($currencies as $item)
                                                                                                                                                                                        <option value="{{ $item->code }}"
                                                                                                                                                                                            {{ $setting->currency == $item->code ? 'Selected' : '' }}>
                                                                                                                                                                                            {{ $item->currency . ' ( ' . $item->symbol . '- ' . $item->code . ')' }}
                                                                                                                                                                                        </option>
                                                                                                                                                                                    @endforeach
                                                                                                                                                                                </select>
                                                                                                                                                                                @error('currency')
                                                                                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                    @endif
                                                                                                                                                                                </div>
                                                                                                                                                                            </div>
                                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                                <label
                                                                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('TimeZone') }}</label>
                                                                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                                                                    <select required name="timezone" class="form-control select2">
                                                                                                                                                                                        <option value="">{{ __('Select default Timezone') }}</option>
                                                                                                                                                                                        @foreach ($timezone as $item)
                                                                                                                                                                                            <option value="{{ $item->TimeZone }}"
                                                                                                                                                                                                {{ $setting->timezone == $item->TimeZone ? 'Selected' : '' }}>
                                                                                                                                                                                                {{ $item->TimeZone }}</option>
                                                                                                                                                                                        @endforeach
                                                                                                                                                                                    </select>
                                                                                                                                                                                    @error('timezone')
                                                                                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                        @endif
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                <div class="form-group row mb-4">
                                                                                                                                                                                    <label
                                                                                                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Language') }}</label>
                                                                                                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                                                                                                        <select required name="language" class="form-control select2">
                                                                                                                                                                                            <option value="">{{ __('Select default Language') }}</option>
                                                                                                                                                                                            @foreach ($languages as $language)
                                                                                                                                                                                                <option value="{{ $language->name }}"
                                                                                                                                                                                                    {{ $language->name == $setting->language ? 'Selected' : '' }}>
                                                                                                                                                                                                    {{ $language->name }}</option>
                                                                                                                                                                                            @endforeach
                                                                                                                                                                                        </select>
                                                                                                                                                                                        @error('language')
                                                                                                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                            @endif
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="form-group row mb-4">
                                                                                                                                                                                        <label
                                                                                                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('App Version') }}</label>
                                                                                                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                                                                                                            <input type="text" required name="app_version" placeholder="{{ __('App Version') }}"
                                                                                                                                                                                                value="{{ $setting->app_version }}"
                                                                                                                                                                                                class="form-control @error('app_version')? is-invalid @enderror">
                                                                                                                                                                                            @error('app_version')
                                                                                                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                @endif
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="form-group row mb-4">
                                                                                                                                                                                            <label
                                                                                                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('CopyRight content') }}</label>
                                                                                                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                <input type="text" required name="footer_copyright"
                                                                                                                                                                                                    placeholder="{{ __('Footer CopyRight Content') }}"
                                                                                                                                                                                                    value="{{ $setting->footer_copyright }}"
                                                                                                                                                                                                    class="form-control @error('footer_copyright')? is-invalid @enderror">
                                                                                                                                                                                                @error('footer_copyright')
                                                                                                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                    @endif
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                                                <label
                                                                                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Map key') }}</label>
                                                                                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                    <input type="text" name="map_key" placeholder="{{ __('Map key') }}"
                                                                                                                                                                                                        value="{{ $setting->map_key }}"
                                                                                                                                                                                                        class="form-control @error('map_key')? is-invalid @enderror">
                                                                                                                                                                                                    @error('map_key')
                                                                                                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                        @endif
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                <div class="form-group row mb-4">
                                                                                                                                                                                                    <label
                                                                                                                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Default Latitude') }}</label>
                                                                                                                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                        <input type="text" required name="default_lat" placeholder="{{ __('Default Latitude') }}"
                                                                                                                                                                                                            value="{{ $setting->default_lat }}"
                                                                                                                                                                                                            class="form-control @error('default_lat')? is-invalid @enderror">
                                                                                                                                                                                                        @error('default_lat')
                                                                                                                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                            @endif
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="form-group row mb-4">
                                                                                                                                                                                                        <label
                                                                                                                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Default Longitude') }}</label>
                                                                                                                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                            <input type="text" required name="default_long" placeholder="{{ __('Default Longitude') }}"
                                                                                                                                                                                                                value="{{ $setting->default_long }}"
                                                                                                                                                                                                                class="form-control @error('default_long')? is-invalid @enderror">
                                                                                                                                                                                                            @error('default_long')
                                                                                                                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                                @endif
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <div class="form-group row mb-4">
                                                                                                                                                                                                            <label
                                                                                                                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Primary Color') }}</label>
                                                                                                                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                                <div class="input-group colorpickerinput">
                                                                                                                                                                                                                    <input type="text" name="primary_color"
                                                                                                                                                                                                                        value="{{ $setting->primary_color }}" placeholder="{{ __('Choose color') }}"
                                                                                                                                                                                                                        class="form-control  @error('primary_color')? is-invalid @enderror">
                                                                                                                                                                                                                    <div class="input-group-append">
                                                                                                                                                                                                                        <div class="input-group-text color-input">
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                @error('primary_color')
                                                                                                                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                                    @endif
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                                                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                                                                                                                                                                                <div class="col-sm-12 col-md-7">
                                                                                                                                                                                                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </form>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="col-lg-6">
                                                                                                                                                                                            <div class="card card-large-icons">
                                                                                                                                                                                                <div class="card-icon bg-primary text-white">
                                                                                                                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                <div class="card-body">
                                                                                                                                                                                                    <h4>{{ __('Support Setting') }}</h4>
                                                                                                                                                                                                    <p>{{ __('Support setting include links of pages like Privacy policy, Terms of services, Help center and so on.') }}
                                                                                                                                                                                                    </p>
                                                                                                                                                                                                    <a href="#support-setting" aria-controls="support-setting" role="button" data-toggle="collapse"
                                                                                                                                                                                                        class="card-cta" aria-expanded="false">{{ __('Change Setting') }}<i
                                                                                                                                                                                                            class="fas fa-chevron-right"></i></a>
                                                                                                                                                                                                    <div class="collapse mt-3" id="support-setting">
                                                                                                                                                                                                        <form method="post" action="{{ url('support-setting') }}">
                                                                                                                                                                                                            @csrf
                                                                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                                                                <label
                                                                                                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Help Center') }}</label>
                                                                                                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                                    <input type="url" required name="help_center" placeholder="{{ __('Help Center url') }}"
                                                                                                                                                                                                                        value="{{ $setting->help_center }}"
                                                                                                                                                                                                                        class="form-control @error('help_center')? is-invalid @enderror">
                                                                                                                                                                                                                    @error('help_center')
                                                                                                                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                                        @endif
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                <div class="form-group row mb-4">
                                                                                                                                                                                                                    <label
                                                                                                                                                                                                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Privacy policy') }}</label>
                                                                                                                                                                                                                    <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                                        <input type="url" required name="privacy_policy"
                                                                                                                                                                                                                            placeholder="{{ __('Privacy policy url') }}" value="{{ $setting->privacy_policy }}"
                                                                                                                                                                                                                            class="form-control @error('privacy_policy')? is-invalid @enderror">
                                                                                                                                                                                                                        @error('privacy_policy')
                                                                                                                                                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                                            @endif
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                    <div class="form-group row mb-4">
                                                                                                                                                                                                                        <label
                                                                                                                                                                                                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Cookie policy') }}</label>
                                                                                                                                                                                                                        <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                                            <input type="url" name="cookie_policy" placeholder="{{ __('Cookie policy url') }}"
                                                                                                                                                                                                                                value="{{ $setting->cookie_policy }}"
                                                                                                                                                                                                                                class="form-control @error('cookie_policy')? is-invalid @enderror">
                                                                                                                                                                                                                            @error('cookie_policy')
                                                                                                                                                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                                                @endif
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                        <div class="form-group row mb-4">
                                                                                                                                                                                                                            <label
                                                                                                                                                                                                                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Cookie policy') }}</label>
                                                                                                                                                                                                                            <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                                                <input type="url" name="terms_services" placeholder="{{ __('Cookie policy url') }}"
                                                                                                                                                                                                                                    value="{{ $setting->terms_services }}"
                                                                                                                                                                                                                                    class="form-control @error('terms_services')? is-invalid @enderror">
                                                                                                                                                                                                                                @error('terms_services')
                                                                                                                                                                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                                                    @endif
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                            <div class="form-group row mb-4">
                                                                                                                                                                                                                                <label
                                                                                                                                                                                                                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Acknowledgement') }}</label>
                                                                                                                                                                                                                                <div class="col-sm-12 col-md-9">
                                                                                                                                                                                                                                    <input type="url" name="acknowledgement" placeholder="{{ __('Acknowledgement page url') }}"
                                                                                                                                                                                                                                        value="{{ $setting->acknowledgement }}"
                                                                                                                                                                                                                                        class="form-control @error('acknowledgement')? is-invalid @enderror">
                                                                                                                                                                                                                                    @error('acknowledgement')
                                                                                                                                                                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                                                                                                                                                                        @endif
                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                <div class="form-group row mb-4">
                                                                                                                                                                                                                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                                                                                                                                                                                                                    <div class="col-sm-12 col-md-7">
                                                                                                                                                                                                                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </form>
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </section>
                                                                                                                                                                                            @endsection
