@component('mail::message')
{{ __('# Hello') }} {{ Str::ucfirst($visitor['name']) }},<br>
@component('mail::panel')
   {{ __(' Your Request to Visit') }} {{ Str::ucfirst($visitor['name']) }}  is {{ trans('visitor_statuses.' . $visitor['status']) }}
@endcomponent
<p>
    {!! setting('notify_templates') !!}
</p>
<br>

<p>Your QrCode Link here:</p><a href="{{ route('qrcode',$visitor['phone'])}}">Click</a>
<img src="{{ asset('qrcode/'.$visitor['barcode']) }}" alt="">
<br>

{{ __('Thank you for using our application! ') }}{{ setting('site_name') }}<br>
<p style="padding: 0; margin:0">{{ __('Regards,') }}</p>
{{ config('app.name') }}
@endcomponent
