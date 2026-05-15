<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Submission</title>
    <style>
        body {
            font-family: Times Sans, sans-serif;
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            /* border: 1px solid #000; */
            padding: 10px;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <td style="width: 30%;">
            <img src="{{public_path('admin_assets/assets/img/divine-touch-logo2.png')}}" class="img-fluid" style="width: 150px;" />
        </td>
        <td style="width:30%;">&nbsp;</td>
        <td style="width:40%;">
            <div style="margin-left:15px;">
                <h4>Divine Touch Therapy</h4>
                70 Twistleton St,<br />Caledon, ON L7C 4B5,<br/>
                Phone: +1 905-996-2700<br />
                Email: info@divinetouchtherapy.com
            </div>
        </td>
    </tr>
    <tr style="margin:12px 0 8px 0;">
        <td colspan="3" style="font-size: 18px; text-align:center; text-transform:uppercase;"><strong>Patient Intake Form</strong></td>
    </tr>
</table>    
<table>
    <tr>
        <td colspan="2"><strong>Date:</strong> {{ get_formatted_date($data->choose_date, 'M d, Y') }}</td>
    </tr>
    <tr>
        @php
        $full_name = $data->first_name.' '.$data->middle_name.' '.$data->last_name;
        @endphp
        <td><strong>Name:</strong> {{$data->pronoun}} {{ $full_name }}</td>
        <td><strong>DOB:</strong> {{ get_formatted_date($data->dob, 'M d, Y') }}</td>
    </tr>
    <tr>
        <td><strong>Email:</strong> {{ $data->email }}</td>
        <td><strong>Gender:</strong> {{ $data->gender }}</td>
    </tr>
    <tr>
        <td><strong>Primary Phone:</strong> {{ $data->primary_phone }}</td>
        <td><strong>Other Phone:</strong> {{ $data->other_phone }}</td>
    </tr>
    <tr>
        <td><strong>Address:</strong> {{ $data->address }}</td>
        <td><strong>City:</strong> {{ $data->city }}</td>
    </tr>
    <tr>
        <td><strong>Province:</strong> {{ $data->province }}</td>
        <td><strong>Postal Code:</strong> {{ $data->postal_code }}</td>
    </tr>
    <tr>
        <td><strong>Occupation:</strong> {{ $data->occupation ?? 'N/A' }}</td>
        <td><strong>Emergency Contact Name:</strong> {{ $data->emergency_contact_name ?? ''}}</td>
    </tr>
    <tr>
        <td><strong>Emergency Contact Phone:</strong> {{ $data->emergency_contact_phone ?? ''}}</td>
        <td><strong>Special Accessibility/ Mobility Requirements: </strong> {{ $data->special_accessbility_mobility ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Source of Referral:</strong> {{ $data->source_of_referral ?? ''}}</td>
        <td><strong>Extended Health Care Benefit: </strong>{{ $data->extended_health_care_benefit ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Benefits Insurance Company:</strong> {{ $data->benefits_insurance_company_name }}</td>
        <td><strong>Primary Member: </strong>{{ $data->primary_member }}</td>
    </tr>
    <tr>
        <td><strong>Primary Member Name: </strong>{{ $data->primary_member_name ?? 'N/A' }}</td>
        <td><strong>Primary Member DOB: </strong>{{ $data->primary_member_dob }}</td>
    </tr>
    <tr>
        <td><strong>Contract Policy Plan No: </strong>{{ $data->contract_policy_plan_no }}</td>
        <td><strong>Member Certificate No: </strong>{{ $data->member_certificate_no }}</td>
    </tr>
    <tr>
        <td><strong>Authorize Us To Direct Bill: </strong>{{ $data->authorize_us_to_direct_bill }}</td>
        <td><strong>Second Insurance Coverage: </strong>{{ $data->second_insurance_coverage }}</td>
    </tr>
    <tr>
        <td><strong>Second Insurance Comp. Name: </strong>{{ $data->second_insu_comp_name }}</td>
        <td><strong>Primary Member Name 2: </strong>{{ $data->primary_member_name_2 }}</td>
    </tr>
    <tr>
        <td><strong>Primary Member DOB 2: </strong>{{ $data->primary_member_dob_2 }}</td>
        <td><strong>Contract Policy Plan No 2: </strong>{{ $data->contract_policy_plan_no_2 }}</td>
    </tr>
    <tr>
        <td><strong>Member Certificate No 2: </strong>{{ $data->member_certificate_no_2 }}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>

<table>
    <tr>
        <td><strong>Name: </strong>{{$data->pronoun}} {{ $full_name }}</td>
        <td style="text-align: right;"><strong>Date of Birth: </strong>{{ (!empty($data->dob)) ? get_formatted_date($data->dob, 'M d, Y') : 'MDY' }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; font-size:18px;"><strong>PATIENT HEALTH HISTORY</strong></td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Were you recently involved in a Motor Vehicle Accident OR injured at work?: </strong>{{ $data->v_accident_or_injured ?? 'N/A' }}</td>
       
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2" style="height:50px; vertical-align:top;"><strong>If yes to any of above questions, please provide all pertinent information such as date of injury, Insurance company, Claim number, Adjuster's Name, etc. below: </strong>{{ $data->all_pertinent_infomation }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td><strong>Other Current Injuries: </strong>{{ $data->other_current_injuries ?? 'None' }}</td>
        <td><strong>Primary Complaint (If Any): </strong>{{ $data->primary_complaint }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Did a health care practitioner refer you for massage therapy?: </strong>{{ $data->refer_by_practitioner }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td><strong>Name of your Primary/Family Physician: </strong>{{ $data->health_cre_profess_name }}</td>
        <td><strong>Physician's practice facility information: </strong>{{$data->family_doc_addrs}}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Have you received massage therapy before? </strong> {{ $data->received_massage_before }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Received Treatment from another practitioner: </strong>{{ $data->received_treatment_from_another }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>If yes, please provide type of treatment (chiropractic, physiotherapy, etc.): </strong>{{ $data->if_yes_treatment_type }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td><strong>Current Medications: </strong>{{ $data->current_medications }}</td>
        <td><strong>Do You Have any Allergies: </strong>{{ $data->any_allergies }}</td>
    </tr>
    
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Please list all allergies: </strong>{{ $data->allergy_lst }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>List All Surgeries: </strong>{{ $data->list_all_surgeries }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:15px;"><strong>Please indicate conditions you are experiencing or have experienced:</strong></td>
    </tr>
    
    <tr style="border: 1px solid #6d6d6d;">
        <td><strong>Cardiovascular: </strong>{{ $data->cardiovascular }}</td>
        <td><strong>Gastrointestinal: </strong>{{ $data->gastrointestinal }}</td>
    </tr>
    
    <tr style="border: 1px solid #6d6d6d;">
        <td><strong>Head Neck: </strong>{{ $data->head_neck }}</td>
        <td><strong>Respiratory: </strong>{{ $data->respiratory }}</td>
    </tr>
    
    <tr style="border: 1px solid #6d6d6d;">
        <td><strong>Skin: </strong>{{ $data->skin }}</td>
        <td><strong>Muscle/Joint: </strong>{{ $data->muscle_joint }}</td>
    </tr>
    
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Other Conditions: </strong>{{ $data->other_medical_conditions }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Is there a family history of any of the conditions listed above?: </strong>{{ $data->is_family_history }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Do you have any internal pins, wires, artificial joints or special equipment?: </strong>{{ $data->internal_pin_wire_joint }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>If yes, where?: </strong>{{ $data->joint_or_pin_text }}</td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td><strong>General Health: </strong>{{ $data->good_health }}</td>
        <td>
            <strong>Women (Pregnant, Due): </strong>{{ $data->pregnant ?? 'N/A' }} {{ (!empty($data->pregnant_due_date)) ? ', '.$data->pregnant_due_date : ', N/A' }}
        </td>
    </tr>
    <tr style="border: 1px solid #6d6d6d;">
        <td colspan="2"><strong>Have you given birth within last three months?</strong>:{{ $data->pregnancy_three_month ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
</table>
<table>
    <tr>
        <td><strong>Name: </strong>{{$data->pronoun}} {{ $full_name }}</td>
        <td style="text-align: right;"><strong>Date of Birth: </strong>{{ get_formatted_date($data->dob, 'M d, Y') }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; font-size:18px;"><strong>Consent to Treatment & Patient Rights:</strong></td>
    </tr>

    <tr>
        <td colspan="2">Registered Massage Therapy at the Clinic is provided by a therapist in accordance with the standards of practice and professional requirements established by the College of Massage Therapists of Ontario (CMTO).</td>
    </tr>
    <tr>
        <td colspan="2">Prior to treatment, the proposed plan of care will be explained to you, including its expected benefits, potential risks, and reasonable alternatives. You will have the opportunity to ask questions before treatment begins. Your informed consent is required prior to treatment and may be provided verbally or in writing. Consent is an ongoing process and may be modified or withdrawn by you at any time.</td>
    </tr>
    <tr>
        <td colspan="2">You have the right to decline any assessment or treatment, request modifications to techniques or areas treated, or discontinue treatment at any time. Withdrawal of consent will not affect your ability to access future services unless safety, ethical, or professional boundary concerns arise.</td>
    </tr>
    
    <tr>
        <td colspan="2">If a patient is unable to provide informed consent due to age or capacity, consent will be obtained from a legally authorized Substitute Decision Maker. The Clinic follows Ontario consent laws and professional standards when determining capacity and will involve patients in decision-making to the greatest extent possible.</td>
    </tr>
    <tr>
        <td colspan="2">Registered Massage Therapy is not a substitute for medical diagnosis or emergency medical care, and therapists do not diagnose medical conditions. If you are experiencing a medical emergency, you should contact 911 or seek immediate medical attention.</td>
    </tr>
    
    <tr>
        <td colspan="2" style="font-size:18px; padding-top:10px;"><strong>Privacy & Health Information Protection</strong></td>
    </tr>
    <tr>
        <td colspan="2">Your personal and personal health information is collected, used, and protected in accordance with Ontario's Personal Health Information Protection Act (PHIPA). Information is collected for the purposes of providing safe and effective treatment, maintaining clinical records, processing payments and insurance claims, communicating regarding appointments, and meeting legal and regulatory obligations. Your information will not be disclosed without your consent unless required or permitted by law.</td>
    </tr>
    <tr>
        <td colspan="2">Clinical records are retained in accordance with guidelines established by the College of Massage Therapists of Ontario. Adult records are maintained for a minimum of ten years from the date of last treatment. Records for minors are retained for at least ten years after the individual reaches eighteen years of age. You may request access to your records, and reasonable administrative fees may apply for copies or third-party reports. The Clinic's directors serve as custodians of your health information.</td>
    </tr>
    <tr>
        <td colspan="2">Electronic communication, including email and text messaging, is the primary method used by the Clinic for appointment scheduling, confirmations, reminders, and the issuance of invoices or receipts. While reasonable safeguards are in place, including secure electronic record systems and controlled access, electronic communication carries inherent privacy risks. By providing your contact information, you consent to the use of these methods.</td>
    </tr>
    <tr>
        <td colspan="2">
            The Clinic does not sell, rent, trade, or share your private information with unauthorized third parties.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:18px;"><strong>Professional Standards & Safety:</strong></td>
    </tr>
    <tr>
        <td colspan="2">The Clinic is committed to maintaining a safe, respectful, and professional environment. Treatment is provided within the scope of practice for Massage Therapy and in accordance with regulatory standards. While every effort is made to provide safe and effective care, outcomes may vary and results are not guaranteed.</td>
    </tr>
    <tr>
        <td colspan="2">Massage Therapy is not a substitute for medical diagnosis or emergency care, and the therapist does not diagnose medical conditions. If you are experiencing a medical emergency, you should contact 911 or seek immediate medical attention.</td>
    </tr>
    <tr>
        <td colspan="2">The Clinic follows applicable public health and infection prevention standards, including appropriate hand hygiene, equipment sanitation, and laundering procedures. Inappropriate, unsafe, or abusive behaviour will not be tolerated, and treatment may be refused or discontinued if safety or professional boundaries are compromised.</td>
    </tr>
    <tr>
        <td colspan="2">The Clinic complies with the Ontario Human Rights Code and the Accessibility for Ontarians with Disabilities Act and provides services without discrimination on any protected ground. The Clinic is committed to maintaining an inclusive and accessible environment for all patients.</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:18px;"><strong>Appointments, Fees & Payment</strong></td>
    </tr>
    <tr>
        <td colspan="2">
            A minimum of twenty-four (24) hours’ notice is required to cancel or reschedule an appointment. Late cancellations or missed appointments will incur the full appointment fee. Arriving late may result in reduced treatment time, with the full fee still applicable. If more than half of the scheduled appointment time has passed upon your arrival, the appointment may be considered missed and charged in full at the therapist's discretion. The Clinic may, at its discretion waive cancellation fees under reasonable circumstances. The Clinic reserves the right to cancel or reschedule appointments due to therapist illness or unforeseen circumstances.
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Payment is due at the time services are rendered. If direct billing to an insurance provider is offered as a courtesy, you remain responsible for any portion not covered. Verification of insurance coverage is the patient's responsibility. If a claim is denied or paid directly to you, the outstanding balance remains your responsibility.
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Fees will apply for services not covered by insurance, including completion of forms, reports, or record copies. Accounts not paid within thirty (30) days may be subject to administrative fees and reasonable interest charges as permitted by law. Accounts in significant arrears (90 days or more) may be referred to a third-party collection agency in accordance with applicable laws. Outstanding balances must be paid before future appointments are scheduled.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:18px;"><strong>Policy Updates & Concerns</strong></td>
    </tr>
    <tr>
        <td colspan="2">The Clinic reserves the right to update its policies in response to legislative, regulatory, or professional practice changes. Updated policies are effective upon posting.</td>
    </tr>
    <tr>
        <td colspan="2">If you have questions or concerns regarding your care, you are encouraged to speak directly with the Clinic. You may also contact the College of Massage Therapists of Ontario if a concern remains unresolved.</td>
    </tr>
    <tr>
        <td colspan="2"><strong style="font-size: 18px;">Your Consent & Authorization</strong><br><i>Kindly provide your Acknowledgement.</i></td>
    </tr>
    <tr>
        <td colspan="2">I confirm that I have disclosed all relevant health and medical information to the Clinic to the best of my knowledge and agree to promptly inform the Clinic of any changes to my health, condition, or medications.</td>
    </tr>
    <tr>
        <td colspan="2">I authorize the Clinic's therapist to perform assessments, examinations, and treatments necessary to evaluate and manage my condition within their scope of practice. I understand that I will receive clear information about my condition, the proposed treatment, its expected benefits, material risks, reasonable alternatives, and the potential consequences of declining care. I also understand that I may withdraw my consent at any time.</td>
    </tr>
    <tr>
        <td colspan="2">
            I authorize the Clinic to communicate with other regulated health care professionals as reasonably necessary for my care. I further authorize the disclosure of my personal health information to insurance providers or other authorized third parties for claims processing, care coordination, or as required or permitted by law. I understand that written authorization will be obtained where legally required.
        </td>
    </tr>
    <tr>
        <td colspan="2">
            I acknowledge that reasonable safeguards are in place to protect my information and release the Clinic and its therapists from liability for disclosures made in good faith and in compliance with applicable law.
        </td>
    </tr>
    <tr>
        <td colspan="2">If I have agreed to Benefits Assignment (Direct Billing), I assign any eligible insurance benefits to the provider submitting my claims and authorize my insurer or plan administrator to issue payment directly to the Clinic. If I am a spouse or dependent, I confirm that I am authorized by the plan member to make this assignment.</td>
    </tr>
    <tr>
        <td colspan="2">I understand that information related to my treatment and insurance claims may be transmitted electronically.</td>
    </tr>
    <tr>
        <td colspan="2"><strong>I Acknowledge  </strong>that I have read and understood the Clinic Policies outlined above. I understand my rights regarding informed consent, privacy, and withdrawal from treatment, and I agree to the terms and conditions described above. An electronic version of this authorization is as valid as the original and will remain in effect for the administration of my treatment unless withdrawn in writing.</td>
    </tr>
</table>
<table>
    <tr>
        <td><strong>Name: </strong>{{$data->pronoun}} {{ $full_name }}</td>
        <td style="width:30%;"><strong>Date of Birth: </strong>{{ get_formatted_date($data->dob, 'M d, Y') }}</td>
    </tr>
</table>
<table>
    <tr>
        <td><img src="{{ storage_path('app/public/'.$data->signature_path) }}" style="max-width:100%; width: 300px;"></td>
    </tr>
    <tr>
        <td>{{ ucwords($data->acknowlege_name) }}</td>
    </tr>
    <tr>
        <td>By typing my full legal name and electronically signing above, I consent to the use of electronic signatures and agree that my electronic signature is legally binding under Ontario’s Electronic Commerce Act, 2000, with the same effect as my handwritten signature.</td>
    </tr>
    <tr>
        <td>{{get_formatted_date($data->choose_date, 'M d, Y')}}</td>
    </tr>
    <tr>
        <td>{{ $_SERVER['REMOTE_ADDR'] }}</td>
    </tr>

</table>

</body>
</html>
