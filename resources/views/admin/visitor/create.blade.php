@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/inttelinput/css/intlTelInput.css') }}">
@endsection

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('visitor.visitors') }}</h1>
            {{ Breadcrumbs::render('visitors/add') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.visitors.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="first_name">{{ __('visitor.first_name') }}</label> <span class="text-danger">*</span>
                                        <input id="first_name" type="text" name="first_name" class="form-control {{ $errors->has('first_name') ? " is-invalid " : '' }}" value="{{ old('first_name') }}">
                                        @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="last_name">{{ __('visitor.last_name') }}</label> <span class="text-danger">*</span>
                                        <input id="last_name" type="text" name="last_name" class="form-control {{ $errors->has('last_name') ? " is-invalid " : '' }}" value="{{ old('last_name') }}">
                                        @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>{{ __('visitor.email_address') }}</label>
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('visitor.phone') }}</label> <span class="text-danger">*</span><span class="text-info"></span>
                                        <input type="text" name="phone" id="number" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">

                                        <input type="hidden" id="code" name="country_code" value="1">
                                        <input type="hidden" id="code_name" name="country_code_name" value="us">
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="gender">{{ __('visitor.gender') }}</label> <span class="text-danger">*</span>
                                        <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                            @foreach(trans('genders') as $key => $gender)
                                                <option value="{{ $key }}" {{ (old('gender') == $key) ? 'selected' : '' }}>{{ $gender }}</option>
                                            @endforeach
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('visitor.company_name') }}</label>
                                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
                                        @error('company_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>{{ __('visitor.national_identification_no') }}</label><span class="text-danger">*</span>
                                        <input type="text" name="national_identification_no" class="form-control @error('national_identification_no') is-invalid @enderror" value="{{ old('national_identification_no') }}">
                                        @error('national_identification_no')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="employee_id">{{ __('visitor.select_employee') }}</label> <span class="text-danger">*</span>
                                        <select id="employee_id" name="employee_id" class="form-control select2 @error('employee_id') is-invalid @enderror">
                                            @foreach($employees as $key => $employee)
                                                <option value="{{ $employee->id }}" {{ (old('employee_id') == $employee->id) ? 'selected' : '' }}>{{ $employee->name }} ( {{ optional($employee->department)->name }} )</option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="purpose">{{ __('visitor.purpose') }}</label> <span class="text-danger">*</span>
                                        <textarea name="purpose"
                                                  class="summernote-simple form-control height-textarea @error('purpose')
                                                      is-invalid @enderror"
                                                  id="purpose" >
                                            {{ old('purpose') }}
                                        </textarea>
                                        @error('purpose')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="address">{{ __('visitor.address') }}</label>
                                        <textarea name="address"
                                                  class="summernote-simple form-control height-textarea @error('address')
                                                      is-invalid @enderror"
                                                  id="address" >
                                            {{ old('address') }}
                                        </textarea>
                                        @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="customFile">{{ __('visitor.image') }}</label><span class="text-danger"> *</span>
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
                                            <label  class="custom-file-label" for="customFile">{{ __('visitor.choose_file') }}</label>
                                        </div>
                                        @if ($errors->has('image'))
                                            <div class="help-block text-danger">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                        <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/user.png') }}" alt="your image"/>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer ">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/visitor/create.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/intlTelInput.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/utils.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/data.js') }}"></script>
    <script defer src="{{ asset('assets/lib/inttelinput/js/init.js') }}"></script>
@endsection
