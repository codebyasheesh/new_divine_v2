    {{-- Back To Top --}}
    <div id="back-to-top" style="display: none;">
     <a class="p-0 btn btn-sm position-fixed top border-0 text-white" id="top" href="#top">
        <svg width="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
           <path d="M5 15.5L12 8.5L19 15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round"></path>
        </svg>
     </a>
    </div>
    {{-- Back To Top --}}
    
    {{-- Library Bundle Script --}}
    <script src="{{ asset('frontend_assets/js/core/libs.min.js') }}"></script>
    {{-- Plugin Scripts --}}
    
    <!-- Flatpickr Script -->
    @if(Route::currentRouteName() === 'book_appointment')
    <script src="{{asset('frontend_assets/vendor/flatpickr/dist/flatpickr.min.js')}}"></script>
    <script src="{{asset('frontend_assets/js/plugins/flatpickr.js')}}" defer></script>
    @endif
      
      {{-- Bootstrap Bundle Script --}}

    {{-- Slider-tab Script --}}
    <script src="{{asset('frontend_assets/js/plugins/slider-tabs.js')}}"></script>
    
    {{-- fslightbox Script --}}
    <script src="{{asset('frontend_assets/js/plugins/fslightbox.js')}}" defer></script>
    
    {{-- Sweet-alert Script --}}
    <script src="{{asset('frontend_assets/vendor/sweetalert2/dist/sweetalert2.min.js')}}" async></script>
    <script src="{{asset('frontend_assets/js/plugins/sweet-alert.js')}}" defer></script>
    
    {{-- SwiperSlider Script --}}
    <script src="{{asset('frontend_assets/vendor/swiperSlider/swiper-bundle.min.js')}}"></script>
    {{-- Lodash Utility --}}
    <script src="{{asset('frontend_assets/vendor/lodash/lodash.min.js')}}"></script>
    {{-- Utilities Functions --}}
    <script src="{{asset('frontend_assets/js/iqonic-script/utility.min.js')}}"></script>
    {{-- Settings Script --}}
    <script src="{{ asset('frontend_assets/js/iqonic-script/setting.min.js') }}"></script>
    {{-- Settings Init Script --}}
    <script src="{{asset('frontend_assets/js/iqonic-script/setting-init.js')}}"></script>
    {{-- External Library Bundle Script --}}
    <script src="{{asset('frontend_assets/js/core/external.min.js')}}"></script>
    {{-- Kivicare Script --}}
    <script src="{{asset('frontend_assets/js/kivicare.js?v=1.4.1')}}" defer></script>
    <script src="{{asset('frontend_assets/js/kivicare-advance.js?v=1.4.1')}}" defer></script>
    {{-- Kivicare Pages Script --}}
    <script src="{{asset('frontend_assets/js/slider.js')}}" defer></script>
    <script src="{{asset('frontend_assets/js/scroll-text.js')}}" defer></script>
    @if(Route::currentRouteName() === 'medical_form' || Route::currentRouteName() === 'my_account')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        $(document).ready(function (){
            $('#dob, #pri_mem_dob, #primary_member_dob_2').datepicker({
                format: "M dd, yyyy",
                endDate: "yesterday",
                todayHighlight: true,
                autoclose: true
            });
            $("#choose_date").datepicker("setDate" , new Date());
        });

        document.addEventListener("DOMContentLoaded", function () {

            const canvas = document.getElementById('signature-pad');
            const clearBtn = document.getElementById('clear');
            const signatureInput = document.getElementById('signature');
            const form = document.querySelector('#frmMedicalForm_4');

            const signaturePad = new SignaturePad(canvas, {
                minWidth: 0.6,
                maxWidth: 1.8
            });

            canvas.style.touchAction = "none"; // prevent scroll interference

            function resizeCanvas() {
                const data = signaturePad.isEmpty() ? null : signaturePad.toData();
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const rect = canvas.getBoundingClientRect();

                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;

                canvas.getContext("2d").setTransform(ratio, 0, 0, ratio, 0, 0);

                if (data) {
                    signaturePad.fromData(data);
                    signatureInput.value = signaturePad.toDataURL('image/png');
                } // prevent distortion after resize
            }

            resizeCanvas();

            // Very important for mobile landscape
            window.addEventListener("resize", resizeCanvas);
            window.addEventListener("orientationchange", function () {
                setTimeout(resizeCanvas, 300);
            });

            clearBtn.addEventListener('click', function () {
                signaturePad.clear();
                signatureInput.value = '';
            });

            form.addEventListener('submit', function (e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    document.getElementById('sig_error').innerText = "Signature required";
                    return;
                }

                signatureInput.value = signaturePad.toDataURL('image/png');
            });

        });
    </script>
    @endif

    {{-- SweetAlert2 Success Message --}}
@if(Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                // icon: 'success',
                // title: 'Success!',
                text: '{{ Session::get('success') }}',
            });
        });
    </script>
@endif
@if(Session::has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                // icon: 'error',
                // title: 'Error!',
                text: '{{ Session::get('error') }}'
            });
        });
    </script>
@endif

