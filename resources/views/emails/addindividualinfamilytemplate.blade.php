<x-mail::message>
# Dear Admin/Team,

I am writing to formally request the addition of an individual to my account/family membership records.
Below are my details and the details of the individual I wish to add:

## My Details (Requestor)
* **First Name:** {{ucwords($final_data['parent_first_name'])}}

* **Last Name:** {{ucwords($final_data['parent_last_name'])}}

* **Email:** {{$final_data['parent_email']}}

* **Mobile:** {{$final_data['parent_mobile']}}


## Individual to be Added
* **First Name:** {{ucwords($final_data['indi_first_name'])}}

* **Last Name:** {{ucwords($final_data['indi_last_name'])}}

* **Email:** {{$final_data['indi_email']}}

* **Mobile:** {{$final_data['indi_mobile']}}


---

Please let me know if any further documentation or information is required from my end to process this request.

Thank you for your time and assistance.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
