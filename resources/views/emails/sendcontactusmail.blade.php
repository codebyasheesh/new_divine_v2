@component('mail::message')
# New Contact Us Enquiry From {{ $data['name'] }},

New Enquiry From {{ $data['name'] }}

@component('mail::panel')
**Name:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
**Mobile:** {{ $data['mobile'] }}
@endcomponent

## Message

{{ $data['message'] }}

@endcomponent