<x-mail::message>
# Dear {{$user->name}},

Welcome aboard! We're thrilled to have you join the {{ config('app.name') }}.

To get started, please activate your account by clicking on the link below:

<x-mail::button :url="$activation_link">
Activate Your Account
</x-mail::button>

Once activated, you can log in using the following credentials:

Username: {{$user->email}}<br>
Password: {{$user->mobile}}

For your security, we strongly recommend that you change your password immediately after your first login. You can do this from your Dashboard under Change Password link.

If you have any questions or need assistance, don't hesitate to reach out to our support team at support@divinetouchtherapy.com 

Best regards,

The Team at {{ config('app.name') }}
{{"https://divinetouchtherapy.com"}}

</x-mail::message>