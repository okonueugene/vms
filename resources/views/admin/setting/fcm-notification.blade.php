@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('fcm_settings') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.fcm-update') }}">
                     @csrf
                     <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('levels.fcm_notification_setting') }}</legend>
                         <div class="row">
                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label for="fcm_secret_key">{{ __('levels.firebase_secret_key') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="fcm_secret_key" id="fcm_secret_key" type="text"
                                         class="form-control @error('fcm_secret_key') is-invalid @enderror"
                                         value="{{ old('fcm_secret_key', setting('fcm_secret_key')) }}">
                                     @error('fcm_secret_key')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fcm_topic">{{ __('levels.fcm_topic') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="fcm_topic" id="fcm_topic" type="text"
                                        class="form-control @error('fcm_topic') is-invalid @enderror"
                                        value="{{ old('fcm_topic', setting('fcm_topic')) }}">
                                    @error('fcm_topic')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                     <div class="row">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <span>{{ __('levels.update_fcm_notification_setting') }}</span>
                            </button>
                        </div>
                     </div>
                 </form>       
            </div>
        </div>   
    </div>
@endsection