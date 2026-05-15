<p>Dear {{ $booking->customer_name ?? 'Customer' }},</p>

<p>We\'re glad to inform you that your appointment for {{ $booking->service_names }} on {{ get_formatted_date($booking->booking_date, 'M d, Y') }} at {{ $booking->time_slots }} is confirmed!</p>

<p>NOTE: If this is your first time visiting our clinic for an RMT appointment, you are required to prefill and submit the mandatory <a href="{{ $medical_frm_lnk }}" target="_blank">Patient Intake & Health Form</a></p>

<p>Should you need to change or cancel your appointment for any reason, please email us at <a href="mailto:info@divinetouchtherapy.com">info@divinetouchtherapy.com</a>. Please note that missed appointments or last-minute cancellations are subject to charges as per our stated 24-hour cancelation policy.</p>

<p>We look forward to seeing you soon.</p>

<p>Kind regards,</p>
<p>Divine Touch Therapy</p>