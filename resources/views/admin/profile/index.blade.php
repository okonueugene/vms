@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/lib/inttelinput/css/intlTelInput.css') }}">
@endsection

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('profile.profile') }}</h1>
            {{ Breadcrumbs::render('profile') }}
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ $user->images }}" class="rounded-circle profile-picture">
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">
                                {{ $user->name }}
                                <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div>
                                    {{ $user->email }}
                                </div>
                            </div>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('profile.username') }}</dt>
                                <dd class="col-sm-8">{{ $user->username }}</dd>
                                <dt class="col-sm-3">{{ __('profile.phone') }}</dt>
                                <dd class="col-sm-9">{{ $user->country_code }}{{ $user->phone }}</dd>
                                <dt class="col-sm-3">{{ __('profile.address') }}</dt>
                                <dd class="col-sm-9">
                                    <p>{{ $user->address }}</p>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card">
                        <form method="post" action="{{ route('admin.profile.change') }}">
                            @csrf
                            @method('put')
                            <div class="card-header">
                                <h4>{{ __('profile.change_password') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label for="old_password">{{ __('profile.old_password') }}</label> <span
                                            class="text-danger">*</span>
                                        <input id="old_password" name="old_password" type="password"
                                            class="form-control @error('old_password') is-invalid @enderror">
                                        @error('old_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label for="password">{{ __('profile.password') }}</label> <span
                                            class="text-danger">*</span>
                                        <input id="password" name="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" />
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label
                                            for="password_confirmation">{{ __('profile.password_confirmation') }}</label>
                                        <span class="text-danger">*</span>
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror" />
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary">{{ __('profile.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <form action="{{ route('admin.profile.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>{{ __('profile.first_name') }}</label> <span class="text-danger">*</span>
                                        <input type="text" name="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name', $user->first_name) }}">
                                        @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('profile.last_name') }}</label> <span class="text-danger">*</span>
                                        <input type="text" name="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name', $user->last_name) }}">
                                        @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>{{ __('profile.email') }}</label> <span class="text-danger">*</span>
                                        <input type="text" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('profile.phone') }}</label>
                                        <input type="text" name="phone" id="number"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone) }}">
                                            
                                        <input type="hidden" id="code" name="country_code"
                                            value="{{ old('code', $user->country_code) }}">
                                        <input type="hidden" id="code_name" name="country_code_name"
                                            value="{{ old('code_name', $user->country_code_name) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>{{ __('profile.username') }}</label>
                                        <input type="text" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username', $user->username) }}">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="customFile">{{ __('profile.image') }}</label>
                                        <div class="custom-file">
                                            <input name="image" type="file"
                                                class="custom-file-input @error('image') is-invalid @enderror"
                                                id="customFile" onchange="readURL(this);">
                                            <label class="custom-file-label"
                                                for="customFile">{{ __('profile.choose_file') }}</label>
                                        </div>
                                        @if ($errors->has('image'))
                                            <div class="help-block text-danger">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                        <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                            src="{{ $user->images }}"
                                            alt="{{ $user->name }} {{ __('profile.profile_image') }}" />
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('profile.address') }}</label>
                                        <textarea name="address" class="form-control small-textarea-height" id="address" cols="30" rows="10">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('profile.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile/index.js') }}"></script>
    <script>
        localStorage.setItem('country_code_name', '{{ $user->country_code_name }}');
    </script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/intlTelInput.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/utils.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/data.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/init.js') }}"></script>
@endsection