{{-- @auth --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const massageCheckboxes = document.querySelectorAll(
            '.service-checkbox[data-group="massage"]'
        );
        const massageAddOn = document.querySelectorAll('.service-checkbox[data-group="massage_addon"]');

        massageCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {

                if (this.checked) {
                    massageCheckboxes.forEach(function (cb) {
                        if (cb !== checkbox) {
                            cb.checked = false;
                            cb.disabled = true;
                        }
                    });
                    massageAddOn.forEach(function (mcb) {
                        mcb.disabled = false;
                    });
                } else {
                    massageCheckboxes.forEach(function (cb) {
                        cb.disabled = false;
                    });
                    massageAddOn.forEach(function (mcb) {
                        mcb.disabled = true;
                        mcb.checked = false;
                    });
                }
            });
        });

    });

    // on click on next button of service section shoot the ajax request to the server for check the earliest date according to available slot.
    let monthOffset = 0;
    $(document).on('click', '#chkSevDur', function() {
        monthOffset = 0;
        findEarlySlotDate(monthOffset);
    });

    function findEarlySlotDate(offset) {
        const checkboxes = document.querySelectorAll('.service-checkbox');
        const selected = [];
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                selected.push(checkbox.value);
            }
        });
        if(selected.length > 0) {
            $.ajax({
                url: '{{ route("check.early.booking.date") }}',
                type: 'POST',
                data: { offset:offset, services: selected },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                },
                success: function (res) {
                    if(res.status == true) {
                        $('#early_date').html(`Earliest Available TimeSlot on: <span style="color: #229450; font-weight: bold;">${res.early_date}</span>`);
                    }
                    else {
                        Swal.fire({
                            // title: 'No Availability',
                            text: res.message,
                            // icon: 'warning',
                            showCancelButton: false,
                            confirmButtonText: 'Check Next Month',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                findEarlySlotDate(offset + 1); // NEXT MONTH
                            }
                        });
                    }
                }
            });
        }
    }

    if($('.blank')) {
        $('.blank').on('click', function (){
            Swal.fire({
                text: 'To begin your booking, please select a date to see the available timeslots'
            });
            return false;
        })
    }

    $('#appointment_dt').change(function (){
        var appointment_dt = $(this).val();
        const checkboxes = document.querySelectorAll('.service-checkbox');
        const selected = [];
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                selected.push(checkbox.value);
            }
        });

        if(selected.length === 0) {
            Swal.fire({
                // icon: 'error',
                // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                text: 'Please select at least one serivce to continue with your booking request.'
            });
            return false;
        }

        // console.log(`Appointment Date: ${appointment_dt}, Services: ${selected}` );
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let url = '{{route("check_availability")}}';
        $.ajax({
            type: 'post',
            url: url,
            data: {appoint_dt:appointment_dt, services:selected},
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(html) {
                if (html.status == '200') {
                    Swal.close();
                    $('#req_duration').html('');
                    // $('#req_duration').html(`You Need Total Duration: ${html.duration} minutes`);
                    $('#req_duration').html(`Your selected service(s) require ${html.duration} minutes slot`);
                    $('#time_slots_div').html('');
                    $('#de_cli_endtm').val(html.cli_endtm);
                    $('#time_slots_div').html(html.message);
                    if(html.block_type != ''){
                        // $('#valid_err').addClass('text-danger');
                        // $('#valid_err').html(`Slots are Not Available Due to ${html.block_type} holiday.`);
                    }
                    else {
                        $('#valid_err').html('');
                        $('#valid_err').removeClass('text-danger');
                    }
                }
                if (html.code == '404') {
                    Swal.close();
                    $('#req_duration').html('');
                    $('#time_slots_div').html('');
                }
            }
        });
    });

    function restoreOriginalStyle(slot) {
        slot.removeClass('slot_highlight');
        $('#selected_slots').val('');
        if (slot.data('booked') == 1) {
            slot.addClass('disable_slots');
        } else if (slot.data('blocked') == 1) {
            slot.addClass('blocked_slot');
        } else if (slot.data('lunch') == 1) {
            slot.addClass('blocked_slot');
        } 
    }

    // Converts "HH:MM" or "hh:MM am/pm" to total minutes
    function timeToMinutes(timeStr) {
        timeStr = timeStr.trim().toLowerCase();
        let isPM = timeStr.includes('pm');
        let isAM = timeStr.includes('am');
        timeStr = timeStr.replace('am', '').replace('pm', '').trim();

        let [hours, minutes] = timeStr.split(':').map(Number);

        if (isPM && hours !== 12) hours += 12;
        if (isAM && hours === 12) hours = 0;

        return hours * 60 + minutes;
    }

    $(document).on('click', '.slot_brd', function() {
        var slots = $('.slot_brd');
        let appoint_dt = $('#appointment_dt').val();

        if (!appoint_dt) {
            Swal.fire({
                text: 'To begin your booking, please select a date to see the available timeslots'
            });
            return;
        }
        // let parts = appoint_dt.split('-');
        const bookingDate = new Date(appoint_dt + 'T00:00:00');
        
        const day = bookingDate.getDay(); // 0=Sunday
        $('.slot_highlight').each(function () {
            restoreOriginalStyle($(this));
        });

        let clickedSlot = $(this);
        let requiredDuration = parseInt(clickedSlot.data('duration'));
        let slotDuration = parseInt($('#de_cli_dura').val()); // 30
        let slotsNeeded = requiredDuration / slotDuration;

        // Get all clinic slots from hidden input
        let allClinicSlots = [];
        try {
            allClinicSlots = JSON.parse($('#de_cli_tms').val() || '[]');
        } catch (e) {
            allClinicSlots = [];
        }

        // Get displayed slots
        let displayedSlots = $('#time_slots_div .slot_brd');
        let clickedValue = clickedSlot.data('value');
        let clickedIndex = allClinicSlots.indexOf(clickedValue);

        if (clickedIndex === -1) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Selected slot not found in clinic schedule.'
            });
            return;
        }

        let selectedSlots = [];
        let hasBlocked = false;
        let hasLunch = false;
        let hasBooked = false;
        let exceedsClinicTime = false;

        // Parse clinic end time for boundary validation
        let clinicEndTime = $('#de_cli_endtm').val(); // e.g. "19:00"
        

        // Validate: clicked slot start time + required duration must not exceed clinic end time
        let clickedSlotMinutes = timeToMinutes(clickedValue);
        let clinicEndMinutes = timeToMinutes(clinicEndTime);

        if (clickedSlotMinutes + requiredDuration > clinicEndMinutes) {
            Swal.fire({
                text: 'The selected timeslot does not allow sufficient time for your selected service before clinic closing time. Please select an earlier timeslot.'
            });
            return;
        }

        for (let i = clickedIndex; i < clickedIndex + slotsNeeded; i++) {
            let slotValue = allClinicSlots[i];

            if (!slotValue) {
                Swal.fire({
                    text: 'Required duration exceeds clinic timing.'
                });
                return;
            }

            // Find the corresponding DOM element
            let slot = displayedSlots.filter('[data-value="' + slotValue + '"]');

            if (!slot.length) {
                // Slot exists in schedule but not displayed (might be filtered out)
                continue;
            }

            if (slot.data('booked') == 1) {
                hasBooked = true;
                break;
            }

            if (slot.data('blocked') == 1) {
                hasBlocked = true;
                break;
            }

            if (slot.data('lunch') == 1) {
                hasLunch = true;
                break;
            }

            // -------------------------------------------------------
            // CHECK: Does this slot's END time exceed clinic end time?
            // Each slot occupies one slotDuration (e.g. 30 mins).
            // So slot ending = slot start time + slotDuration minutes.
            // -------------------------------------------------------
            let slotStartMinutes = timeToMinutes(slotValue);
            let slotEndMinutes   = slotStartMinutes + slotDuration;
            let clinicEndMinutes = timeToMinutes(clinicEndTime);

            if (slotEndMinutes > clinicEndMinutes) {
                Swal.fire({
                    text: 'The selected timeslot does not allow sufficient time for your selected service within clinic hours. Please select an earlier timeslot.'
                });
                return;
            }

            selectedSlots.push(slot);
        }

        // If any required slot is booked, reject immediately
        if (hasBooked) {
            Swal.fire({
                text: 'The selected timeslot does not allow sufficient time for your selected service. Please select another suitable timeslot'
            });
            return;
        }
        if (hasBlocked) {
            Swal.fire({
                text: 'The selected timeslot does not allow sufficient time for your selected service. Please select another suitable timeslot'
            });
            return;
        }
        if (hasLunch) {
            Swal.fire({
                text: 'The selected timeslot does not allow sufficient time for your selected service. Please select another suitable timeslot'
            });
            return;
        }

        
        function applySelection() {
            selectedSlots.forEach(function (slot) {
                slot.addClass('slot_highlight')
            });

            let selectedTimeValues = selectedSlots.map(function (slot) {
                return slot.data('value');
            });

            $('#selected_slots').val(selectedTimeValues.join(','));
        }
        
        applySelection();
        
    });

    // Validate timeslot and date before go to next step
    $(document).on('click', '#btn_tm_dt', function (){
        let appoint_dt = $('#appointment_dt').val();
        if (!appoint_dt) {
            Swal.fire({
                text: 'Please select Appointment Date and Time'
            });
            $('#descPrev').trigger('click');
            setTimeout(function (){
                // $('#step_2').css('display', 'none');
                $('#step_3').css('display', 'none');
            }, 2000);
            return false;
        }
        const selectedSlot = document.querySelector('.slot_brd.slot_highlight');
        if(!selectedSlot)
        {
            Swal.fire({
                text: 'Please select a suitable time slot in order to continue your booking request!'
            });
            $('#descPrev').trigger('click');
            setTimeout(function (){
                // $('#step_2').css('display', 'none');
                $('#step_3').css('display', 'none');
            }, 2000);
            return false;
        }
        else {
            return true;
        }
    });

    // Get Bookings List by It's Status
    const getBookingByStatus = (status, fmly_id, output_div) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: '{{route("list_booking")}}',
            data: {
                status: status,
                family_id: fmly_id,
            },
            cache: false,
            dataType: 'json',
            beforeSend: function() {
            },
            success: function(html) {
                if (html.status == 200) {
                    $(`#${output_div}`).html(html.message);
                } else if (html.status == 500) {

                }
            }
        });
    };

    // Show Family Members
    const familyMembers = (output_div) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'get',
            url: '{{route("family_member")}}',
            cache: false,
            dataType: 'json',
            beforeSend: function() {
            },
            success: function(html) {
                if (html.status == '200') {
                    $(`#${output_div}`).html(html.output);
                } else if (html.status == 500) {
                }
            }
        });
    };

    // Cancel Appointment Booking
    const cancelBooking = (booking_id, canTyp) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let cancle_text = 'Cancel the Appointment!';
        if(canTyp == 'reschedule') {
            cancle_text = 'Re-schedule the Appointment!';
        }
        Swal.fire({
            title: "Are you sure?",
            text: cancle_text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
            cancelButtonText: "No"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire({
                    // title: "Deleted!",
                    // text: "Your file has been deleted.",
                    // icon: "success"
                    // });
                    $.ajax({
                        type: 'post',
                        url: '{{route("cancel_booking")}}',
                        data: {
                            booking_id: booking_id,
                        },
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {
                        },
                        success: function(html) {
                            if (html.status == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: html.message
                                });
                                if(canTyp == 'reschedule') {
                                    window.location.href = '{{ route("book_appointment") }}';
                                }
                                else {
                                    setTimeout(() => {
                                        location.reload();
                                    }, 3000);
                                }
                            }
                        },
                        error: function (xhr) {
                            const error = xhr.responseJSON.message;
                            Swal.fire({
                                // icon: 'error',
                                // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                                text: error
                            });
                        }
                    });
                }
            });
        
    }
    // End Cancel Appointment Booking

    // Show Logged-in User Account Detail
    const accountDetail = () => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'get',
            url: '{{route("account_detail")}}',
            cache: false,
            dataType: 'json',
            beforeSend: function() {
            },
            success: function(html) {
                if (html.status == '200') {
                    $(`#acc_first_name`).val(`${html.output.first_name}`);
                    $(`#acc_last_name`).val(`${html.output.last_name}`);
                    $(`#acc_email`).val(html.output.email);
                    $(`#acc_mobile`).val(html.output.mobile);
                    $(`#acc_gender`).val(html.output.gender);
                    $(`#acc_city`).val(html.output.city);
                    $(`#acc_state`).val(html.output.state);
                    $(`#acc_postal_code`).val(html.output.postal_code);
                    $(`#acc_address`).val(html.output.address);
                } else if (html.status == 500) {

                }
            }
        });
    };

    // Update account Detail from Dashboard
    if(document.getElementById('accountForm')) {
        document.getElementById('accountForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('update_account') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: `${data.message}`,
                    });
                    // alert('Account updated successfully!');
                } else {
                    Swal.fire({
                        // icon: 'error',
                        // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                        text: `${data.message}`
                    });
                    // alert('Something went wrong.');
                }
            })
            .catch(err => console.error("AJAX error:", err));
        });
    }
    

    // Add Family Member From Dashboard
    if(document.getElementById('frmAddFamily')) {
        $(document).on('click', '.openModalBtn', function (){
            let data = $(this).data('dependent');
            $('input[name="dependent"]').val(data);
        });
        document.getElementById('frmAddFamily').addEventListener('submit', function(e) {
            e.preventDefault();
            if ($('#first_name').val() == '') {
                $('.error-first_name').html(`Please enter First Name`);
                return false;
            }
            else{
                $('.error-first_name').html(``);
            }
            if ($('#last_name').val() == '') {
                $('.error-last_name').html(`Please enter Last Name`);
                return false;
            }
            else{
                $('.error-last_name').html(``);
            }
            if ($('#email').val() == '' && $('input[name="dependent"]').val() == 'no') {
                $('.error-email').html(`Please enter Email`);
                return false;
            }
            else {
                $('.error-email').html(``);
            }
            if ($('#mobile').val() == '' && $('input[name="dependent"]').val() == 'no') {
                $('.error-mobile').html(`Please enter Mobile Number`);
                return false;
            }
            else {
                $('.error-mobile').html(``);
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            // console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{route("add_family_member")}}',
                // data: $('form' + '#frmAddFamily').serialize(),
                data: $('form' + '#frmAddFamily').serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#btnLog').hide();
                    $("#loader").removeClass('d-none');
                },
                success: function(html) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    if (html.status == true) {
                        $("#addFamilyPop").modal('hide');
                        
                        Toast.fire({
                            icon: 'success',
                            title: html.message
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $(`.error-${key}`).text(value[0]);
                        });
                        $('#btnLog').show();
                        $("#loader").addClass('d-none');
                    }
                    else if(xhr.status == 500) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON.message
                        });
                        $('#btnLog').show();
                        $("#loader").addClass('d-none');
                    }
                }
            });
        });
    }
    // End Add Family Member

    // Add Existing Client Mail to Admin
    if(document.getElementById('frmAddExistingClient')) {
        document.getElementById('frmAddExistingClient').addEventListener('submit', function (e){
            e.preventDefault();
            if($('#exist_first_name').val() == '') {
                $('.error-exist_first_name').html('Please enter the First Name');
                $('#exist_first_name').focus();
                return false;
            }
            else {
                $('.error-exist_first_name').html('');
            }

            if($('#exist_last_name').val() == '') {
                $('.error-exist_last_name').html('Please enter the Last Name');
                $('#exist_last_name').focus();
                return false;
            }
            else {
                $('.error-exist_last_name').html('');
            }

            if($('#exist_email').val() == '') {
                $('.error-exist_email').html('Please enter Email');
                $('#exist_email').focus();
                return false;
            }
            else {
                $('.error-exist_email').html('');
            }

            if($('#exist_mobile').val() == '') {
                $('.error-exist_mobile').html('Please enter mobile');
                $('#exist_mobile').focus();
                return false;
            }
            else {
                $('.error-exist_mobile').html('');
            }

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            $.ajax({
                type: 'POST',
                url: '{{route("add_individual_in_family_request")}}',
                // data: $('form' + '#frmAddFamily').serialize(),
                data: $('form' + '#frmAddExistingClient').serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#btnLog').hide();
                    $("#loader").removeClass('d-none');
                },
                success: function(html) {
                    if (html.status == true) {
                        $("#addExistingClientPopUp").modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: html.message
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $(`.error-${key}`).text(value[0]);
                        });
                        $('#btnLog').show();
                        $("#loader").addClass('d-none');
                    }
                    else if(xhr.status == 500) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON.message
                        });
                        $('#btnLog').show();
                        $("#loader").addClass('d-none');
                    }
                }
            });
        })
    }
    // End Add Existing Client Mail to Admin

    // Change Password by Logged-in User
    if(document.getElementById('changePassForm')) {
        document.getElementById('changePassForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('change_password') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: `${data.message}`,
                    });
                    // alert('Account updated successfully!');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: `${data.message}`
                    });
                    // alert('Something went wrong.');
                }
            })
            .catch(err => console.error("AJAX error:", err));
        });
    }
    
    // On Select Customer name show the customer details in patient Info Section
