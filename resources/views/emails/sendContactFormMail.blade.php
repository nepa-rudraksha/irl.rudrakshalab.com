@component('mail::message')
# A message has been received form contact page.

Name : {{$maildata['first_name']}}  {{$maildata['last_name']}}<br />
Email : {{$maildata['email']}} <br />
Phone : {{$maildata['phone_number']}} <br />
Message : {{$maildata['message']}} <br />


Thanks,<br>
{{ config('app.name') }}
@endcomponent
