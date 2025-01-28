@component('mail::message')
Dear GoSeva Admin,

{!! $message !!}

Sincerely,<br>
The {{ config('app.name') }} Team
@endcomponent

