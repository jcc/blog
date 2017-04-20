@component('mail::message')
**{{ lang('Dear') }} {{ $username }}：**

{{ $message }}

{{ $content }}

@component('mail::button', ['url' => $url])
{{ lang('View') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
