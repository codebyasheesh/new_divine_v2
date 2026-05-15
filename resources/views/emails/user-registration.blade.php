<x-mail::message>
# Dear {{$user->name}},

Welcome aboard! We're thrilled to have you join the {{ config('app.name') }}.

To get started, please activate your account by clicking on the link below:

<x-mail::button :url="$activation_link">
Activate Your Account
</x-mail::button>

Once activated, you can login.

If you have any questions or need assistance, don't hesitate to reach out to our support team at support@divinetouchtherapy.com 

Best regards,

The Team at 
{{ config('app.name') }}

{{"https://divinetouchtherapy.com"}}

</x-mail::message>