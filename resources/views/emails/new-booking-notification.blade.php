@component('mail::message')
# New Booking Received

**Client:** {{ $booking->customer_name }}  
**Email:** {{ $booking->customer_email }}  
**Mobile:** {{ $booking->customer_mobile }}  
**Appointment Date:** {{get_formatted_date($booking->booking_date, 'M d, Y')}}  
**Appointment Time:** {{$booking->time_slots}}  
**Services:** {{ $booking->service_names }}  

@component('mail::button', ['url' => url('admin/')])
View Booking
@endcomponent

@endcomponent