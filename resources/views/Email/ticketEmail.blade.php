@component('mail::message')
{{ $data['title'] }}

{{ $data['description'] }}

@component('mail::button', ['url' => $data['url']])
{{ $data['button'] }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}

<b>Note</b><br>
You can not respond direct to this email, please login to www.euronetsupport.com using your username and password and reply on the open ticket.
@endcomponent
