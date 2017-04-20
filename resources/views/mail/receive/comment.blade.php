@component('mail::message')
**尊敬的 {{ $username }}：**

{{ $message }}

{{ $content }}

@component('mail::button', ['url' => $url])
查看
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
