<footer class="mt-8">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="nav-footer text-right mb-2">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ url('/') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0)">{{ __('Organizations') }}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0)">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0)">{{ __('Contact') }}</a>
                        </li>
                    </ul>
                    <div class="dropdown ml-2 mb-2 langDropdown">
                        <?php $lang = session('locale')==null?"English":session('locale'); ?>
                        @php
                            $languages = \App\Models\Language::where('status',1)->get();
                        @endphp
                        <a class="dropdown-toggle" href="javascript:void(0)" id="langDropdown" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="{{ url('images/upload/' . $lang . '.png') }}" class="flag-img">{{ __($lang) }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="langDropdown">
                            @foreach ($languages as $language)
                                <a class="dropdown-item" href="{{ url('change-language/'.$language->name) }}"><img src="{{ url('images/upload/'.$language->image) }}" class="flag-img">{{ $language->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</footer>
