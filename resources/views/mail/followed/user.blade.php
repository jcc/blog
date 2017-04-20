@component('mail::message')
**{{ lang('Dear') }} {{ $username }}：**

{{ $message }}

<a href="{{ $url }}" target="_blank">{{ lang('View') }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