</script> 
 @if(Route::currentRouteName() === 'book_appointment' || Route::currentRouteName() === 'waited_booking') 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        // $('#dob').datepicker({
        //     format: "M dd, yyyy",
        //     endDate: "yesterday",
        //     todayHighlight: true,
        //     autoclose: true
        // });
        const setDaysCount = (month, dtEle, yrEle) => {
            let yr = new Date().getFullYear();
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            if(month == 2) {
                if(document.getElementById(yrEle).value == '') {
                    Swal.fire({
                        // icon: 'error',
                        title: 'Error!',
                        text: 'Please select year first!'
                    });
                    return false;
                }
                else {
                    yr = document.getElementById(yrEle).value;
                }
            }
            
            const days = getDaysInMonth(month, yr);
            const days_dropdown = document.getElementById(dtEle);
            days_dropdown.innerHTML = ``;
            days_dropdown.innerHTML = `<option value=''>Date</option>`;
            for(let day = 1; day <= days; day++) {
                const option = document.createElement('option');
                const dayFormatted = String(day).padStart(2, '0');
                option.value = dayFormatted;
                option.textContent = dayFormatted;
                days_dropdown.appendChild(option);
            }
        };
        const getDaysInMonth = (month, year) => {
            return new Date(year, month, 0).getDate();
        };

        function isValidEmail(email) {
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
        // Check email for new user. if new email then send OTP to verify.
        $('input[name="booking_frm_email"]').on('blur', function () {

            let emailField = $(this);
            let email = emailField.val().trim();
            if (email === '') return;
            else if(!isValidEmail(email)) {
                $(this).focus();
                Swal.fire({
                    title: 'Email Error',
                    text: 'Please enter valid Email address'
                });
                return false;
            }

            $.ajax({
                url: '{{ route("check.email") }}',
                type: 'POST',
                data: { email: email },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // Prevent multiple requests
                    emailField.prop('readonly', true);

                    // Optional loader
                    Swal.fire({
                        title: 'Checking email...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function (res) {
                    // Email exists → allow form
                    // Show email → OTP modal
                    if (res.status === true) {
                        Swal.close();
                        openOtpModal(email);
                    }
                    else {
                        if(res.status === false && res.email_exists === true && res.mail_sent === false) {
                            Swal.close();
                            askSendOtpToRegisteredMobile(email, res.mobuse); // client registered but mail not sent
                            return;
                        }
                        if(res.status === false && res.email_exists === false && res.mail_sent === true) {
                            Swal.close();
                            openOtpModal(email); // client not registered and mail sent
                        }
                        if(res.status == false && res.email_exists === false && res.mail_sent === false) {
                            Swal.close();
                            Swal.fire({
                                title: 'Email validation error',
                                html: res.message
                            });
                        }
                        if(res.type == 'single_user'){
                            showSingleWithNewOption(res.user);
                            return true;
                        }
                        if(res.type == 'family_users') {
                            showFamilyMembers(res.members);
                            return true;
                        }
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let msgs = '';
                        $.each(errors, function (key, value) {
                            msgs += value[0];
                        });
                        swal.fire({
                            title: 'Email Error',
                            text: `${msgs}`
                        });
                    }
                }
            });
        });

        function openOtpModal(email) {
            Swal.fire({
                title: 'Verify Email',
                html: `
                    <p class="mb-2">
                        OTP sent to <strong>${email}</strong>
                    </p>

                    <input type="text"
                        id="otp_input"
                        class="swal2-input"
                        placeholder="Enter 6-digit OTP"
                        maxlength="6"
                        autocomplete="off">

                    <p class="mt-2">
                        <a href="javascript:void(0)" id="changeEmailLink" style="font-size:14px;">
                            Wrong Email ID? Click here to change
                        </a>
                    </p>
                `,
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: true,
                confirmButtonText: 'Verify OTP',
                preConfirm: () => {
                    let otp = Swal.getPopup().querySelector('#otp_input').value;

                    if (!otp) {
                        Swal.showValidationMessage('OTP is required');
                        return false;
                    }
                    if (otp.length !== 6) {
                        Swal.showValidationMessage('Please enter a valid 6-digit OTP');
                        return false;
                    }
                    return verifyOtp(otp);
                },
                didOpen: () => {
                    const popup = Swal.getPopup();
                    const changeEmailLink = popup.querySelector('#changeEmailLink');

                    changeEmailLink.addEventListener('click', function () {

                        Swal.close();

                        // Reset OTP input
                        $('#otp_input').val('');

                        // Enable & reset email field
                        const emailField = $('input[name="booking_frm_email"]');
                        emailField.prop('readonly', false);
                        emailField.val('');
                        emailField.focus();
                    });
                }
            });
        }

        // This function is used when User not exist and need to enter mobile number to send Otp and verify.
        function askSendOtpToRegisteredMobile(email, mobile)
        {
            const masked = mobile.slice(-4).padStart(mobile.length, '*');
            Swal.fire({
                title: 'Unable to send OTP to Email',
                html: `
                    <p>
                        We apologize that OTP code could not be sent to your email address at this time.
                    </p>

                    <p style="margin-top:10px;">
                        Please click below to receive the code via Text on mobile number ${masked}?
                    </p>
                `,
                showCancelButton: true,
                confirmButtonText: 'Send OTP',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false
            }).then((result) => {
                if(result.isConfirmed) {
                    sendMobileOtp(mobile);
                }
            });
        }

        // Now send OTP to entered mobile number
        function sendMobileOtp(mobile)
        {
            return $.ajax({
                url: '{{ route("send.mobile.otp") }}',
                type: 'POST',
                data: {
                    mobile: mobile
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(function(res) {
                if(!res.status) {
                    Swal.showValidationMessage(res.message);
                    return false;
                }
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Sent',
                    text: 'OTP sent on mobile number',
                    timer: 1500,
                    showConfirmButton: false
                });
                // OPEN SAME OTP MODAL
                $('#mobile').val(mobile);
                openMobileVerifyOtpModal(mobile);
                return true;
            });
        }

        // Verify Mobile OTP
        function openMobileVerifyOtpModal(mobile)
        {
            let masked = mobile.slice(-4).padStart(mobile.length, '*');
            Swal.fire({
                title: 'Verify Mobile OTP',
                html: `
                    <p class="mb-2">
                        OTP sent to
                        <strong>${masked}</strong>
                    </p>

                    <input type="text"
                        id="mobile_otp_input"
                        class="swal2-input"
                        placeholder="Enter 6-digit OTP"
                        maxlength="6"
                        autocomplete="off">
                `,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'Verify OTP',

                preConfirm: () => {
                    let otp = $('#mobile_otp_input').val().trim();
                    if(otp === '') {
                        Swal.showValidationMessage('OTP is required');
                        return false;
                    }

                    if(otp.length != 6) {
                        Swal.showValidationMessage('Please enter valid OTP');
                        return false;
                    }

                    return verifyOtp(otp);
                }
            });
        }

        function verifyOtp(otp) {

            return $.ajax({
                url: '{{ route("check.emailotp") }}',
                type: 'POST',
                data: { otp: otp },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(function (res) {
                if (!res.status) {
                    Swal.showValidationMessage(res.message);
                    return false;
                }

                Swal.fire({
                    icon: 'success',
                    title: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#mobile').focus();

                // case 1: New Email entered
                if(res.type == 'new_user') {
                    $('#f_name, #l_name').prop('readonly', false);
                    swal.fire({
                        icon: 'success',
                        title: res.message,
                    });
                    return true;
                }

                // case 2: Existing user with family_id == 0
                if(res.type == 'single_user') {
                    showSingleWithNewOption(res.user);
                    return true;
                }

                // case 3: Existing user with family_id > 0
                if(res.type == 'family_users') {
                    showFamilyMembers(res.members);
                    return true;
                }
                
            });
        }

        function showSingleWithNewOption(client) {

            let html = '<div style="text-align:left;">';
            html += `
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="family_member" id="fm_0" data-first="${client.first_name}" 
                        data-last="${client.last_name}" data-mobile="${client.mobile}"> <label class="form-check-label" for="fm_0" style="vertical-align: sub;">${client.first_name} ${client.last_name}</label>
                    </div>`;

            html += `<div class="form-check">
                        <input type="radio" class="form-check-input" name="family_member" id="nw" data-first="" 
                        data-last="" data-mobile=""> <label class="form-check-label" for="nw" style="vertical-align: sub;">Enter a new dependent</label> 
                    </div></div>`;

            Swal.fire({
                title: 'Please choose the family member the appointment is for',
                html: html,
                confirmButtonText: 'OK',
                customClass: {
                    title: 'swal-title-small'
                },
                preConfirm: () => {
                    let selected = $('input[name="family_member"]:checked');
                    if (!selected.length) {
                        Swal.showValidationMessage('Please select a family member');
                        return false;
                    }
                    
                    let selectedMobile = selected.data('mobile');
                    if(!selectedMobile) {
                        selectedMobile = client.mobile;
                    }
                    return {
                        first_name: selected.data('first'),
                        last_name: selected.data('last'),
                        mobile: selectedMobile
                    };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    if(result.value.first_name == ''){
                        $('#f_name').val(result.value.first_name).prop('readonly', false);
                    }
                    else {
                        $('#f_name').val(result.value.first_name).prop('readonly', true);
                    }
                    
                    if(result.value.last_name == '') {
                        $('#l_name').val(result.value.last_name).prop('readonly', false);
                    }
                    else {
                        $('#l_name').val(result.value.last_name).prop('readonly', true);
                    }
                    
                    $('#mobile').val(result.value.mobile).prop('readonly', false);
                }
            });
        }

        function showFamilyMembers(members) {
            let firstMemberMobile = members.length > 0 ? members[0].mobile : '';

            let html = '<div style="text-align:left;">';

            members.forEach((member, index) => {
                html += `
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="family_member" id="fm_${index}" data-first="${member.first_name}" 
                        data-last="${member.last_name}" data-mobile="${member.mobile}"> <label class="form-check-label" for="fm_${index}" style="vertical-align: sub;">${member.first_name} ${member.last_name}</label>
                    </div>`;
            });

            html += `<div class="form-check">
                        <input type="radio" class="form-check-input" name="family_member" id="nw" data-first="" 
                        data-last="" data-mobile=""> <label class="form-check-label" for="nw" style="vertical-align: sub;">Enter a new dependent</label> 
                    </div></div>`;

            Swal.fire({
                title: 'Please choose the family member the appointment is for',
                html: html,
                confirmButtonText: 'OK',
                customClass: {
                    title: 'swal-title-small'
                },
                preConfirm: () => {
                    let selected = $('input[name="family_member"]:checked');
                    if (!selected.length) {
                        Swal.showValidationMessage('Please select a family member');
                        return false;
                    }
                    
                    let selectedMobile = selected.data('mobile');
                    if(!selectedMobile) {
                        selectedMobile = firstMemberMobile;
                    }
                    return {
                        first_name: selected.data('first'),
                        last_name: selected.data('last'),
                        mobile: selectedMobile
                    };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    if(result.value.first_name == ''){
                        $('#f_name').val(result.value.first_name).prop('readonly', false);
                    }
                    else {
                        $('#f_name').val(result.value.first_name).prop('readonly', true);
                    }
                    
                    if(result.value.last_name == '') {
                        $('#l_name').val(result.value.last_name).prop('readonly', false);
                    }
                    else {
                        $('#l_name').val(result.value.last_name).prop('readonly', true);
                    }
                    
                    $('#mobile').val(result.value.mobile).prop('readonly', false);
                }
            });
        }

        // During booking, customer name enter or check if exist then use that id.
        $(document).on('click', '#step_3_btn', function () {
            let f_name = $('#f_name').val();
            let l_name = $('#l_name').val();
            let u_email = $('#email').val();
            let u_mobile = $('#mobile').val();
            let u_gender = $('input[name="gender"]:checked').val();
            let u_dob_y = $('#dob_y').val();
            let u_dob_m = $('#dob_m').val();
            let u_dob_d = $('#dob_d').val();

            const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;

            // Validation
            if(f_name == '' || l_name == '' || u_email == '' || u_mobile == '') {
                Swal.fire({
                    text: 'Please provide all required information in order to continue your booking request.'
                });
                $('#frmPrev').trigger('click');
                setTimeout(function (){
                    $('#step_4').css('display', 'none');
                }, 2000);
                return false;
            }
            if (!mobileRegex.test(u_mobile)) {
                Swal.fire({
                    // Mobile number must be a valid 10-digit number.
                    text: 'Please enter a valid phone number to continue your booking'
                });

                $('#frmPrev').trigger('click');
                setTimeout(function () {
                    $('#step_4').css('display', 'none');
                }, 2000);
                return false;
            }
            // End Here
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let booking_dt = $('#appointment_dt').val();
            let total_price = 0;
            $('#show_choose_services').html('');
            $('.service-checkbox:checked').each(function() {
                let service_id = $(this).val();
                let ser_nm = $(`#nmspan_${service_id}`).html();
                let ser_price = $(`#prc_${service_id}`).html();

                // show the selected services with it's price.                
                $('#show_choose_services').append(`<tr>
                    <td class="p-0 border-0">
                        <h6 class="mb-2">${ser_nm}</h6>
                    </td>
                    <td class="p-0 border-0">
                        <p class="mb-2 ps-2 text-start">${ser_price}</p>
                    </td>
                    </tr>`);
                total_price += parseFloat(ser_price.replace(/[^0-9.-]+/g,""));
            });

            // Format the booking date to show in next step
            let dateObj = new Date(booking_dt + 'T00:00:00');
            let formatted = dateObj.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            });
            $('#booking_dt').html(formatted);  // Show the Booking Date
            // $('#booking_dt_fnl').html(formatted);  // Show the Booking Date
            $('#price_lbl').html(`$${total_price.toFixed(2)}`); // Show the Total Booking Price
            $('#total_price').val(total_price.toFixed(2)); // set the total price in hidden field
            
            // Get All Selected Slots data-value in array to show in booking summary
            let selectedSlots = [];
            $('.slot_brd.slot_highlight').each(function () {
                selectedSlots.push($(this).data('value'));
            });

            $('#booking_slots_h6').html(selectedSlots[0] || '');

            let url = '{{route("get_or_register_user")}}';
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('app.google_captcha.sitekey') }}', {action: 'submit'}).then(function(token) {
                    let postData = {
                        f_name: f_name,
                        l_name: l_name,
                        email: u_email,
                        mobile: u_mobile,
                        gender: u_gender,
                        dob_y: u_dob_y,
                        dob_m: u_dob_m,
                        dob_d: u_dob_d,
                        token: token
                    };
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: postData,
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {
                        },
                        success: function(html) {
                            if(html.status === 200) {
                                $('#customer').val(html.user_id);
                                $('#cust_nm').html(`${html.customer_first_name} ${html.customer_last_name}`);
                                $('#cust_nm_hdn').val(`${html.customer_first_name} ${html.customer_last_name}`);
                                $('#cust_email_hdn').val(`${html.customer_email}`);
                                $('#cust_mob_hdn').val(`${html.customer_mobile}`);
                                $('#cust_mob').html(`${u_mobile}`);
                                $('#cust_email').html(`${html.customer_email}`);
                            }
                            if(html.status == 400) {
                                $('#frmPrev').trigger('click');
                                setTimeout(function (){
                                    $('#step_4').css('display', 'none');
                                    Swal.fire({
                                        // icon: 'error',
                                        // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                                        text: html.msg
                                    });
                                }, 2000);
                            }
                            if(html.status == 401) {
                                $('#frmPrev').trigger('click');
                                setTimeout(function (){
                                    $('#step_4').css('display', 'none');
                                    Swal.fire({
                                        // icon: 'error',
                                        // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                                        text: html.msg
                                    });
                                }, 2000);
                            }
                        },
                        error:function (xhr) {
                            if(xhr.status == 422){
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function (key, value){
                                    Swal.fire({
                                        // icon: 'error',
                                        // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                                        text: value[0]
                                    });
                                });
                                $('#frmPrev').trigger('click');
                                setTimeout(function (){
                                    $('#step_4').css('display', 'none');
                                }, 3000);
                            }
                        }
                    });
                });
            });
        });

        // Final Booking Confirmation
        const confirm_appointment = () => {
            // fresh Booking
            var booking_dt = $('#appointment_dt').val(); // get booking date
            var customer_id = $('#customer').val(); // get customer id
            var customer_name = $('#cust_nm_hdn').val();    // get customer name
            var customer_email = $('#cust_email_hdn').val(); // get customer email
            var customer_mobile = $('#cust_mob_hdn').val(); // get customer mobile
            var message = $('#message').val(); // get message
            var total_price = $('#total_price').val(); // get total price
            // Get selected payment method

            // get Selected Services
            const checkboxes = document.querySelectorAll('.service-checkbox');
            var selected_services = [];
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selected_services.push(checkbox.value);
                }
            });

            // if cusotmer id not exist then return false
            if(customer_id === ''){
                Swal.fire({
                    // icon: 'error',
                    // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                    text: 'Please enter client detail first!'
                });
                $('#step_4').show();
                $('#step_5').hide();
                return false;
            }

            // Service Validation
            if(selected_services.length === 0) {
                Swal.fire({
                    // icon: 'error',
                    // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                    text: 'Please select at least one Serivce to continue with your booking request.'
                });
                $('#step_1').show();
                $('#step_2').hide();
                return false;
            }

            // get Selected Slots
            var selectedSlots = [];
            $('.slot_brd.slot_highlight').each(function () {
                selectedSlots.push($(this).data('value'));
            });

            if(selectedSlots.length <= 0){
                Swal.fire({
                    // icon: 'error',
                    // title: '<span style="color:#ff6d9e;">!</span> <span style="font-size: 24px;">Please Wait</span> <span style="color:#ff6d9e;">!</span>',
                    text: 'Please select available time slot!'
                });
                return false;
            }
            let stp_5 = document.getElementById('step_5');
            let stp_6 = document.getElementById('step_6');
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('app.google_captcha.sitekey') }}', {action: 'submit'}).then(function(token) {
                    // post data 
                    let postData = {
                        appoint_dt: booking_dt,
                        customer_id: customer_id,
                        customer_name: customer_name,
                        customer_email: customer_email,
                        customer_mobile: customer_mobile,
                        message: message,
                        total_price: total_price,
                        services: selected_services,
                        slots: selectedSlots,
                        token: token,
                    };
                    // End Post Data

                    $.ajax({
                        type: 'post',
                        url: '{{route("process_booking")}}',
                        data: postData,
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#fnl_btn').html('Processing...');
                            $('.confirm-button').attr('disabled', true);
                            showLoadingOverlay();
                        },
                        success: function(html) {
                            if (html.status == '200') {
                                hideLoadingOverlay();
                                $('#booking_res_h4').html(html.message);
                                $('#fnl_btn').html('Confirm');
                                $('.confirm-button').removeAttr('disabled');
                                // Reset hidden fields
                                $('#cust_nm_hdn, #cust_email_hdn, #cust_mob_hdn, #total_price').val('');
                                // Reset visible fields
                                $('#cust_nm, #cust_email, #cust_mob, #booking_dt, #price_lbl, #booking_slots_h6').html('');

                                // Reset checkboxes and radio buttons
                                $('.service-checkbox').prop('checked', false);
                                // $('input[name="payment_method"]').prop('checked', false);

                                // Remove slot highlights
                                $('.slot_brd').removeClass('slot_highlight');

                                // Reset selects and other fields if needed
                                $('#customer').val('');
                                $('#f_name').val('');
                                $('#l_name').val('');
                                $('#email').val('');
                                $('#mobile').val('');

                                $('#appointment_dt').val('');
                                $('#message').val('');

                                $("#appointment-tab-list").find(".active").addClass("done");
                                $('.confirm-button').parents(".appointment-content-active").fadeOut("slow", function () {
                                    $('.confirm-button').next(".appointment-content-active").fadeIn("slow");
                                });
                                $('#step_7').css('display', 'block');
                            }
                            else if(html.status == 422) {
                                hideLoadingOverlay();
                                $('#fnl_btn').html('Confirm');
                                $('.confirm-button').removeAttr('disabled');
                                Swal.fire({
                                    text: html.message
                                });
                            }
                            else if (html.status == 500) {
                                $('#success_icon').html('');
                                $('#fail_icon').html(`<img src="{{asset('frontend_assets/images/circle-close.svg')}}"`);
                                $('#booking_res_h4').html(html.message);
                                hideLoadingOverlay();
                            }
                        },
                        error: function (xhr){
                            if(xhr.status == 422){
                                hideLoadingOverlay();
                                $('#fnl_btn').html('Confirm');
                                $('.confirm-button').removeAttr('disabled');
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function (key, value){
                                    Swal.fire({
                                        text: value[0]
                                    });
                                });
                            }
                        }
                    });
                });
            });
        };

        // Function to show loading overlay
        function showLoadingOverlay() {
            $('#loadingOverlay').fadeIn(300);
            $('body').addClass('loading-active');
        }
        
        // Function to hide loading overlay
        function hideLoadingOverlay() {
            $('#loadingOverlay').fadeOut(300);
            $('body').removeClass('loading-active');
        }
    </script>
 @endif 
{{-- @endauth --}}

