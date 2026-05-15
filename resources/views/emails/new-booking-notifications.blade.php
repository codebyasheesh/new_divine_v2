<!DOCTYPE html>
<html>
<head>
    <title>New Booking Notification</title>
</head>
<body>
    <h2>New Booking Received</h2>
    <p><strong>Name:</strong> {{ $booking->customer_name }}</p>
    <p><strong>Email:</strong> {{ $booking->customer_email }}</p>
    <p><strong>Mobile:</strong> {{$booking->customer_mobile}}</p>
    <p><strong>Appointment Date:</strong> {{get_formatted_date($booking->booking_date, 'M d, Y')}}</p>
    <p><strong>Appointment Time:</strong> {{$booking->time_slots}}</p>
    <p><strong>Services:</strong> {{ $booking->service_names }}</p>
    <p><strong>Message:</strong> {{$booking->message ?? 'No Message'}}</p>
    <p><strong>Total Amount:</strong> {{'$'.$booking->total_amount}}</p>
</body>
</html>