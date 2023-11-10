@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Casual</h1>
            {{ Breadcrumbs::render('casuals/edit') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.casuals.update', $casual) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="first_name">First Name</label> <span class="text-danger">*</span>
                                        <input id="first_name" type="text" name="first_name"
                                            class="form-control {{ $errors->has('first_name') ? ' is-invalid ' : '' }}"
                                            value="{{ $casual->first_name }}">
                                        @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="last_name">Last Name</label> <span class="text-danger">*</span>
                                        <input id="last_name" type="text" name="last_name"
                                            class="form-control {{ $errors->has('last_name') ? ' is-invalid ' : '' }}"
                                            value="{{ $casual->last_name }}">
                                        @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>Phone</label> <span class="text-danger">*</span>
                                        <input type="text" name="phone"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $casual->phone }}">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>Id Number</label> <span class="text-danger">*</span>
                                        <input type="text" name="official_identification_number"
                                            class="form-control @error('official_identification_number') is-invalid @enderror"
                                            value="{{ $casual->official_identification_number }}">
                                        @error('official_identification_number ')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="designation">Designation</label> <span class="text-danger">*</span>
                                        <input id="designation" type="text" name="designation"
                                            class="form-control @error('designation') is-invalid @enderror"
                                            value="{{ $casual->designation }}">
                                        @error('designation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    {{ $casual->status == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="about">About</label>
                                        <textarea name="about"
                                            class="summernote-simple form-control height-textarea @error('about')
                                                      is-invalid @enderror"
                                            id="about">
                                    {{ old('about', $casual->about) }}
                                    </textarea>
                                        @error('about')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer ">
                                <button class="btn btn-primary mr-1" type="submit">Update Casual</button>
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
@endsection