{{-- Medical Form Related Script --}}
{{-- {{ die('=> '.Session::get('fom_otp_verified')) }} --}}
@if(Route::currentRouteName() === 'medical_form')
<script>
    $(document).ready(function (){
        let otpVerified = "{{ $otp_verified }}";
        if(otpVerified != 1){
            Swal.fire({
                title: 'OTP Verification',
                html: `<input type="text" id="otp" class="swal2-input" placeholder="Enter OTP">`,
                confirmButtonText: 'Verify',
                allowOutsideClick:false,
                backdrop: 'rgb(0,0,0)',
                preConfirm: () => {

                    let otp = $('#otp').val();

                    return $.ajax({
                        url: "{{ route('verify.otp') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            otp: otp,
                            otp_email: "{{ Session::get('fom_otp_email') }}"
                        }
                    }).then(function(response){

                        if(response.status == true){
                            return true;
                        }else{
                            Swal.showValidationMessage('Invalid OTP');
                        }

                    });

                }
            }).then((result) => {
                if(result.isConfirmed){
                    Swal.fire("Verified!", "You can now fill the form", "success");
                }
            });
        }
    });

    $('#frmMedicalForm').on('submit', function (e){
        let flag = true;
        let f_name = $('#first_name').val();
        let l_name = $('#last_name').val();
        let dob_y = $('#dob_y').val();
        let dob_m = $('#dob_m').val();
        let dob_d = $('#dob_d').val();
        let gender = $('#gender').val();
        let email = $("#email").val();
        let address = $('#address').val();
        let city = $('#city').val();
        let province = $('#province').val();
        let postal_code = $('#postal_code').val();
        let primary_phone = $('#primary_phone').val();
        let other_phone = $('#other_phone').val();
        let emrg_contact_name = $('#emergency_contact_name').val();
        let emrg_contact_phone = $('#emergency_contact_phone').val();
        let extd_health_care_benefit = $('input[name="extended_health_care_benefit"]:checked').length;

        const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;
        
        $('#f_error, #l_error, #dob_error, #gender_error, #email_error, #address_error, #city_error, #province_error, #pincod_error, #priph_error, #other_phone_error, #emrcontnm_error, #emer_cont_error, #exthlthcar_error').html('');
        if(f_name === "") {
            $('#f_error').html('Please enter First Name');
            $('#first_name').focus();
            flag = false;
        }

        if(l_name === "") {
            $('#l_error').html('Please enter Last Name');
            $('#last_name').focus();
            flag = false;
        }
        if(dob_y === "" || dob_m === "" || dob_d === "") {
            $('#dob_error').html('Please enter valid Date of Birth');
            if(dob_y.length == 0 && dob_m.length == 0 && dob_d.length == 0) {
                $('#dob_y').focus();
            }
            else {
                (dob_y.length == 0) ? $('#dob_y').focus():'';
                (dob_m.length == 0) ? $('#dob_m').focus():'';
                (dob_d.length == 0) ? $('#dob_d').focus():'';
            }
            flag = false;
            return false;
        }
        if(gender === "") {
            $('#gender_error').html('Please select Gender');
            $('#gender').focus();
            flag = false;
            return false;
        }
        if(email === ""){
            $('#email_error').html('Please enter email');
            $('#email').focus();
            flag = false;
            return false;
        }
        else if(!isValidEmail(email)) {
            $("#email_error").text("Enter valid email");
            $('#email').focus();
            flag = false;
            return false;
        }
        if(address === "") {
            $('#address_error').html('Please enter the address');
            $('#address').focus();
            flag = false;
            return false;
        }
        if(city === "") {
            $('#city_error').html('Please enter city');
            $('#city').focus();
            flag = false;
            return false;
        }
        if(province === "") {
            $('#province_error').html('Please select Province');
            $('#province').focus();
            flag = false;
            return false;
        }
        if(postal_code == ""){
            $('#pincod_error').html('Please enter Postal Code');
            $('#postal_code').focus();
            flag = false;
            return false;
        }
        if(primary_phone === '') {
            $('#priph_error').html('Please enter Primary Phone');
            $('#primary_phone').focus();
            flag = false;
            return false;
        }
        else if(!mobileRegex.test(primary_phone)){
            $('#priph_error').html('Please enter 10 digit valid Primary Phone');
            $('#primary_phone').focus();
            flag = false;
            return false;
        }
        if(other_phone!= '' && !mobileRegex.test(other_phone)) {
            $('#other_phone_error').html('Please enter 10 digit valid Other Phone');
            $('#other_phone').focus();
            flag = false;
            return false;
        }
        if(emrg_contact_name === ""){
            $('#emrcontnm_error').html('Please enter Emergency Contact Name');
            $('#emergency_contact_name').focus();
            flag = false;
            return false;
        }
        if(emrg_contact_phone === "") {
            $('#emer_cont_error').html('Please enter Emergency Contact Phone');
            $('#emergency_contact_phone').focus();
            flag = false;
            return false;
        }
        if(!mobileRegex.test(emrg_contact_phone)) {
            $('#emer_cont_error').html('Please enter 10 digit valid Emergency Contact Phone');
            $('#emergency_contact_phone').focus();
            flag = false;
            return false;
        }
        if(extd_health_care_benefit == 0) {
            $('#exthlthcar_error').html('Please select extended healthcare benifit');
            $('input[name="extended_health_care_benefit"]').focus();
            flag = false;
            return false;
        }
        console.log(extd_health_care_benefit);

        if(!flag) {
            e.preventDefault();
        }
    });

    $('#frmMedicalForm_2').on('submit', function(e){
        let flag = true;
        let hlth_befit_comp = $('#health_benefit_company').val();
        let is_pri_mem = $('input[name="is_primary_member"]:checked').length;
        let pmname = $('#pmname').val();
        let pm_dob_y = $('#pm_dob_y').val();
        let pm_dob_m = $('#pm_dob_m').val();
        let pm_dob_d = $('#pm_dob_d').val();
        let contract_policy_plan_no = $('#contract_policy_plan_no').val();
        let memb_certifi_no = $('#member_certificate_no').val();
        let auth_us_direct_bill = $('input[name="authorize_us_to_direct_bill"]:checked').length;
        let sec_insu_cover = $('input[name="second_insurance_coverage"]:checked').length;
        let second_insu_comp_name = $('#second_insu_comp_name').val();
        let primary_member_name_2 = $('#primary_member_name_2').val();
        let pm2_dob_y = $('#pm2_dob_y').val();
        let pm2_dob_m = $('#pm2_dob_m').val();
        let pm2_dob_d = $('#pm2_dob_d').val();
        let contract_policy_plan_no_2 = $('#contract_policy_plan_no_2').val();
        let member_certificate_no_2 = $('#member_certificate_no_2').val();
        $('#hlth_befit_comp_error, #is_pri_mem_error, #pmname_error, #pm_dob_error, #contra_poli_pln_error, #mem_certi_error, #auth_us_dir_bil_error, #secnd_insu_cover_error, #secnd_insu_comp_error, #primem2_error, #pm2dob_error, #contr_polcyno2_error, #mem_certino_error').html('');
        
        if(hlth_befit_comp === "") {
            $('#hlth_befit_comp_error').html('Please enter the Health Benefit Company Name');
            $('#health_benefit_company').focus();
            flag = false;
            return false;
        }
        if(is_pri_mem == 0) {
            $('#is_pri_mem_error').html('Please select the Primary Member Option');
            $('input[name="is_primary_member"]').focus();
            flag = false;
            return false;
        }
        if($("input[name=is_primary_member]:checked").val() == 'No' && pmname === "") {
            $('#pmname_error').html('Please enter the Primary member name');
            $('#pmname').focus();
            flag = false;
            return false;
        }
        if($("input[name=is_primary_member]:checked").val() == 'No' && pm_dob_y === "") {
            $('#pm_dob_error').html('Please select Date of Birth');
            $('#pm_dob_y').focus();
            flag = false;
            return false;
        }
        if($("input[name=is_primary_member]:checked").val() == 'No' && pm_dob_m === "") {
            $('#pm_dob_error').html('Please select Date of Birth');
            $('#pm_dob_m').focus();
            flag = false;
            return false;
        }
        if($("input[name=is_primary_member]:checked").val() == 'No' && pm_dob_d === "") {
            $('#pm_dob_error').html('Please select Date of Birth');
            $('#pm_dob_d').focus();
            flag = false;
            return false;
        }
        if(contract_policy_plan_no == "") {
            $('#contra_poli_pln_error').html('Policy or plan number is required for extended health coverage.');
            $('#contract_policy_plan_no').focus();
            flag = false;
            return false;
        }
        if(memb_certifi_no === "") {
            $('#mem_certi_error').html('Member certificate number is required for extended health coverage.');
            $('#member_certificate_no').focus();
            flag = false;
            return false;
        }
        if(auth_us_direct_bill === 0) {
            $('#auth_us_dir_bil_error').html('Please indicate if the clinic can directly bill your insurance');
            $('input[name="authorize_us_to_direct_bill"]').focus();
            flag = false;
            return false;
        }
        if(sec_insu_cover === 0) {
            $('#secnd_insu_cover_error').html('Please choose Second insurance coverage option.');
            $('input[name="second_insurance_coverage"]').focus();
            flag = false;
            return false;
        }
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes' && second_insu_comp_name === "") {
            $('#secnd_insu_comp_error').html('Please enter Insurance company name');
            $('#second_insu_comp_name').focus();
            flag = false;
            return false;
        }
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes' && primary_member_name_2 === "") {
            $('#primem2_error').html('Please enter the primary member name');
            $('#primary_member_name_2').focus();
            flag = false;
            return false;
        }
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes' && pm2_dob_y === "") {
            $('#pm2dob_error').html('Please select Date of Birth');
            $('#pm2_dob_y').focus();
            flag = false;
            return false;
        }
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes' && pm2_dob_m === "") {
            $('#pm2dob_error').html('Please select Date of Birth');
            $('#pm2_dob_m').focus();
            flag = false;
            return false;
        }
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes' && pm2_dob_d === "") {
            $('#pm2dob_error').html('Please select Date of Birth');
            $('#pm2_dob_d').focus();
            flag = false;
            return false;
        }
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes' && contract_policy_plan_no_2 === "") {
            $('#contr_polcyno2_error').html('Please enter second policy plan no');
            $('#contract_policy_plan_no_2').focus();
            flag = false;
            return false;
        }
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes' && member_certificate_no_2 === "") {
            $('#mem_certino_error').html('Please enter member certificate no');
            $('#member_certificate_no_2').focus();
            flag = false;
            return false;
        }

        if(!flag){
            e.preventDefault();
        }

    });

    $('#frmMedicalForm_3').on('submit', function(e){
        flag = true;
        let v_accident_or_injured = $('input[name="v_accident_or_injured"]:checked').val();
        let all_pertinent_infomation = $('#all_pertinent_infomation').val();
        let primary_complaint = $('#primary_complaint').val();
        let refer_by_practitioner = $("input[name='refer_by_practitioner']:checked").length;
        let health_cre_profess_name = $("input[name='health_cre_profess_name']").val();
        let family_doc_addrs = $('#family_doc_addrs').val();
        let received_massage_before = $('input[name="received_massage_before"]:checked').length;
        let rece_treat_frm_ano = $('input[name="received_treatment_from_another"]:checked').length;
        let if_yes_treatment_type = $('#if_yes_treatment_type').val();
        let any_allergies = $('input[name="any_allergies"]:checked').length;
        let allergy_lst = $('#allergy_lst').val();
        let internal_pin_wire_joint = $('input[name="internal_pin_wire_joint"]:checked').length;
        let joint_or_pin_text = $('#joint_or_pin_text').val();

        $('#all_pertiinfo_error, #primary_complaint_error, #referbypracti_error, #hlth_carprofesnm_error, #famdocaddr_error, #recmassbefo_error, #receive_treat_frm_ano_error, #ifyestreattyp_error, #anyallerg_error, #allergylst_error, #inter_pin_wir_jon_error, #jot_pin_txt_error').html('');

        if(v_accident_or_injured == 'Yes' && all_pertinent_infomation === "") {
            $('#all_pertiinfo_error').html('Please provide details related to the accident or injury.');
            $('#all_pertinent_infomation').focus();
            flag = false;
            return false;
        }
        if(primary_complaint === "") {
            $('#primary_complaint_error').html('Please enter the primary reason.');
            $('#primary_complaint').focus();
            flag = false;
            return false;
        }
        if(refer_by_practitioner == 0) {
            $('#referbypracti_error').html('Please choose option');
            $("input[name='refer_by_practitioner']").focus();
            flag = false;
            return false;
        }
        if(health_cre_profess_name == "") {
            $('#hlth_carprofesnm_error').html('Please enter the Healthcare Professional Name');
            $("input[name='health_cre_profess_name']").focus();
            flag = false;
            return false;
        }
        if(family_doc_addrs === "") {
            $('#famdocaddr_error').html('Enter the practioner phone or address city or clinic name');
            $('#family_doc_addrs').focus();
            flag = false;
            return false;
        }
        if(received_massage_before === 0) {
            $('#recmassbefo_error').html('Please choose the option');
            $('input[name="received_massage_before"]').focus();
            flag = false;
            return false;
        }
        if(rece_treat_frm_ano === 0) {
            $('#receive_treat_frm_ano_error').html('Please choose option.');
            $('input[name="received_treatment_from_another"]').focus();
            flag = false;
            return false;
        }
        if($('input[name="received_treatment_from_another"]:checked').val() == 'Yes' && if_yes_treatment_type === "") {
            $('#ifyestreattyp_error').html('Please provide type of treatment.');
            $('#if_yes_treatment_type').focus();
            flag = false;
            return false;
        }
        if(any_allergies === 0) {
            $('#anyallerg_error').html('Please choose option');
            $('input[name="any_allergies"]').focus();
            flag = false;
            return false;
        }
        if($('input[name="any_allergies"]:checked').val() == 'Yes' && allergy_lst === "") {
            $('#allergylst_error').html('');
            $('#allergy_lst').focus();
            flag = false;
            return false;
        }
        if(internal_pin_wire_joint === 0) {
            $('#inter_pin_wir_jon_error').html('Please choose the option.');
            $('input[name="internal_pin_wire_joint"]').focus();
            flag = false;
            return false;
        }
        if($('input[name="internal_pin_wire_joint"]:checked').val() == 'Yes' && joint_or_pin_text === "") {
            $('#jot_pin_txt_error').html('Please enter the text');
            $('#joint_or_pin_text').focus();
            flag = false;
            return false;
        }
        
        if(!flag) {
            e.preventDefault();
        }
    });

    $('#frmMedicalForm_4').on('submit', function(e) {
        flag = true;
        let acknowlege = $('input[name="acknowlege"]:checked').length;
        let acknowlegeName = $('#acknowlegeName').val();
        let choose_date = $('#choose_date').val();
        let acknowlege_2 = $('input[name="acknowlege_2"]:checked').length;

        $('#acknowlege_error, #sig_error, #acknm_error, #chose_dt_error, #acknoleg_2_error').html('');
        
        if(acknowlege === 0) {
            $('#acknowlege_error').html('Please acknowledge');
            $('input[name="acknowlege"]').focus();
            flag = false;
            return false;
        }

        if(acknowlegeName === "") {
            $('#acknm_error').html('Please enter the full name');
            $('#acknowlegeName').focus();
            flag = false;
            return false;
        }
        if(choose_date === ""){
            $('#chose_dt_error').html('Please choose the date');
            $('#choose_date').focus();
            flag = false;
            return true;
        }
        if(acknowlege_2 === 0) {
            $('#acknoleg_2_error').html('Please acknowledge');
            $('input[name="acknowlege_2"]').focus();
            flag = false;
            return false;
        }


        if(!flag) {
            e.preventDefault();
        }
    })

    function isValidEmail(email) {
        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    const setDaysCount = (month, dtEle, yrEle) => {
        let yr = new Date().getFullYear();
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        if(month == 2) {
            if(document.getElementById(yrEle).value == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select year first!'
                });
                return false;
            }
            else {
                yr = document.getElementById(yrEle).value;
            }
        }
        
        const days = getDaysInMonth(month, yr);
        const days_dropdown = document.getElementById(dtEle);
        days_dropdown.innerHTML = ``;
        days_dropdown.innerHTML = `<option value=''>Date</option>`;
        for(let day = 1; day <= days; day++) {
            const option = document.createElement('option');
            const dayFormatted = String(day).padStart(2, '0');
            option.value = dayFormatted;
            option.textContent = dayFormatted;
            days_dropdown.appendChild(option);
        }
    };
    const getDaysInMonth = (month, year) => {
        return new Date(year, month, 0).getDate();
    };
    
    /*$('input[name="primary_phone"]').on('blur', function (){
        const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;
        if ($('input[name="primary_phone"]').val() != '' && !mobileRegex.test($('input[name="primary_phone"]').val())) {
            $('#primary_phone_error').html('Please enter a valid phone number');
            return false;
        }
        else {
            $('#primary_phone_error').html('');
            return true;
        }
    });

    $('input[name="other_phone"]').on('blur', function (){
        const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;
        if ($('input[name="other_phone"]').val() != '' && !mobileRegex.test($('input[name="other_phone"]').val())) {
            $('#other_phone_error').html('Please enter a valid phone number');
            return false;
        }
        else {
            $('#other_phone_error').html('');
            return true;
        }
    });

    $('input[name="emergency_contact_phone"]').on('blur', function (){
        const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;
        if ($('input[name="emergency_contact_phone"]').val() != '' && !mobileRegex.test($('input[name="emergency_contact_phone"]').val())) {
            $('#emer_cont_error').html('Please enter a valid phone number');
            return false;
        }
        else {
            $('#emer_cont_error').html('');
            return true;
        }
    });*/

    $('input[name=extended_health_care_benefit]').change(function (){
        if($("input[name='extended_health_care_benefit']:checked").val() == 'Yes')
        {
            $('#exhlthcarbene_1, #exhlthcarbene_2, #exhlthcarbene_3, #exhlthcarbene_4').show();
                $('input[name=is_primary_member]').attr('required', true);
                if($('input[name=is_primary_member]').is(':checked') && $("input[name=is_primary_member]:checked").val() == 'No')
                {
                    $('#pm_1, #pm_2').show();
                    $('#pmname').attr('required', true);
                    $('#pm_dob_y').attr('required', true);
                    $('#pm_dob_m').attr('required', true);
                    $('#pm_dob_d').attr('required', true);
                }
                else
                {
                    $('#pm_1,#pm_2').hide();
                    $('#pmname').removeAttr('required');
                    $('#pm_dob_y').removeAttr('required');
                    $('#pm_dob_m').removeAttr('required');
                    $('#pm_dob_d').removeAttr('required');
                }
                
            $('#health_benefit_company').attr('required',true);
            $('input[name=contract_policy_plan_no]').attr('required', true);
            $('input[name=member_certificate_no]').attr('required', true);
            $('input[name=authorize_us_to_direct_bill]').attr('required', true);
            $('input[name=second_insurance_coverage]').attr('required', true);
            
            $('#direct_bill_div, #second_insu_div').show();
            $('#bicn, #cpp, #memcer, #direct_bill_spn, #seconinsu_spn').css('color','#FF0000');
            $('#bicn, #cpp, #memcer, #direct_bill_spn, #seconinsu_spn').html('*');
        }
        else
        {
            $('#exhlthcarbene_1, #exhlthcarbene_2, #exhlthcarbene_3, #exhlthcarbene_4').hide();
            
                $('#pm_1,#pm_2').hide();
                $('input[name=is_primary_member]').removeAttr('required');
                $('#pmname').removeAttr('required');
                $('#pm_dob_y').removeAttr('required');
                $('#pm_dob_m').removeAttr('required');
                $('#pm_dob_d').removeAttr('required');
                
            
            $('input[name=health_benefit_company]').removeAttr('required');
            $('input[name=contract_policy_plan_no]').removeAttr('required');
            $('input[name=member_certificate_no]').removeAttr('required');
            $('input[name=authorize_us_to_direct_bill]').removeAttr('required');
            $('input[name=second_insurance_coverage]').removeAttr('required');
            
            $('#direct_bill_div, #second_insu_div').hide();
            $('#bicn, #cpp, #memcer, #direct_bill_spn, #seconinsu_spn').css('color','#FF0000');
            $('#bicn, #cpp, #memcer, #direct_bill_spn, #seconinsu_spn').html('');
        }
    });

    $('input[name=is_primary_member]').change(function (){
        if($("input[name=is_primary_member]:checked").val() == 'No')
        {
            $('#pm_1,#pm_2').show();
            // $('#pmname').attr('required', true);
            // $('#pm_dob_y').attr('required', true);
            // $('#pm_dob_m').attr('required', true);
            // $('#pm_dob_d').attr('required', true);
        }
        else
        {
            $('#pm_1,#pm_2').hide();
            // $('#pmname').removeAttr('required');
            // $('#pm_dob_y').removeAttr('required');
            // $('#pm_dob_m').removeAttr('required');
            // $('#pm_dob_d').removeAttr('required');
        }
    });

    $('input[name=second_insurance_coverage]').change(function (){
        if($("input[name=second_insurance_coverage]:checked").val() == 'Yes')
        {
            $('#sec_insu_dtl_div').addClass('d-block');
            $('#sec_insu_dtl_div').removeClass('d-none');
            // $('#primary_member_name_2').attr('required', true);
            // $('#pm2_dob_y').attr('required', true);
            // $('#pm2_dob_m').attr('required', true);
            // $('#pm2_dob_d').attr('required', true);
            // $('#second_insu_comp_name').attr('required', true);
            // $('#contract_policy_plan_no_2').attr('required', true);
            // $('#member_certificate_no_2').attr('required', true);

            $('#sec_ins_comp_span, #sec_pri_mem_span, #sec_pri_mem_dobspan, #cont_pol_plan_span, #sec_mem_certi_span').html('*');
        }
        else
        {
            $('#sec_insu_dtl_div').addClass('d-none');
            $('#sec_insu_dtl_div').removeClass('d-block');
            // $('#primary_member_name_2').removeAttr('required');
            // $('#pm2_dob_y').removeAttr('required');
            // $('#pm2_dob_m').removeAttr('required');
            // $('#pm2_dob_d').removeAttr('required');
            // $('#second_insu_comp_name').removeAttr('required');
            // $('#contract_policy_plan_no_2').removeAttr('required');
            // $('#member_certificate_no_2').removeAttr('required');
            $('#sec_ins_comp_span, #sec_pri_mem_span, #sec_pri_mem_dobspan, #cont_pol_plan_span, #sec_mem_certi_span').html('');
        }
    });

    $('input[name=v_accident_or_injured]').change(function (){
        if($("input[name=v_accident_or_injured]:checked").val() == 'Yes')
        {
            // $('#all_pertinent_infomation').attr('required', true);
            $('#aperinfo').html('*');
        }
        else
        {
            // $('#all_pertinent_infomation').removeAttr('required');
            $('#aperinfo').html('');
        }
    });

    $('input[name=received_treatment_from_another]').change(function (){
        if($("input[name=received_treatment_from_another]:checked").val() == 'Yes'){
            // $('#if_yes_treatment_type').attr('required', true);
            $('#if_yes_teat_span').html('*');
        }
        else {
            // $('#if_yes_treatment_type').removeAttr('required');
            $('#if_yes_teat_span').html('');
        }
    });

    $('input[name=any_allergies]').change(function (){
        if($('input[name=any_allergies]:checked').val() == 'Yes') {
            $('#all_aller_lst').html('*');
            // $('#allergy_lst').attr('required', true);
        }
        else {
            $('#all_aller_lst').html('');
            // $('#allergy_lst').removeAttr('required');
        }
    });

    $('input[name=internal_pin_wire_joint]').change(function (){
        if($('input[name=internal_pin_wire_joint]:checked').val() == 'Yes') {
            $('#jonpin_span').html('*');
            // $('#joint_or_pin_text').attr('required', true);
        }
        else {
            $('#jonpin_span').html('');
            // $('#joint_or_pin_text').removeAttr('required');
        }
    });
    
    $('input[name=pregnant]').change(function (){
        if($("input[name=pregnant]:checked").val() == 'Yes') {
            $('#due_dt_lbl').removeClass('d-none');
            $('#pregnant_due_date').removeClass('d-none');
        }
        else {
            $('#due_dt_lbl').addClass('d-none');
            $('#pregnant_due_date').addClass('d-none');
            $('#pregnant_due_date').val('');
        }
    });
