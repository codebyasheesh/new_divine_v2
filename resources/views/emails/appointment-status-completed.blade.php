<x-mail::message>
# Dear {{$booking->customer_name}},

Your Appointment has been completed.


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