</script>
@endif
    {{-- SweetAlert2 Error Message --}}
    {{-- Custom Script --}}
@if(Route::currentRouteName() === 'gallery')
<script>
    const galleryImages = document.querySelectorAll('.gallery-grid img');
    const popup = document.getElementById('galleryPopup');
    const popupImg = document.querySelector('.popup-img');
    const closePopup = document.querySelector('.close-popup');

    galleryImages.forEach(img => {
        img.addEventListener('click', () => {
            popup.style.display = 'flex';
            popupImg.src = img.src;
        });
    });

    closePopup.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    popup.addEventListener('click', (e) => {
        if (e.target !== popupImg) {
            popup.style.display = 'none';
        }
    });
</script>    
@endif

<script>
    if(document.getElementById('frmContact')) {
        // Check email for new user. if new email then send OTP to verify.
        $('#contact_email').on('blur', function () {
            let emailField = $(this);
            let email = emailField.val().trim();
            if (email === '') return;

            $.ajax({
                url: '{{ route("send.contact.otp") }}',
                type: 'POST',
                data: { email: email },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // Prevent multiple requests
                    emailField.prop('readonly', true);

                    // Optional loader
                    Swal.fire({
                        title: 'Checking email...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function (res) {
                    // Email exists → allow form
                    // Show email → OTP modal
                    if (res.status === true) {
                        Swal.close();
                        openContactOtpModal(email);
                    }
                }
            });
        });

        function openContactOtpModal(email) {
            Swal.fire({
                title: 'Verify Email',
                html: `
                    <p class="mb-2">
                        OTP sent to <strong>${email}</strong>
                    </p>

                    <input type="text"
                        id="otp_input"
                        class="swal2-input"
                        placeholder="Enter 6-digit OTP"
                        maxlength="6"
                        autocomplete="off">

                    <p class="mt-2">
                        <a href="javascript:void(0)" id="changeEmailLink" style="font-size:14px;">
                            Wrong Email ID? Click here to change
                        </a>
                    </p>
                `,
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: true,
                confirmButtonText: 'Verify OTP',
                preConfirm: () => {
                    let otp = Swal.getPopup().querySelector('#otp_input').value;

                    if (!otp) {
                        Swal.showValidationMessage('OTP is required');
                        return false;
                    }
                    if (otp.length !== 6) {
                        Swal.showValidationMessage('Please enter a valid 6-digit OTP');
                        return false;
                    }
                    return verifyContactOtp(otp);
                },
                didOpen: () => {
                    const popup = Swal.getPopup();
                    const changeEmailLink = popup.querySelector('#changeEmailLink');

                    changeEmailLink.addEventListener('click', function () {

                        Swal.close();

                        // Reset OTP input
                        $('#otp_input').val('');

                        // Enable & reset email field
                        const emailField = $('#contact_email');
                        emailField.prop('readonly', false);
                        emailField.val('');
                        emailField.focus();
                    });
                }
            });
        }

        function verifyContactOtp (otp) {
            return $.ajax({
                url: '{{ route("verify.contact.otp") }}',
                type: 'POST',
                data: { otp: otp },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(function (res) {

                if (!res.status) {
                    Swal.showValidationMessage(res.message);
                    return false;
                }

                Swal.fire({
                    icon: 'success',
                    title: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }

        document.getElementById('frmContact').addEventListener('submit', function(e) {
            e.preventDefault();
            if ($('input[name="first_name"]').val() == '') {
                $('.error-f_nm').html(`Please enter First Name`);
                return false;
            }
            else{
                $('.error-f_nm').html(``);
            }
            if ($('input[name="last_name"]').val() == '') {
                $('.error-l_nm').html(`Please enter Last Name`);
                return false;
            }
            else{
                $('.error-l_nm').html(``);
            }
            if ($('input[name="email"]').val() == '') {
                $('.error-email').html(`Please enter Email`);
                return false;
            }
            else {
                $('.error-email').html(``);
            }
            if ($('input[name="mobile"]').val() == '') {
                $('.error-mob').html(`Please enter Mobile Number`);
                return false;
            }
            else {
                $('.error-mob').html(``);
            }
            if ($('input[name="message"]').val() == '') {
                $('.error-msg').html(`Please enter Your Message`);
                return false;
            }
            else {
                $('.error-msg').html(``);
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            // console.log(formData);
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('app.google_captcha.sitekey') }}', {action: 'submit'}).then(function(token) { 
                let formData = {
                    first_name: $('input[name="first_name"]').val(),
                    last_name: $('input[name="last_name"]').val(),
                    email: $('input[name="email"]').val(),
                    mobile: $('input[name="mobile"]').val(),
                    message: $('textarea[name="message"]').val(),
                    token: token
                }
                $.ajax({
                    type: 'POST',
                    url: '{{route("send.contact.mail")}}',
                    data: formData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnContact').hide();
                        $("#loader").removeClass('d-none');
                    },
                    success: function(html) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        if (html.status == true) {
                            $('#btnContact').show();
                            $("#loader").addClass('d-none');
                            
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $(`.error-${key}`).text(value[0]);
                            });
                            $('#btnContact').show();
                            $("#loader").addClass('d-none');
                        }
                        else if(xhr.status == 500) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            Toast.fire({
                                icon: 'error',
                                title: xhr.responseJSON.message
                            });
                            $('#btnContact').show();
                            $("#loader").addClass('d-none');
                        }
                    }
                }); 
                });
            });
        });
    }
</script>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('app.google_captcha.sitekey') }}"></script>