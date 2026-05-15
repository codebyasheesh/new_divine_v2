    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- begin::Third Party Plugin(OverlayScrollbars) --}}
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
    {{-- end::Third Party Plugin(OverlayScrollbars)--}}
    {{--begin::Required Plugin(popperjs for Bootstrap 5) --}}
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    {{-- end::Required Plugin(popperjs for Bootstrap 5)--}}
    {{--begin::Required Plugin(Bootstrap 5) --}}
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    {{-- end::Required Plugin(Bootstrap 5)--}}
    {{--begin::Required Plugin(AdminLTE) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('admin_assets/js/adminlte.js') }}"></script>
    
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script src="{{asset('admin_assets/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.19/index.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
    @if(Route::currentRouteName() === 'admin.add.email.template' || Route::currentRouteName() === 'admin.edit.email.template')
    <script src="{{asset('tinymce/tinymce.min.js')}}"></script>
    <script>
        tinymce.init({
            selector: '#body',
            license_key: 'gpl',
            height: 400,
            width: 1000,
            menubar: true,
            plugins: 'lists link table code',
            toolbar: 'undo redo | placeholders | bold italic underline | bullist numlist | link table | code'
        });

        $('#template_name').on('blur', function (){
            let tempname = $('#template_name').val();
            if(tempname.length > 0) {
                let formattedName = tempname.trim().toLowerCase().replace(/\s+/g, '_');
                $('input[name="template_key"]').val(formattedName);
            }
        });
    </script>
    @endif

    {{-- Custom Styles for Slot Selection --}}
    <style>
        .selected_green {
            background-color: green !important;
            color: white !important;
        }
    </style>

    {{-- end::Required Plugin(AdminLTE)--}}
    {{--begin::OverlayScrollbars Configure --}}
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    {{-- Tooltip Script --}}
    {{--begin::Bootstrap Tooltips--}}
    <script>
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggletip="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl),
      );
    </script>
    {{-- Tooltip Script End --}}
    {{-- end::OverlayScrollbars Configure --}}
    {{-- OPTIONAL SCRIPTS  --}}
    {{-- sortablejs  --}}
     @if(Session::has('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        Toast.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ Session::get("success") }}',
        });
    </script>
    @elseif(Session::has('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        Toast.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ Session::get("error") }}',
        });
    </script>
    @endif
    {{-- Full Calendar Initilizing --}}
    @if(Route::currentRouteName() == 'admin.dashboard') 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                height: 650,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: "{{ route('admin.event.list') }}", // fetch from controller
                displayEventTime: false,
                // Click on an empty date to make new booking
                dateClick: function(info) {
                    // Check if day contains a holiday event
                    let events = calendar.getEvents().filter(e =>
                        e.display === 'background' &&
                        info.date >= e.start && 
                        info.date < e.end
                    );

                    if (events.length > 0) {
                        Swal.fire("Holiday!", "You cannot book an appointment on holiday.", "warning");
                        return false;
                    }
                    // console.log(clickedDate); return false;
                    let addurl = '{{ route("admin.add.appointment") }}';
                    window.location.href = addurl;
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                },
                eventDidMount: function(info) {
                    // replace \n with <br> inside event
                    let titleEl = info.el.querySelector('.fc-event-title');
                    if (titleEl) {
                        titleEl.innerHTML = info.event.title.replace(/,/g, '<br>');
                    }

                    // Create tooltip content
                    let tooltip = document.createElement('div');
                    tooltip.classList.add('fc-tooltip');
                    tooltip.style.position = 'absolute';
                    tooltip.style.zIndex = '10001';
                    tooltip.style.background = 'rgba(0,0,0,0.8)';
                    tooltip.style.color = '#fff';
                    tooltip.style.padding = '6px 10px';
                    tooltip.style.borderRadius = '5px';
                    tooltip.style.fontSize = '12px';
                    tooltip.style.display = 'none';

                    // Extract booking details from event
                    const titleParts = info.event.title.split(',');
                    const statusText = titleParts.length > 1 ? titleParts[1].trim() : '';

                    tooltip.innerHTML = `
                        <strong>${info.event.title.split("\n")[0]}</strong><br>
                        <small>${statusText}</small>
                    `;
                    document.body.appendChild(tooltip);

                    // Show tooltip on hover
                    info.el.addEventListener('mouseenter', function(e) {
                        tooltip.style.display = 'block';
                        tooltip.style.top = (e.pageY + 10) + 'px';
                        tooltip.style.left = (e.pageX + 10) + 'px';
                    });

                    info.el.addEventListener('mousemove', function(e) {
                        tooltip.style.top = (e.pageY + 10) + 'px';
                        tooltip.style.left = (e.pageX + 10) + 'px';
                    });

                    info.el.addEventListener('mouseleave', function() {
                        tooltip.style.display = 'none';
                    });
                }
            });

            calendar.render();
        });
    </script>
    @endif
    {{-- End Full calendar Initilizing --}}

    @if(Route::currentRouteName() == 'admin.blockSchedules')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            // Create tooltip element
            var tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.style.position = 'absolute';
            tooltip.style.background = 'rgba(0,0,0,0.8)';
            tooltip.style.color = 'white';
            tooltip.style.padding = '5px 10px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.zIndex = '1000';
            tooltip.style.display = 'none';
            document.body.appendChild(tooltip);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                navLinks: true,
                nowIndicator: true,
                allDaySlot: true,
                eventDisplay: 'block',
                eventOverlap: false,
                events: {
                    url: '{{ route("admin.schedule.fullcalendar") }}',
                    method: 'GET',
                    failure: function() {
                        console.error('Unable to fetch schedule events.');
                    }
                },
                eventMouseEnter: function(info) {
                    console.log(info);
                    let tooltipText = '';
                    if (info.event.title === 'Lunch Time') {
                        tooltipText = `Lunch Time`;
                    } else if (info.event.title === 'Partial Block') {
                        tooltipText = 'Block Time';
                        if (info.event.extendedProps.is_lunch) {
                            tooltipText += ' (Lunch Time)';
                        }
                    } else if (info.event.title === 'Full Day Block') {
                        tooltipText = 'Block Time';
                    }
                    if (tooltipText) {
                        tooltip.innerHTML = tooltipText;
                        tooltip.style.display = 'block';
                        tooltip.style.top = (info.jsEvent.pageY + 10) + 'px';
                        tooltip.style.left = (info.jsEvent.pageX + 10) + 'px';
                    }
                },
                eventMouseLeave: function() {
                    tooltip.style.display = 'none';
                },
                eventDidMount: function(info) {
                    if (info.event.extendedProps.className === 'blocked-full') {
                        info.el.style.opacity = '0.9';
                    }
                },
                eventContent: function(arg) {
                    return { html: '<div class="fc-event-title">' + arg.event.title + '</div>' };
                }
            });

            calendar.render();
        });
    </script>
    @endif
            
    @if(Route::currentRouteName() == 'admin.block_date_time') 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route("admin.calendar_dates") }}',

                // If user clicks on event (date with blocked slots)
                eventClick: function(info) {
                    let blockedSlots = info.event.extendedProps.blocked_slots;
                    let openSlots    = info.event.extendedProps.open_slots;
                    let day_type     = info.event.extendedProps.day_type;
                    let date         = info.event.startStr;

                    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    const d = new Date(date + 'T00:00:00');
                    let month = months[d.getMonth()];
                    
                    const display_dt = `${month} ${d.getDate()}, ${d.getFullYear()}`;    
                    if(day_type == null) {
                        if (blockedSlots.length > 0) {
                            // Build checkbox list for blocked slots
                            let checkboxes = blockedSlots.map(slot => 
                                `<div>
                                    <input type="checkbox" name="slots[]" value="${slot}" id="slot_${slot}">
                                    <label for="slot_${slot}">${slot}</label>
                                </div>`
                            ).join("");

                            Swal.fire({
                                title: `<font class="text-danger">Blocked Slots</font> on ${display_dt}`,
                                html: `
                                    <form id="unblockForm">
                                        ${checkboxes}
                                    </form>
                                `,
                                showCancelButton: true,
                                confirmButtonText: 'Unblock Selected'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    let selected = [];
                                    document.querySelectorAll('#unblockForm input[name="slots[]"]:checked').forEach(el => {
                                        selected.push(el.value);
                                    });

                                    if (selected.length > 0) {
                                        // Send AJAX request to unblock
                                        fetch("{{ route('admin.unblock.datesof.time') }}", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                            },
                                            body: JSON.stringify({
                                                date: date,
                                                slots: selected
                                            })
                                        }).then(res => res.json())
                                        .then(resp => {
                                            Swal.fire('Updated!', resp.message, 'success');
                                            calendar.refetchEvents();
                                        });
                                    }
                                }
                            });
                        } else {
                            Swal.fire('No blocked slots', 'All slots are available', 'info');
                        }
                    }
                    else {
                        Swal.fire('Blocked Slots', `All slots are blocked due to ${day_type}`, 'info');
                    }
                    
                },

                // If user clicks a date with no event (block new slots)
                dateClick: function(info) {
                    let events = calendar.getEvents().filter(e => e.startStr === info.dateStr);
                    // Check if one of today's events is a holiday event
                    let isBlockedDate = events.some(e => e.extendedProps.is_blocked_date === true);
                    if (isBlockedDate) {
                        // disable clicking anywhere in the cell except block strip
                        return false;
                    }
                    else {
                        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        let date = info.dateStr;
                        const d = new Date(date + 'T00:00:00');
                        let month = months[d.getMonth()];
                        
                        const display_dt = `${month} ${d.getDate()}, ${d.getFullYear()}`;
                        // console.log(display_dt);

                        Swal.fire({
                            title: `Block Slots on ${display_dt}`,
                            html: `
                                <form id="blockForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="09:30am"> 09:30 AM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="10:00am"> 10:00 AM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="10:30am"> 10:30 AM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="11:00am"> 11:00 AM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="11:30am"> 11:30 AM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="12:00pm"> 12:00 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="12:30pm"> 12:30 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="01:00pm"> 01:00 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="01:30pm"> 01:30 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="02:00pm"> 02:00 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="04:00pm"> 04:00 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="04:30pm"> 04:30 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="05:00pm"> 05:00 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="05:30pm"> 05:30 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="06:00pm"> 06:00 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="06:30pm"> 06:30 PM
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="checkbox" name="slots[]" value="07:00pm"> 07:00 PM
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Block Selected'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let selected = [];
                                document.querySelectorAll('#blockForm input[name="slots[]"]:checked').forEach(el => {
                                    selected.push(el.value);
                                });

                                if (selected.length > 0) {
                                    // Send AJAX request to block
                                    fetch("{{ route('admin.save_blockdate') }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            dt: date,
                                            block_time: selected
                                        })
                                    }).then(res => res.json())
                                    .then(resp => {
                                        Swal.fire('Updated!', resp.message, 'success');
                                        calendar.refetchEvents();
                                    });
                                }
                            }
                        });
                    }
                    
                }
            });

            calendar.render();
        });
        </script>
    @endif
{{-- Date Initializing --}}
<script>
    $('#dob, #e_dob').datepicker({
        format: "M dd, yyyy",
        endDate: "yesterday",
        autoclose: true
    });

    $('#invoice_date, #booking_date').datepicker({
        format: "M dd, yyyy",
        
        autoclose: true,
        todayHighlight: true
    });

    $('#txtDate').datepicker({
        format: "M dd, yyyy",
        startDate: "today",
        autoclose: true,
        todayHighlight: true
    });

    $('#appointment_date').datepicker({
        format: "M dd, yyyy",
        autoclose: true,
        todayHighlight: true
    });

    $('.input-daterange').datepicker({
        format: "M dd, yyyy",
        autoclose: true
    });

    flatpickr("#timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K", // Example: 04:30 PM
        time_24hr: false // set to true if you prefer 24-hour format
    });
</script>
{{-- Date Initializing --}}
  
<script>
      $(document).ready(function () {
        $('#services-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('admin.servicelist') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'id', orderable: false },
                { data: 'service_name', name: 'service_name', orderable: false, responsivePriority: 1 },
                { data: 'duration', name: 'duration', orderable: false, responsivePriority: 2 },
                { data: 'price', name: 'price', orderable: false, responsivePriority: 1 },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
     });

    // Show hide duration and price div in Add service PopUP
    $('#parent_service').on('change', function (){
        if($('#parent_service').val() == '') {
            $('#duration_div').addClass('d-none');
            $('#price_div').addClass('d-none');
            $('#duration').attr('disabled', true);
            $('#price').attr('disabled', true);
            $('#tax_div').addClass('d-none');
        }
        else {
            $('#duration_div').removeClass('d-none');
            $('#price_div').removeClass('d-none');
            $('#duration').removeAttr('disabled');
            $('#price').removeAttr('disabled');
            $('#tax_div').removeClass('d-none');
        }
    });

    $('#e_parent_service').on('change', function (){
        if($('#e_parent_service').val() == '') {
            $('#dura_div').addClass('d-none');
            $('#e_price_div').addClass('d-none');
            $('#e_duration').attr('disabled', true);
            $('#e_price').attr('disabled', true);
            $('#e_tax_div').addClass('d-none');
        }
        else {
            $('#dura_div').removeClass('d-none');
            $('#e_price_div').removeClass('d-none');
            $('#e_duration').removeAttr('disabled');
            $('#e_price').removeAttr('disabled');
            $('#e_tax_div').removeClass('d-none');
        }
    });

    // Add Service By Popup
    const addServiceAction = (frm_id) => {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if ($('#service_name').val() == '') {
          $('#err_service_name').html(`Please enter Service Name`);
          return false;
      }
      $.ajax({
          type: 'POST',
          url: '{{route("admin.addservice")}}',
          data: $('form' + '#' + frm_id).serialize(),
          cache: false,
          dataType: 'json',
          beforeSend: function() {
              $('#btnLog').hide();
              $("#loader").removeClass('d-none');
          },
          success: function(html) {
            if (html.status == 201) {
                $("#addServicePop").modal('hide');
                $('#btnLog').show();
                $("#loader").addClass('d-none');
                $('#parent_service').val('');
                $('#service_name').val('');
                $('#duration').val('');
                $('#price').val('');
                $('#duration_div').addClass('d-none');
                $('#price_div').addClass('d-none');
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
                Toast.fire({
                    icon: 'success',
                    title: html.message
                });
                // $('#services-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                setTimeout(() => {
                      location.reload();
                  }, 3000);
              }
              if (html.status == 409) {
                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 5000,
                      timerProgressBar: true,
                  });
                  Toast.fire({
                      icon: 'error',
                      title: html.msg
                  });
                    $('#btnLog').show();
                    $("#loader").addClass('d-none');
                  $('#s1').append(`<div class="text-danger">${html.errors.name}</div>`);
            }
          },
          error: function (xhr) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
            if(xhr.status == 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    // err_msg += `${value[0]}<br>`;
                    $(`#err_${key}`).html(value[0]);
                });
                $('#btnLog').show();
                $("#loader").addClass('d-none');
            }
          }
      });
    };
    // Add Service End

    //  View Service detail PopUp with Data.
    const viewServiceDetail = (id) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = '{{ route("admin.show_service", ":id") }}';
        url = url.replace(':id', id);  
        $.ajax({
            type: 'GET',
            url: url,
            data: {id: id},
            cache: false,
            dataType: 'json',
            beforeSend: function() {},
            success: function(html) {
                if (html.code == '200') {
                    $('#e_parent_service').val('');
                    if(html.data.parent_id != 0)
                    {
                        $('#e_parent_service').val(html.data.parent_id);
                    }
                    $('input[name=id]').val(html.data.id);
                    $('#e_service_name').val(html.data.service_name);
                    if(html.data.parent_id == 0) {
                        $('#e_parent_service').attr('disabled', true);
                        $('#dura_div, #e_price_div, #e_tax_div').addClass('d-none');
                    }
                    else {
                        $('#e_parent_service').removeAttr('disabled');
                        $('#dura_div, #e_price_div, #e_tax_div').removeClass('d-none');
                    }
                    $('#e_duration').val(html.data.duration);
                    $('#e_price').val(html.data.price);
                    if(html.data.is_taxable == '1') {
                        $('#e_is_taxable_1').prop('checked', true);
                        $('#e_is_taxable_2').prop('checked', false);
                    }
                    else{
                        $('#e_is_taxable_2').prop('checked', true);
                        $('#e_is_taxable_1').prop('checked', false);
                    }
                }
            }
        });
    };

    // Edit the Service Detail
    const editServiceAction = (frm_id) => {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      if ($('#e_service_name').val() == '') {
          $('#error_e_service_name').html(`Please enter Service Name`);
          return false;
      }
      if ($('#e_duration').val() == '') {
          $('#error_e_duration').html(`Please enter duration`);
          return false;
      }
      if ($('#e_price').val() == '') {
          $('#error_e_price').html(`Please enter Price`);
          return false;
      }
      $.ajax({
          type: 'POST',
          url: '{{route("admin.update_service")}}',
          data: $('form' + '#' + frm_id).serialize(),
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
                  timer: 5000,
                  timerProgressBar: true,
              });
              if (html.status == 200) {
                  $("#editServicePop").modal('hide');
                  
                  Toast.fire({
                      icon: 'success',
                      title: html.message
                  });
                  $('#services-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
              }
              if (html.status == 400) {
                  Toast.fire({
                      icon: 'error',
                      title: html.message
                  });
                  $('#btnLog').show();
                  $("#loader").addClass('d-none');
                  $('#es1').append(`<div class="text-danger">${html.errors.service_name}</div>`);
                  $('#es2').append(`<div class="text-danger">${html.errors.duration}</div>`);
                  $('#es3').append(`<div class="text-danger">${html.errors.price}</div>`);
              }
              if(html.status == 404) {
                  Toast.fire({
                      icon: 'error',
                      title: html.message
                  });
                  $('#btnLog').show();
                  $("#loader").addClass('d-none');
              }
          },
          error: function(xhr){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            if(xhr.status == 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    // err_msg += `${value[0]}<br>`;
                    $(`#err_${key}`).html(value[0]);
                });
                $('#btnLog').show();
                $("#loader").addClass('d-none');
            }
          }
      });
    };

    // Edit Service Detail End
    const updateServiceStatus = (id) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '{{route("admin.service_status")}}',
            data: {id: id},
            cache: false,
            dataType: 'json',
            beforeSend: function() {
            },
            success: function(html) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
                if (html.status == true) {
                    Toast.fire({
                        icon: 'success',
                        title: html.msg
                    });
                    $('#services-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                }
                if (html.status == false) {
                    Toast.fire({
                        icon: 'error',
                        title: html.msg
                    });
                }
            },
            error: function (xhr) {
                if(xhr.status == 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        Toast.fire({
                            icon: 'error',
                            title: value[0]
                        });
                        
                    });
                }
            }
        });
    };

    const deleteService = (id) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = '{{ route("admin.deleteservice") }}';
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        });
        Swal.fire({
            title: "Please be sure",
            text: 'Do you really want to delete this Service?',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
            cancelButtonText: "No"
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {id: id},
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {},
                    success: function(html) {
                        if (html.status == true) {
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                            $('#services-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                        }
                        if(html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                        }
                        if(html.status == 'confirm') {
                            Swal.fire({
                                title: "Are you sure?",
                                text: html.message,
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Delete",
                                cancelButtonText: "Cancel"
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            type: 'get',
                                            url: '{{route("admin.services_destroy")}}',
                                            data: {
                                                id: id,
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
                                                    $('#services-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                                                }
                                            },
                                            error: function (xhr) {
                                                const error = xhr.responseJSON.message;
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error!',
                                                    text: error
                                                });
                                            }
                                        });
                                    }
                                });
                        }
                    }
                });
            }
        })
    };
    </script>

    <script>
    $(document).ready(function (){
      // Customers list
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('admin.userlist') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'id', orderable: false },
                { data: 'name', name: 'name', orderable: true, responsivePriority: 1 },
                { data: 'email', name: 'email', orderable: false, responsivePriority: 3 },
                { data: 'mobile', name: 'mobile', orderable: false, responsivePriority: 2 },
                { data: 'dob', name: 'dob', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

    // view Customer Detail in PopUp
    const viewUserDetail = (id) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = '{{ route("admin.viewuser", ":id") }}';
        url = url.replace(':id', id);  
        $.ajax({
            type: 'GET',
            url: url,
            data: {id: id},
            cache: false,
            dataType: 'json',
            beforeSend: function() {},
            success: function(html) {
                if (html.code == 200) {
                    $('input[name=e_family_id]').val(html.data.family_id);
                    $('input[name="dependent"]').val(html.data.dependent);
                    $('input[name="is_primary"]').val(html.data.is_primary);
                    $('input[name=id]').val(html.data.id);
                    $('#e_first_name').val(html.data.first_name);
                    $('#e_last_name').val(html.data.last_name);
                    $('#e_email').val(html.data.email);
                    $('#e_mobile').val(html.data.mobile);
                    // Divide DOB into 3 parts, date, month and Year
                    if(html.data.dob != null && html.data.dob != '1970-01-01') {
                        const [yr, mn, dt] = html.data.dob.split('-');
                        $('#e_bday').val(dt);
                        $('#e_bmonth').val(mn);
                        $('#e_byear').val(yr);
                    }
                    else {
                        $('#e_bday').val('');
                        $('#e_bmonth').val('');
                        $('#e_byear').val('');
                    }

                    // $('#e_dob').val(html.data.dob);
                    $('#e_city').val(html.data.city);
                    $('#e_gender').val(html.data.gender);
                    $('#e_state').val(html.data.state);
                    $('#e_postal_code').val(html.data.postal_code);
                    $('#e_address').val(html.data.address);
                    $('#e_remark').val(html.data.remark);
                }
            }
        });
    };

    // Delete Customer
    const deleteClient = (id) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = '{{ route("admin.deleteclient") }}';
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        });
        Swal.fire({
            title: "Are you sure?",
            text: 'Delete the Client',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
            cancelButtonText: "No"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {id: id},
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {},
                        success: function(html) {
                            if (html.status == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: html.message
                                });
                                $('#users-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                            }
                            if(html.status == false) {
                                Toast.fire({
                                    icon: 'error',
                                    title: html.message
                                });
                            }
                        }
                    });
                }
            });
        
    };

    // Add Service By Popup
    const addUserAction = (frm_id) => {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
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
      if ($('#email').val() == '') {
          $('.error-email').html(`Please enter Email`);
          return false;
      }
      else {
        $('.error-email').html(``);
      }
      if ($('#mobile').val() == '') {
          $('.error-mobile').html(`Please enter Mobile Number`);
          return false;
      }
      else {
        $('.error-mobile').html(``);
      }
      if($('#gender').val() == '') {
        $('.error-gender').html('Please select Gender');
        $('#gender').focus();
        return false;
      }
      else {
        $('.error-gender').html('');
      }
      $.ajax({
          type: 'POST',
          url: '{{route("admin.adduser")}}',
          data: $('form' + '#' + frm_id).serialize(),
          cache: false,
          dataType: 'json',
          beforeSend: function() {
              $('#btnLog').hide();
              $("#loader").removeClass('d-none');
          },
          success: function(html) {
              if (html.status == true) {
                  $("#addUserPop").modal('hide');
                  $("#loader").addClass('d-none');
                  $('#btnLog').show();
                  $("#frmAddUser").trigger("reset");
                //   $('#customer_search').val(html.data.customer_name);

                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 5000,
                      timerProgressBar: true,
                  });
                  Toast.fire({
                      icon: 'success',
                      title: html.message
                  });
                  $('#users-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
              }
              if (html.status == 409) {
                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 5000,
                      timerProgressBar: true,
                  });
                  Toast.fire({
                      icon: 'error',
                      title: html.msg
                  });
                  $('#btnLog').show();
                  $("#loader").addClass('d-none');
              }
          },
          error: function(xhr) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
            
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    $(`.error-${key}`).text(value[0]);
                });
                $('#btnLog').show();
                $("#loader").addClass('d-none');
            } else if(xhr.status == 400) {
                const error = xhr.responseJSON.error;
                $('#btnLog').show();
                $("#loader").addClass('d-none');
                Toast.fire({
                    icon: 'error',
                    title: error
                });
                
            }
          }
      });
    };
    // Add Service End

    // edit User Detail By Popup
    const editUserAction = (frm_id) => {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      
      if ($('#e_user_name').val() == '') {
          $('.e-error-user_name').html(`Please enter User Name`);
          return false;
      }
      if ($('#e_email').val() == '' && $('input[name="dependent"]').val() == 'no') {
          $('.e-error-email').html(`Please enter email`);
          return false;
      }
      if ($('#e_mobile').val() == '' && $('input[name="dependent"]').val() == 'no') {
          $('.e-error-mobile').html(`Please enter mobile`);
          return false;
      }
      if($('#e_gender').val() == '') {
        $('.e-error-gender').html('Please select Gender');
        $('#e_gender').focus();
        return false;
      }
      else {
        $('.e-error-gender').html('');
      }
      $.ajax({
          type: 'POST',
          url: '{{route("admin.edituser")}}',
          data: $('form' + '#' + frm_id).serialize(),
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
                $('#btnLog').show();
                $("#editUserPop").modal('hide');
                $("#loader").addClass('d-none');  
                  Toast.fire({
                      icon: 'success',
                      title: html.message
                  });
                  $('input[name="first_name"]').val('');
                  $('input[name="last_name"]').val('');
                  $('input[name="email"]').val('');
                  $('input[name="mobile"]').val('');
                  $('input[name="dob"]').val('');
                  $('input[name="city"]').val('');
                  $('input[name="gender"]').val('');
                  $('input[name="state"]').val('');
                  $('input[name="address"]').val('');
                  $('input[name="postal_code"]').val('');
                  $('input[name="remark"]').val('');
                  $('#users-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
              }
              if (html.status == 400) {
                  Toast.fire({
                      icon: 'error',
                      title: html.message
                  });
                  $('#btnLog').show();
                  $("#loader").addClass('d-none');
                  $('#eu1').append(`<div class="text-danger">${html.errors.name}</div>`);
                  $('#eu2').append(`<div class="text-danger">${html.errors.email}</div>`);
                  $('#eu3').append(`<div class="text-danger">${html.errors.mobile}</div>`);
              }
              if(html.status == 404) {
                  Toast.fire({
                      icon: 'error',
                      title: html.message
                  });
                  $('#btnLog').show();
                  $("#loader").addClass('d-none');
              }
          },
          error: function (xhr) {
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                
                $.each(errors, function (key, value) {
                    $(`.e-error-${key}`).text(value[0]);
                });
                $('#btnLog').show();
                $("#loader").addClass('d-none');
            }
            else {
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON.message
                });
            }

          }
      });
    };
    // edit User Detail By Popup End

    // Add Customer By Popup
    const addCustomerAction = (frm_id) => {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if ($('#first_name').val() == '') {
          $('.error-first_name').html(`Please enter First Name`);
          $('#first_name').focus();
          return false;
      }
      else{
        $('.error-first_name').html(``);
      }

      if ($('#last_name').val() == '') {
          $('.error-last_name').html(`Please enter Last Name`);
          $('#last_name').focus();
          return false;
      }
      else{
        $('.error-last_name').html(``);
      }

      
      if($('#gender').val() == '') {
        $('.error-gender').html('Please select Gender');
        $('#gender').focus();
        return false;
      }
      else {
        $('.error-gender').html('');
      }
      
      $.ajax({
          type: 'POST',
          url: '{{route("admin.addmember")}}',
          data: $('form' + '#' + frm_id).serialize(),
          cache: false,
          dataType: 'json',
          beforeSend: function() {
              $('#btnLog').hide();
              $("#loader").removeClass('d-none');
          },
          success: function(html) {
              if (html.status == true) {
                  $("#addCustomerPop").modal('hide');
                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true,
                  });
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
            } else {
                showToast('Something went wrong ❌', true);
            }
          }
      });
    };
    // Add Customer End

    // Add Individual Person as Family Member
    const addIndividualPersonAction = (frm_id) => {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if ($('#exist_person_name').val() == '') {
          $('.error-indv_person_search').html(`Please enter Client Name`);
          return false;
      }
      else{
        $('.error-indv_person_search').html(``);
      }
      
      $.ajax({
          type: 'POST',
          url: '{{route("admin.add.individual.as.member")}}',
          data: $('form' + '#' + frm_id).serialize(),
          cache: false,
          dataType: 'json',
          beforeSend: function() {
              $('#btnLog').hide();
              $("#loader").removeClass('d-none');
          },
          success: function(html) {
              if (html.status == true) {
                  $("#addExistingClientPop").modal('hide');
                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true,
                  });
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
            } else {
                showToast('Something went wrong ❌', true);
            }
          }
      });
    };
    // Add Individual Person as Family Member End

    const changeMainParent = (frm_id) => {
        $.ajax({
            type: 'POST',
            url: '{{route("admin.change.parent")}}',
            data: $('form' + '#' + frm_id).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                $('#btnLog').hide();
                $("#loader").removeClass('d-none');
            },
            success: function(html) {
                if (html.status == true) {
                    $("#showExistingMembersPop").modal('hide');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
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
                } else {
                    showToast('Something went wrong ❌', true);
                }
            }
        });
    };

    // view Family Member Detail in PopUp
    const viewMemberDetail = (id, type) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = '{{ route("admin.viewmember", [":id"]) }}';
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            cache: false,
            dataType: 'json',
            beforeSend: function() {},
            success: function(html) {
                if (html.status == true) {
                    let mobl = html.data.mobile;
                    if(mobl) {
                        let mobi_part1 = mobl.substring(0, 3);
                        let mobi_part2 = mobl.substring(3, 6);
                        let mobi_part3 = mobl.substring(6);
                        $('#e_mobile').val(`${mobi_part1}-${mobi_part2}-${mobi_part3}`);
                    }
                    else {
                        $('#e_mobile').val('');
                    }
                    
                    $('input[name="dependent"]').val(html.data.dependent);
                    $('input[name=id]').val(html.data.id);
                    $('#e_first_name').val(html.data.first_name);
                    $('#e_last_name').val(html.data.last_name);
                    if(html.data.email) {
                        $('#e_email').val(html.data.email);
                    }
                    else {
                        $('#e_email').val('');
                    }
                    
                    // Divide DOB into 3 parts, date, month and Year
                    
                    if(html.data.dob != null && html.data.dob != '1970-01-01') {
                        const [yr, mn, dt] = html.data.dob.split('-');
                        $('#e_bday').val(dt);
                        $('#e_bmonth').val(mn);
                        if(yr) {
                            $('#e_byear').val(yr);
                        }
                    }
                    else {
                        $('#e_bday').val('');
                        $('#e_bmonth').val('');
                        $('#e_byear').val('');
                    }
                    
                    // $('#e_dob').val(html.data.dob);
                    $('#e_address').val(html.data.address);
                    $('#e_city').val(html.data.city);
                    $('#e_gender').val(html.data.gender);
                    $('#e_dependent').val(html.data.dependent);
                    $('#e_state').val(html.data.state);
                    $('#e_postal_code').val(html.data.postal_code);
                    $('#e_remark').val(html.data.remark);
                }
            }
        });
    };

    const setDaysCount = (month, dtEle, yrEle) => {
        let yr = new Date().getFullYear();
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        // console.log(month);
        if(month == 2) {
            if(document.getElementById(yrEle).value == '') {
                Toast.fire({
                    icon: 'error',
                    title: 'Please select Year First'
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

    }

    const getDaysInMonth = (month, year) => {
        return new Date(year, month, 0).getDate();
    }
    // Family Member View Detail End 

    $(document).on('click', '.openModalBtn', function (){
        let data = $(this).data('dependent');
        $('input[name="dependent"]').val(data);
    });
    
    // edit Family Member By Popup
    const updateMemberAction = (frm_id) => {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      if ($('#e_first_name').val() == '') {
          $('.error-e_first_name').html(`Please enter First Name`);
          return false;
      }
      else {
        $('.error-e_first_name').html(``);
      }

      if ($('#e_last_name').val() == '') {
          $('.error-e_last_name').html(`Please enter Last Name`);
          return false;
      }
      else {
        $('.error-e_last_name').html(``);
      }
      if($('#e_gender').val() == '') {
        $('.error-e_gender').html('Please select Gender');
        $('#e_gender').focus();
        return false;
      }
      else {
        $('.error-e_gender').html('');
      }

      $.ajax({
          type: 'POST',
          url: '{{route("admin.updatemember")}}',
          data: $('form' + '#' + frm_id).serialize(),
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
                  $("#editCustomerPop").modal('hide');
                  
                  Toast.fire({
                      icon: 'success',
                      title: html.message
                  });
                  setTimeout(() => {
                      location.reload();
                  }, 3000);
              }
              
              if(html.status == 404) {
                  Toast.fire({
                      icon: 'error',
                      title: html.message
                  });
                  $('#btnLog').show();
                  $("#loader").addClass('d-none');
              }
          },
          error: function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    $(`.e-error-${key}`).text(value[0]);
                });
                $('#btnLog').show();
                $("#loader").addClass('d-none');
            } else {
                showToast('Something went wrong ❌', true);
            }
          }
      });
    };

    const removeMember = (id) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let url = '{{ route("admin.remove_member") }}';
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        });
        Swal.fire({
            title: "Are you sure?",
            text: 'Remove the member from the family',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
            cancelButtonText: "No"
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {id: id},
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {},
                    success: function(html) {
                        if (html.status == true) {
                            Toast.fire({
                                icon: 'success',
                                title: html.msg
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                        if(html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.error
                            });
                        }
                    }
                });
            }
        });
    };
    // edit Family Member Detail By Popup End
    </script>

    {{-- Booking Scripts --}}
    <script>
        $('#appointmentDateFilter').on('click', function (){
            $('#appointment-table').DataTable().ajax.reload();
        });
        $(document).ready(function (){
        // Appointment list
            var status = "{{ $status ?? '' }}"; // value from controller
            $('#appointment-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                ajax: {
                    url: "{{ route('admin.appointmentlist') }}",
                    data: function (d) {
                        d.status = status;
                        d.app_st = $('#app_st').val();
                        d.app_ed = $('#app_ed').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'customer_name', name: 'customer_name', orderable: true, searchable: true, responsivePriority: 1 },
                    { data: 'date_time', name: 'date_time', orderable: true, responsivePriority: 2 },
                    { data: 'duration', name: 'duration', orderable: false, responsivePriority: 5 },
                    { data: 'services', name: 'services', orderable: false, responsivePriority: 3 },
                    // { data: 'total_amount', name: 'total_amount', orderable: true, responsivePriority: 4 },
                    { data: 'status', name: 'booking_status', orderable: false, responsivePriority: 4 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 1 },
                ]
            });
        });
        
        // Past Appointments Listing
        $('#pastAppointmentDateFilter').on('click', function (){
            $('#past-appointment-table').DataTable().ajax.reload();
        });
        $(document).ready(function (){
        // Appointment list
            var status = "{{ $status ?? '' }}"; // value from controller
            $('#past-appointment-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                ajax: {
                    url: "{{ route('admin.past.appointment.list') }}",
                    data: function (d) {
                        d.status = status;
                        d.app_st = $('#app_st').val();
                        d.app_ed = $('#app_ed').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'customer_name', name: 'customer_name', orderable: true, searchable: true, responsivePriority: 1 },
                    { data: 'date_time', name: 'date_time', orderable: true, responsivePriority: 2 },
                    { data: 'duration', name: 'duration', orderable: false, responsivePriority: 5 },
                    { data: 'services', name: 'services', orderable: false, responsivePriority: 3 },
                    // { data: 'total_amount', name: 'total_amount', orderable: true, responsivePriority: 4 },
                    { data: 'status', name: 'booking_status', orderable: false, responsivePriority: 4 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 1 },
                ]
            });
        });

        const viewBookingDetail = (id) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = '{{ route("admin.viewbookingdetail", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                cache: false,
                dataType: 'json',
                beforeSend: function() {},
                success: function(html) {
                    if (html.status == true) {
                        $('#spn_name').html(html.booking.customer_name);
                        $('#spn_email').html(html.booking.customer_email);
                        $('#spn_mobile').html(html.booking.customer_mobile);
                        let serv = '';
                        for (const key in html.services) {
                            serv += `${html.services[key]},`;
                        }
                        serv = serv.slice(0, -1);
                        $('#spn_services').html(serv);
                        const bookg_dt = new Date(html.booking.booking_date + 'T00:00:00');
                        const format_dt = bookg_dt.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short', // e.g Jun
                            day: '2-digit'
                        });
                        $('#spn_date').html(format_dt);
                        $('#spn_time').html(html.booking.time_slots);
                        const badge_color = {
                            confirmed:"primary",
                            completed:"success",
                            canceled: "danger",
                            pending: "warning"
                        };
                        let input_status = html.booking.booking_status;
                        const color = (badge_color[input_status])? badge_color[input_status]:'secondary';
                        input_status = input_status.charAt(0).toUpperCase() + input_status.slice(1);
                        $('#spn_status').html(`<span class="badge text-bg-${color}">${input_status}</span>`);
                        $('#spn_amount').html(`$${html.booking.total_amount}`);
                    }
                }
            });
        };

        const updateAppointmentStatus = (el, id) => {
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
            const status = el.getAttribute('data-value');
            const url = '{{ route("admin.update_appointment_status") }}';
            $.ajax({
                type: 'GET',
                url: url,
                data: {id: id, status: status},
                cache: false,
                dataType: 'json',
                beforeSend: function() {},
                success: function(html) {
                    if (html.status == true) {
                        Toast.fire({
                            icon: 'success',
                            title: html.message
                        });
                        $('#appointment-table').DataTable().ajax.reload(null, false);
                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: html.message
                        });
                    }
                },
                error: function (xhr) {

                }
            });
        };
        
        const calculateDiscount = () => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerP0rogressBar: true,
            });
            let discount_type = $('#discount_type').val();
            if(!discount_type) {
                Toast.fire({
                    icon: 'error',
                    title: 'Please select the Discount Type!'
                });
                return false;
            }
            calculateSubTotal();
        };

        const sendMedicalForm = (customer_id) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = '{{ route("admin.sendmedicalform", ":customer_id") }}';
            url = url.replace(':customer_id', customer_id);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
            $.ajax({
                type: 'GET',
                url: url,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $(`#sp_smf_${customer_id}`).removeClass('d-none').addClass('spinner-border text-info');
                    $(`#i_${customer_id}`).addClass('d-none');
                },
                success: function(html) {
                    if (html.status == true) {
                        $(`#i_${customer_id}`).removeClass('d-none');
                        $(`#sp_smf_${customer_id}`).addClass('d-none').removeClass('spinner-border text-info');
                        Toast.fire({
                            icon: 'success',
                            title: html.message
                        });
                    }
                },
                error: function(xhr) {
                    if(xhr.status == 500) {
                        const errors = xhr.responseJSON.message;
                        Toast.fire({
                            icon: 'error',
                            title: errors
                        });
                    }
                }
            });
        };

        $(document).ready(function (){
            $('#myTab a').on('click', function(e){
                e.preventDefault();
                $(this).tab('show');
            });
        });

        // If any one Massage Therapy selected then other Massage service should disabled
        $(document).ready(function (){
            let edit_appoint_route = @json(Route::currentRouteName() == 'admin.edit_appointment');
            if(edit_appoint_route){
                $('.service-group[data-service-category="Massage Therapy"]').each(function() {
                    const $group = $(this);
                    // alert($group);
                    const $checked = $group.find('.service-checkbox:checked');
                    if ($checked.length > 0) {
                        // Disable all others in same group
                        $group.find('.service-checkbox').not($checked).prop('disabled', true);
                    }
                });
            }
        });
        </script>

    @if(Route::currentRouteName() === 'admin.add.appointment')
    <script>
        // On Date Change show available time slot for book Appointment.
        $('#booking_date, .service-checkbox').change(function (){
            var appointment_dt = $('#booking_date').val();
            let cbooking_id = '';
            let booking_status = '';
            
            let group = $(this).closest('.service-group');
            let category = group.data('service-category');

            // Check only for the Massage Therapy
            if(category == 'Massage Therapy') {
                const $checked = group.find('.service-checkbox:checked');
                if($checked.length > 0) {
                    // Disable all others in the same group
                    group.find('.service-checkbox').not($checked).prop('disabled', true);
                }
                else {
                    // Enable all when unchecked
                    group.find('.service-checkbox').prop('disabled', false);
                }
            }
            const checkboxes = document.querySelectorAll('.service-checkbox');
            const selected = [];
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selected.push(checkbox.value);
                }
            });

            let url = '{{route("admin.check_availability")}}';
            if(selected.length > 0 && appointment_dt != '') {
                $.ajax({
                    type: 'post',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {appoint_dt:appointment_dt, services:selected},
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#time_slots_div').html(`<img src="{{asset('admin_assets/assets/img/loading.gif')}}">`);
                    },
                    success: function(html) {
                        if (html.status == '200') {
                            $('#req_duration').html('');
                            $('#req_duration').html(`You Need Total Duration: ${html.duration} minutes`);
                            $('#time_slots_div').html('');
                            $('#time_slots_div').html(html.message);
                            $('#de_cli_endtm').val(html.cli_endtm);
                            if(html.block_type != ''){
                                $('#slot_err').addClass('text-danger');
                                $('#slot_err').html(`Slots are blocked Due to ${html.block_type}`);
                            }
                            else{
                                $('#slot_err').removeClass('text-danger');
                                $('#slot_err').html(``);
                            }
                        }
                        if (html.code == '404') {
                            $('#req_duration').html('');
                            $('#time_slots_div').html('');
                        }
                    }
                });
            }
        });

        function restoreOriginalStyle(slot) {
            slot.removeClass('slot_highlight');

            if (slot.data('booked') == 1) {
                slot.addClass('disable_slots');
            } else if (slot.data('blocked') == 1) {
                slot.addClass('blocked_slot');
            } else if (slot.data('lunch') == 1) {
                slot.addClass('lunch_slot');
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

        $(document).on('click', '.slot_brd', function () {

            let selectedDate = $('#booking_date').val();

            if (!selectedDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required',
                    text: 'Please select booking date first.'
                });
                return;
            }

            let selected = [];
            $('.service-checkbox:checked').each(function () {
                selected.push(this.value);
            });

            if (selected.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select at least one service!'
                });
                return;
            }

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
            let exceedsClinicHours = false;

            // Get clinic end time
            let clinicEndTime = $('#de_cli_endtm').val(); // e.g. "19:00"
            let clinicEndMinutes = clinicEndTime ? timeToMinutes(clinicEndTime) : null;
            
            for (let i = clickedIndex; i < clickedIndex + slotsNeeded; i++) {
                let slotValue = allClinicSlots[i];

                if (!slotValue) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid selection',
                        text: 'Required duration exceeds clinic timing.'
                    });
                    return;
                }

                // -------------------------------------------------------
                // CHECK: Does this slot's END time exceed clinic end time?
                // -------------------------------------------------------
                if (clinicEndMinutes !== null) {
                    let slotStartMinutes = timeToMinutes(slotValue);
                    let slotEndMinutes   = slotStartMinutes + slotDuration;

                    if (slotEndMinutes > clinicEndMinutes) {
                        exceedsClinicHours = true;
                        break; // 👈 No point checking further slots
                    }
                }
                
                // Find the corresponding DOM element
                let slot = displayedSlots.filter('[data-value="' + slotValue + '"]');

                if (!slot.length) {
                    // Slot exists in schedule but not displayed (might be filtered out)
                    continue;
                }

                // console.log(slot.data('value'));
                if (slot.data('booked') == 1) {
                    hasBooked = true;
                    break;
                }

                if (slot.data('blocked') == 1) {
                    hasBlocked = true;
                }

                if (slot.data('lunch') == 1) {
                    hasLunch = true;
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

            // Exceeds clinic closing time: reject immediately
            if (exceedsClinicHours) {
                Swal.fire({
                    text: 'The selected timeslot does not allow sufficient time for your selected service within clinic hours. Please select an earlier timeslot.'
                });
                return;
            }

            let warningMessage = '';

            if (hasLunch && !hasBlocked) {
                warningMessage += 'Selected duration overlaps lunch time.<br>';
            }

            if (!hasLunch && hasBlocked) {
                warningMessage += 'Selected duration overlaps blocked time.<br>';
            }
            if(hasLunch && hasBlocked) {
                warningMessage += 'This booking duration includes blocked time and Lunch time both.<br>';
            }

            function applySelection() {
                selectedSlots.forEach(function (slot) {
                    slot.addClass('slot_highlight')
                    if(slot.data('blocked') == 1) {
                        slot.removeClass('blocked_slot');
                    }
                    else if(slot.data('lunch') == 1) {
                        slot.removeClass('lunch_slot');
                    }
                });

                let selectedTimeValues = selectedSlots.map(function (slot) {
                    return slot.data('value');
                });

                $('#selected_slots').val(selectedTimeValues.join(','));
            }
            if (warningMessage !== '' && hasBooked === false) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Continue?',
                    html: warningMessage + '<br>Do you want to continue?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Continue'
                }).then((result) => {
                    if (result.isConfirmed) {
                        applySelection();
                    }
                });
            } else if(warningMessage === '' && hasBooked === false){
                applySelection();
            }
        });

        // Add new Booking of Appointment.
        let submitBookingAction = 'confirm';
        $(document).on('click', '#btnSubmitAppointment, #btnSendForm', function () {
            submitBookingAction = $(this).data('action');
        });
        if(document.getElementById('frmBookAppointment')) {
            $("#frmBookAppointment").submit(function(e) {
                e.preventDefault();
                var booking_dt = $('#booking_date').val(); // get booking date
                var therapist_id = $('#therapist_id').val();
                var customer_id = $('input[name="customer_id"]').val(); // get customer id
                var customer_name = $('#customer_search').val();    // get customer name
                var customer_email = $('input[name="customer_email"]').val(); // get customer email
                var customer_mobile = $('input[name="customer_mobile"]').val(); // get customer mobile
                var message = $('#message').val(); // get message
                
                // get Selected Services
                const checkboxes = document.querySelectorAll('.service-checkbox');
                var selected_services = [];
                let total_price = 0;
                $('.service-checkbox').each(function() {
                    if ($(this).is(':checked')) {
                        let service_id = $(this).val();
                        selected_services.push(service_id);
                        total_price += parseFloat($("#prc_" + service_id).val());
                    }
                });

                // slot data
                var selected_slot = [];
                $('.slot_brd.slot_highlight').each(function() {
                    selected_slot.push($(this).data('value')); // works if HTML has data-value
                });
                // console.log(total_price);
                // Service Validation
                if(selected_services.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please select at least one service!'
                    });
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // post data 
                let postData = {
                    appoint_dt: booking_dt,
                    therapist_id: therapist_id,
                    customer_id: customer_id,
                    customer_name: customer_name,
                    customer_email: customer_email,
                    customer_mobile: customer_mobile,
                    message: message,
                    total_price: total_price,
                    services: selected_services,
                    slots: selected_slot,
                    action: submitBookingAction
                };
                // console.log(postData);return false;
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                // End Post Data
                let booking_alert_msg = '';
                if(submitBookingAction == 'send_form') {
                    booking_alert_msg = 'This will create a pending appointment and an email will be sent to the customer to fill the Intake Form. Do you wish to proceed?';
                }
                if(submitBookingAction == 'confirm') {
                    booking_alert_msg = 'This will create a confirmed appointment and a confirmation email will be sent to the customer. Do you wish to proceed?';
                }
                Swal.fire({
                    title: "Are you sure?",
                    text: `${booking_alert_msg}`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Proceed",
                    cancelButtonText: "Cancel"
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: '{{route("admin.save_appointment")}}',
                            data: postData,
                            cache: false,
                            dataType: 'json',
                            beforeSend: function() {
                                $('#btnSubmitAppointment').hide();
                                $('#btnSendForm').hide();
                                $('#loader').removeClass('d-none');
                            },
                            success: function(html) {
                                if (html.status == 200) {
                                    $('#btnSubmitAppointment').show();
                                    $('#btnSendForm').show();
                                    $('#loader').addClass('d-none');
                                    // $('#booking_res_h4').html(html.message);
                                    // Reset fields
                                    $('#customer_search, #message').val('');
                                    $('#therapist_id').val('');
                                    $('input[name="customer_mobile"]').val('');
                                    $('input[name="customer_email"]').val('');
                                    $('input[name="customer_id"]').val('');

                                    // Reset checkboxes and radio buttons
                                    $('.service-checkbox').prop('checked', false);

                                    // Remove slot highlights
                                    $('.slot_brd').removeClass('slot_highlight');
                                    
                                    Toast.fire({
                                        icon: 'success',
                                        title: html.message
                                    });
                                    window.location.href = '{{route('admin.appointments')}}';
                                }
                                else if (html.status == 500) {
                                    $('#msg').html(html.message);
                                    $('#msg').addClass('text-danger');
                                    $('#btnSubmitAppointment').show();
                                    $('#btnSendForm').show();
                                    $('#loader').addClass('d-none');
                                }
                            },
                            error: function(xhr){
                                if(xhr.status == 422) {
                                    const errors = xhr.responseJSON.errors;
                                    $.each(errors, function (key, value) {
                                        // err_msg += `${value[0]}<br>`;
                                        // $(`#err_${key}`).html(value[0]);
                                        Toast.fire({
                                            icon: 'error',
                                            title: value[0]
                                        });
                                    });
                                    $('#btnSubmitAppointment').show();
                                    $('#loader').addClass('d-none');
                                }
                            }
                        });
                    }
                });
            })
        }
    </script>
    @endif

    @if(Route::currentRouteName() === 'admin.edit_appointment')
    <script>
        // On Date Change show available time slot for book Appointment.
        $('#booking_date, .service-checkbox').change(function (){
            var appointment_dt = $('#booking_date').val();
            let cbooking_id = '';
            let booking_status = '';
            if($('input[name="id"]').length) {
                cbooking_id = $('input[name="id"]').val();
                booking_status = $('input[name="booking_status"]').val();
            }
            
            let group = $(this).closest('.service-group');
            let category = group.data('service-category');

            // Check only for the Massage Therapy
            if(category == 'Massage Therapy') {
                const $checked = group.find('.service-checkbox:checked');
                if($checked.length > 0) {
                    // Disable all others in the same group
                    group.find('.service-checkbox').not($checked).prop('disabled', true);
                }
                else {
                    // Enable all when unchecked
                    group.find('.service-checkbox').prop('disabled', false);
                }
            }
            const checkboxes = document.querySelectorAll('.service-checkbox');
            const selected = [];
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selected.push(checkbox.value);
                }
            });

            let url = '{{route("admin.in_edit.check_availability")}}';
            if(selected.length > 0 && appointment_dt != '') {
                $.ajax({
                    type: 'post',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {cbooking_id: cbooking_id, booking_status:booking_status, appoint_dt:appointment_dt, services:selected},
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                    },
                    success: function(html) {
                        if (html.status == '200') {
                            $('#req_duration').html('');
                            $('#req_duration').html(`You Need Total Duration: ${html.duration} minutes`);
                            $('#time_slots_div').html('');
                            $('#de_cli_endtm').val(html.cli_endtm);
                            $('#time_slots_div').html(html.message);
                            if(html.block_type != ''){
                                $('#slot_err').addClass('text-danger');
                                $('#slot_err').html(`Slots are blocked Due to ${html.block_type}`);
                            }
                            else{
                                $('#slot_err').removeClass('text-danger');
                                $('#slot_err').html(``);
                            }
                        }
                        if (html.code == '404') {
                            $('#req_duration').html('');
                            $('#time_slots_div').html('');
                        }
                    }
                });
            }
        });

        function restoreOriginalStyle(slot) {
            slot.removeClass('slot_highlight');
            console.log(slot);
            if (slot.data('current-booked') == 1) {
                slot.addClass('disable_slots');
            } else if (slot.data('blocked') == 1) {
                slot.addClass('blocked_slot');
            } else if (slot.data('lunch') == 1) {
                slot.addClass('lunch_slot');
            } else if(slot.data('other-booked') == 1) {
                slot.addClass('other_disable_slots');
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

        $(document).on('click', '.slot_brd', function () {

            let selectedDate = $('#booking_date').val();

            if (!selectedDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required',
                    text: 'Please select booking date first.'
                });
                return;
            }

            let selected = [];
            $('.service-checkbox:checked').each(function () {
                selected.push(this.value);
            });

            if (selected.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select at least one service!'
                });
                return;
            }

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
            let hasOtherBooked = false;
            let exceedsClinicHours = false;

            // Get clinic end time
            let clinicEndTime = $('#de_cli_endtm').val(); // e.g. "19:00"
            let clinicEndMinutes = clinicEndTime ? timeToMinutes(clinicEndTime) : null;
            
            for (let i = clickedIndex; i < clickedIndex + slotsNeeded; i++) {
                let slotValue = allClinicSlots[i];

                if (!slotValue) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid selection',
                        text: 'Required duration exceeds clinic timing.'
                    });
                    return;
                }

                // -------------------------------------------------------
                // CHECK FIRST: Does this slot's END time exceed clinic end time?
                // Must be before !slot.length continue, so it always runs.
                // -------------------------------------------------------
                if (clinicEndMinutes !== null) {
                    let slotStartMinutes = timeToMinutes(slotValue);
                    let slotEndMinutes   = slotStartMinutes + slotDuration;

                    if (slotEndMinutes > clinicEndMinutes) {
                        exceedsClinicHours = true;
                        break;
                    }
                }

                // Find the corresponding DOM element
                let slot = displayedSlots.filter('[data-value="' + slotValue + '"]');

                if (!slot.length) {
                    // Slot exists in schedule but not displayed (might be filtered out)
                    continue;
                }

                // console.log(slot.data('value'));
                if (slot.data('other-booked') == 1) {
                    hasOtherBooked = true;
                    break;
                }

                if(slot.data('current-booked') == 1) {
                    hasBooked = true;
                }

                if (slot.data('blocked') == 1) {
                    hasBlocked = true;
                }

                if (slot.data('lunch') == 1) {
                    hasLunch = true;
                }

                selectedSlots.push(slot);
            }

            // If any required slot is booked, reject immediately
            if (hasOtherBooked) {
                Swal.fire({
                    // icon: 'error',
                    // title: 'Not available',
                    text: 'Selected duration overlaps with already booked slots, Please try another available time slots.'
                });
                return;
            }

            // Exceeds clinic closing time: reject immediately
            if (exceedsClinicHours) {
                Swal.fire({
                    text: 'The selected timeslot does not allow sufficient time for your selected service within clinic hours. Please select an earlier timeslot.'
                });
                return;
            }

            let warningMessage = '';

            if (hasLunch && !hasBlocked) {
                warningMessage += 'Selected duration overlaps lunch time.<br>';
            }

            if (!hasLunch && hasBlocked) {
                warningMessage += 'Selected duration overlaps blocked time.<br>';
            }
            if(hasLunch && hasBlocked) {
                warningMessage += 'This booking duration includes blocked time and Lunch time both.<br>';
            }

            function applySelection() {
                selectedSlots.forEach(function (slot) {
                    slot.addClass('slot_highlight')
                    if(slot.data('blocked') == 1) {
                        slot.removeClass('blocked_slot');
                    }
                    else if(slot.data('lunch') == 1) {
                        slot.removeClass('lunch_slot');
                    }
                });

                let selectedTimeValues = selectedSlots.map(function (slot) {
                    return slot.data('value');
                });

                $('#selected_slots').val(selectedTimeValues.join(','));
            }
            if (warningMessage !== '' && hasOtherBooked === false) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Continue?',
                    html: warningMessage + '<br>Do you want to continue?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Continue'
                }).then((result) => {
                    if (result.isConfirmed) {
                        applySelection();
                    }
                });
            } else if(warningMessage === '' && hasOtherBooked === false){
                applySelection();
            }
        });

        // update Appointment Script
        if(document.getElementById('frmUpdateBookAppointment')) {
            $('#frmUpdateBookAppointment').submit(function (e){
                e.preventDefault();
                var id = $('input[name="id"]').val();
                var therapist_id = $('#therapist_id').val();
                var booking_dt = $('#booking_date').val(); // get booking date
                var customer_id = $('input[name="customer_id"]').val(); // get customer id
                var customer_name = $('#customer_search').val();    // get customer name
                var customer_email = $('input[name="customer_email"]').val(); // get customer email
                var customer_mobile = $('input[name="customer_mobile"]').val(); // get customer mobile
                var booking_status = $('#booking_status').val();
                var message = $('#message').val(); // get message
                
                if(therapist_id == "") {
                    $('#error_therapist_id').html('Please select therapist name');
                    $('#therapist_id').focus();
                    return false;
                }
                if(customer_name == "") {
                    $('#error_customer_name').html('Please enter client name');
                    $('#customer_search').focus();
                    return false;
                }

                // get Selected Services
                const checkboxes = document.querySelectorAll('.service-checkbox');
                var selected_services = [];
                let total_price = 0;
                $('.service-checkbox').each(function() {
                    if ($(this).is(':checked')) {
                        let service_id = $(this).val();
                        selected_services.push(service_id);
                        total_price += parseFloat($("#prc_" + service_id).val());
                    }
                });

                // slot data
                var selected_slot = [];
                $('.slot_brd.slot_highlight').each(function() {
                    selected_slot.push($(this).data('value')); // works if HTML has data-value
                });
                // console.log(total_price);
                // Service Validation
                if(selected_services.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please select at least one service!'
                    });
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // post data 
                let postData = {
                    id:id,
                    therapist_id: therapist_id,
                    appoint_dt: booking_dt,
                    customer_id: customer_id,
                    customer_name: customer_name,
                    customer_email: customer_email,
                    customer_mobile: customer_mobile,
                    message: message,
                    booking_status: booking_status,
                    total_price: total_price,
                    services: selected_services
                };
                // ✅ only add slots if changed
                if (selected_slot.length > 0) {
                    postData.slots = selected_slot;
                }
                // console.log(postData);return false;
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.update.appointment")}}',
                    data: postData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnSubmitAppointment').hide();
                        $('#loader').removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == '200') {
                            $('#btnSubmitAppointment').show();
                            $('#loader').addClass('d-none');
                            // Reset fields
                            $('#customer_search, #message').val('');
                            $('input[name="customer_mobile"]').val('');
                            $('input[name="customer_email"]').val('');
                            $('input[name="customer_id"]').val('');

                            // Reset checkboxes and radio buttons
                            $('.service-checkbox').prop('checked', false);

                            // Remove slot highlights
                            $('.slot_brd').removeClass('slot_highlight');
                            
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                            setTimeout(function() {
                                window.location.href = "{{route('admin.appointments')}}";
                            }, 3000);
                        } 
                        else if (html.status == 500 || html.status == 422) {
                            // $('#msg').html(html.message);
                            $('#btnSubmitAppointment').show();
                            $('#loader').addClass('d-none');
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                        }
                    }
                });
            });
        }
    </script>
    @endif
    <script>
        const deleteAppointment = (id) => {
            let url = '{{route("admin.delete.appointment", ":id")}}';
            url = url.replace(':id', id);
            Swal.fire({
                title: "Are you sure?",
                text: "Delete the Appointment",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Proceed",
                cancelButtonText: "Cancel"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'get',
                        url: url,
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
                                $('#appointment-table').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function (xhr) {
                            const error = xhr.responseJSON.message;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error
                            });
                        }
                    });
                }
            });
        };
    </script>

    {{-- Old Customer Listing Module --}}
    <script>
        $(document).ready(function () {
            // Old Customers List
            $('#old-customer-data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                ajax: "{{ route('admin.old_customer_list') }}",
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'full_name', name: 'name', orderable: true, searchable: true, responsivePriority: 1 },
                    { data: 'mobile', name: 'mobile', orderable: true, responsivePriority: 2 },
                    { data: 'email', name: 'email', orderable: true, responsivePriority: 3 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 4 },
                ]
            });
        });
    </script>
    {{-- End Old Customer Listing Module --}}

    {{-- Old Reservation Listing Module --}}
    <script>
        $(document).ready(function () {
            // Old Customers List
            $('#old-reservation-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                ajax: "{{ route('admin.old_reservation_list') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'customer_name', name: 'customer_name', orderable: true, searchable: true, responsivePriority: 1 },
                    { data: 'time_date', name: 'time_date', orderable: true, responsivePriority: 2 },
                    { data: 'services', name: 'services', orderable: true, responsivePriority: 3 },
                    { data: 'status', name: 'status', orderable: true, responsivePriority: 3 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 4 },
                ]
            });
        });
    </script>
    {{-- End Old Reservation Listing Module --}}

    {{-- Invoice Lists --}}
    <script>
        $(document).ready(function () {
            $('#invDateFilter').on('click', function (){
                $('#invoice-table').DataTable().ajax.reload();
            })

            $('#invoice-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                order: [[4, 'desc']], // default order here
                ajax: {
                    url: "{{ route('admin.invoice_list') }}",
                    data: function (d) {
                        d.inv_st = $('#inv_st').val();
                        d.inv_ed = $('#inv_ed').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'status', name: 'payment_status', orderable: false, searchable: true, responsivePriority: 1 },
                    { data: 'invoice_sent', name: 'invoice_sent_date', orderable: false, responsivePriority: 1},
                    { data: 'invoice_date', name: 'invoice_date', orderable: false, responsivePriority: 2 },
                    { data: 'invoice_number', name: 'invoice_number', orderable: false, responsivePriority: 2 },
                    { data: 'customer', name: 'customer_name', orderable: false, responsivePriority: 3 },
                    { data: 'total', name: 'final_amount', orderable: false, responsivePriority: 3 },
                    { data: 'amount_due', name: 'amount_due', orderable: false, responsivePriority: 3 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 4 },
                ]
            });
        });

        const enableDisableLevel2 = (i) => {
            const $checkbox = $(`#paid_via_${i}`);
            const pay_id = $('input[name="id"]').val();
            const checkedCount = $('input[type="checkbox"][id^="paid_via_"]:checked').length;

            // If this checkbox is being checked and it would exceed the limit
            if ($checkbox.prop('checked') && checkedCount > 4) {
                // Uncheck it immediately
                $checkbox.prop('checked', false);

                // Optionally also disable or hide associated elements
                $(`#payment_option_${i}`).attr('disabled', true);
                $(`#pay_div_val_${i}`).addClass('d-none');

                alert('You can select only up to 4 options');
                return;
            }

            // If the checkbox is checked (after above restriction)
            if ($checkbox.prop('checked')) {
                $(`#payment_option_${i}`).removeAttr('disabled');
                $(`#payment_option_${i}`).attr('required', true);
                if(pay_id.length > 0) {
                    $(`#e_payment_value_${i}`).attr('required', true);
                    $(`#e_payment_value_${i}`).removeAttr('disabled');

                    $(`#payment_value_${i}`).removeAttr('required');
                }
                else if(pay_id.length <= 0) {
                    $(`#payment_value_${i}`).attr('required', true);
                    $(`#e_payment_value_${i}`).removeAttr('required');
                }

            } else {
                $(`#payment_option_${i}`).attr('disabled', true);
                $(`#payment_option_${i}`).removeAttr('required');
                $(`#payment_option_${i}`).val('');
                $(`#pay_div_val_${i}`).addClass('d-none');
                $(`#remain_div_${i}`).addClass('d-none');
                $(`#payment_value_${i}`).val('');
                $(`#payment_value_${i}`).removeAttr('required');
                $(`#e_payment_value_${i}`).removeAttr('required');
                $(`#e_payment_value_${i}`).val('');
                $(`#e_payment_value_${i}`).attr('disabled', true);
                $(`#remain_amt_${i}`).html('');
                if(pay_id.length > 0) {
                    calculateRemainOnEdit(i);
                }
                else {
                    calculateRemain(i);
                }
            }
        };

        const hideShowLevel3 = (i) => {
            const pay_id = $('input[name="id"]').val();
            if(pay_id.length <= 0) {
                $(`#pay_div_val_${i}`).removeClass('d-none');
            }
            else if(pay_id.length > 0 && $(`#payment_value_1`).val() == '' && i == 1) {
                $(`#pay_div_val_1`).removeClass('d-none');
                $(`#payment_value_1`).attr('required', true);
            }
        };

        if($('#direct_billing_2')) {
            $('#direct_billing_2').on('click', function (){
                if($("#direct_billing_2").is(":checked")) {
                    $('#direct_option_1').removeAttr('disabled');
                    $('#direct_option_1').attr('required', true);

                    $('#e_payment_value_1').removeAttr('disabled');
                    $('#e_payment_value_1').attr('required', true);
                }
                else {
                    $('#direct_option_1').attr('disabled', true);
                    $('#direct_option_1').removeAttr('required');

                    $('#e_payment_value_1').removeAttr('required');
                    $('#e_payment_value_1').attr('disabled', true);
                }
            });
        }

        const calculateRemain = (i) => {
            // let textbox_val = $(`#payment_value_${i}`).val();
            let final_amount = $('#final_amount').val();
            let remain_amt = 0;
            let another_textbox_val = 0;
            
            for(let j=1; j <= 5; j++) {
                if($(`#payment_value_${j}`).val() > 0) {
                    another_textbox_val += parseFloat($(`#payment_value_${j}`).val());
                }
                if(i != j) {
                    $(`#remain_div_${j}`).addClass('d-none');
                }
            }
            
            remain_amt = parseFloat(final_amount - another_textbox_val).toFixed(2);
            
            $(`#remain_div_${i}`).removeClass('d-none');
            $(`#remain_amt_${i}`).html(remain_amt);

        };

        const calculateRemainOnEdit = (i) => {
            // let textbox_val = $(`#payment_value_${i}`).val();
            let final_amount = $('#final_amount').val();
            let paid_amount = $('#paid_amount').val();
            // let directbill_1 = $('#payment_value_1').val();
            let remain_amt = 0;
            let another_textbox_val = 0;
            let first_payments = 0;
            for(let j=1; j <= 5; j++) {
                if($(`#payment_value_${j}`).val() > 0) {
                    first_payments += parseFloat($(`#payment_value_${j}`).val());
                }
                if($(`#e_payment_value_${j}`).val() > 0) {
                    another_textbox_val += parseFloat($(`#e_payment_value_${j}`).val());
                }
                if(i != j) {
                    $(`#remain_div_${j}`).addClass('d-none');
                }
            }
            
            remain_amt = parseFloat(final_amount - (parseFloat(first_payments) + another_textbox_val )).toFixed(2);
            
            $(`#remain_div_${i}`).removeClass('d-none');
            $(`#remain_amt_${i}`).html(remain_amt);
        };

        // Send a Invoice Payment Link
        const invoicePaymentLink = (id) => {
            let url = '{{ route("admin.send_pay_lnk", ":id") }}';
            url = url.replace(':id', id);

            Swal.fire({
            text: "Click the button below to send Online Payment Request to the Client.",
            // icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Send",
            cancelButtonText: "Cancel"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'get',
                        url: url,
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {
                        },
                        success: function(html) {
                            if (html.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: html.message
                                });
                                $('#invoice-table').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function (xhr) {
                            const error = xhr.responseJSON.message;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error
                            });
                        }
                    });
                }
            });
        }

        const deleteInvoice = (id) => {
            let url = '{{route("admin.delete_invoice", ":id")}}';
            url = url.replace(':id', id);
            Swal.fire({
            title: "Are you sure?",
            text: "Please note that this action is irreversible!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Proceed",
            cancelButtonText: "Cancel"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'get',
                        url: url,
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
                                $('#invoice-table').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function (xhr) {
                            const error = xhr.responseJSON.message;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error
                            });
                        }
                    });
                }
            });
        };

        if(document.getElementById('btnToggleInv')) {
            document.addEventListener('DOMContentLoaded', function() {
                const InvToggleBtn = document.getElementById('btnToggleInv');
                const display_inv = document.getElementById('toggleinvbox');
                const myinput = document.getElementById('invoice_number');
                InvToggleBtn.addEventListener('click', function (){
                    if(display_inv.style.display === 'none') {
                        display_inv.style.display = 'block';
                        myinput.style.display = 'none';

                    }
                    else {
                        myinput.style.display = 'block';
                        display_inv.style.display = 'none';
                    }
                })
            })
        }
        
    </script>
    {{-- Ends Invoice Lists --}}

    {{-- Create New Invoice --}}
    <script>
        // Autocomplete Customer
        $('#customer_search').on('input', function () {
            let query = $(this).val();
            if (query.length >= 2) {
                $.get("{{ route('admin.customer_search') }}", { query }, function (data) {
                    let suggestions = [];
                    if(data.data.length > 0) {
                        suggestions = data.data.map(c => 
                        {
                            let fullName = c.last_name ? `${c.first_name} ${c.last_name}` : c.first_name;
                            let mobile = c.mobile ? `(${c.mobile})`:'';
                            return `<a href="#" class="list-group-item list-group-item-action ys" data-id="${c.id}" data-name="${fullName}" data-mobile="${c.mobile}" data-email="${c.email}" data-familyid="${c.family_id}">${fullName} ${mobile}</a>`
                        });
                    }
                    else {
                        suggestions.push(`
                            <div class="list-group-item text-muted">No records found.</div>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addUserPop" class="list-group-item list-group-item-action text-primary no" id="addNewCustomerOption">
                                <i class="bi bi-plus-circle"></i> Add New Client
                            </a>
                        `);
                    }
                    $('#customer_suggestions').html(suggestions.join('')).show();
                });
            } else {
                $('#customer_suggestions').hide();
            }
        });

        // Select Customer
        $('#customer_suggestions').on('click', 'a.ys', function (e) {
            e.preventDefault();
            if($(this).data('familyid')) {
                var family_id = $(this).data('familyid');
            }
            else {
                var family_id = 0;
            }
            
            $('#customer_search').val($(this).data('name'));
            $('input[name="customer_id"]').val($(this).data('id'));
            $('input[name="customer_name"]').val($(this).data('name'));
            
            if($(this).data('mobile') == '' || $(this).data('mobile') == null) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.getFamilyMobile")}}',
                    data: {family_id:family_id},
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                    },
                    success: function(html) {
                        if (html.status == true) {
                            if(html.mobile != ''){
                                $('input[name="customer_mobile"]').val(html.mobile);
                            }
                            else {
                                let dependent_msg = `Appointment can't be booked. This is a "Dependant" profile with no parent/family assigned. Either assign this profile to a family/parent, or upgrade the profile to a "User" profile by defining Unique Email, Mobile No. and Password before trying to book an appointment.`;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: dependent_msg
                                });
                            }
                        }
                    },
                });
            }
            else {
                $('input[name="customer_mobile"]').val($(this).data('mobile'));
            }
            
            if($(this).data('email') == null || $(this).data('email') == '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.getFamilyEmail")}}',
                    data: {family_id:family_id},
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
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
                            if(html.email != '') {
                                $('input[name="customer_email"]').val(html.email);
                            }
                            else {
                                let dependent_msg = `Appointment can't be booked. This is a "Dependant" profile with no parent/family assigned. Either assign this profile to a family/parent, or upgrade the profile to a "User" profile by defining Unique Email, Mobile No. and Password before trying to book an appointment.`;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: dependent_msg
                                });
                            }
                        }
                    },
                });
            }
            else {
                $('input[name="customer_email"]').val($(this).data('email'));
            }
            
            $('#customer_suggestions').hide();
        });

        // Autocomplete for get individual member 
        $('#indv_person_search').on('input', function () {
            let query = $(this).val();
            if (query.length >= 2) {
                $.get("{{ route('admin.search.individual') }}", { query }, function (data) {
                    let suggestions = [];
                    if(data.data.length > 0) {
                        suggestions = data.data.map(c => 
                            {
                                let fullName = c.last_name ? `${c.first_name} ${c.last_name}`: c.first_name;
                                return `<a href="#" class="list-group-item list-group-item-action" data-id="${c.id}" data-name="${fullName}" data-mobile="${c.mobile}" data-email="${c.email}" data-familyid="${c.family_id}">${fullName} (${c.mobile})</a>`
                            }
                        );
                    }
                    else {
                        suggestions.push(`<div class="list-group-item text-muted">No records found.</div>`);
                    }
                    $('#indv_person_suggestions').html(suggestions.join('')).show();
                });
            } else {
                $('#indv_person_suggestions').hide();
            }
        });

        // Select Customer
        $('#indv_person_suggestions').on('click', 'a', function (e) {
            e.preventDefault();
            var family_id = $(this).data('familyid');
            $('#indv_person_search').val($(this).data('name'));
            $('input[name="member_id"]').val($(this).data('id'));
            $('input[name="exist_mobile"]').val($(this).data('mobile'));
            $('input[name="exist_email"]').val($(this).data('email'));
            
            $('#indv_person_suggestions').hide();
        });

        // Find Service price for category
        const getServicePrice = (i) => {
            let service_id = $(`#service_id_${i}`).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: '{{ route("admin.find_price") }}',
                data: {service_id: service_id},
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(html) {
                    if(html.status = true) {
                        $(`#duration_${i}`).html(`${html.data.duration} Min`);
                        let total = parseFloat(html.data.price).toFixed(2);
                        $(`#row_total_${i}`).val(total);
                        $(`#spn_row_total_${i}`).html(total);
                        $(`#is_taxable_${i}`).val(html.data.is_taxable);
                        calculateSubTotal();
                    }
                }
            });
        };

        // Add More Rows
        let invoice_edit_route = @json(Route::currentRouteName() == 'admin.edit_invoice');
        let rowIndex = 1;
        if(invoice_edit_route) {
            rowIndex = {{ isset($service_ids) ? count($service_ids) : 1 }};
        }
        $('#add_row').click(function () {
            $.get("{{ route('admin.invoice_service_row') }}", { index: rowIndex }, function (html) {
                $('#services_body').append(html.row);
                rowIndex++;
            });
        });

        // Remove Row
        $('#services_body').on('click', '.remove_row', function () {
            $(this).closest('tr').remove();
            calculateSubTotal();
        });

        // calculate the subtotal amount
        function calculateSubTotal()
        {
            let subtotal = 0;
            let total_taxable_amt = 0;
            let grand_total = 0;
            $('#services_body tr').each(function (){
                let price = parseFloat($(this).find('input[name="row_total[]"]').val()) || 0;
                let is_taxable = $(this).find('input[name="is_taxable[]"]').val();
                if(is_taxable == 1) {
                    total_taxable_amt += parseFloat(price); 
                }
                subtotal += parseFloat(price);
                
            });
            // console.log(total_taxable_amt); return false;
            $('#spn_sub_tot').html(parseFloat(subtotal).toFixed(2));
            $('#subtotal').val(parseFloat(subtotal).toFixed(2));

            let subtotal_after_discount = '';
            // Discount Calculation
            // let discount_type = $('#discount_type').val();
            // let discount = parseFloat($('#discount').val());
            // alert(discount);
            /*if(discount_type == 'flat' && discount > 0)
            {
                subtotal_after_discount = subtotal - discount;
                $('#spn_discount').html(discount);
                $('input[name="discount_val"]').val(discount);

            }
            else if(discount_type == 'percentage' && discount > 0)
            {
                let dis_per_val = parseFloat(subtotal * (discount/100)).toFixed(2);
                subtotal_after_discount = subtotal - dis_per_val;
                $('#spn_discount').html(dis_per_val);
                $('input[name="discount_val"]').val(dis_per_val);
            }
            else {
                subtotal_after_discount = subtotal;
                $('#spn_discount').html('0');
                $('input[name="discount_val"]').val('0');
            }*/
            // total_taxable_amt = total_taxable_amt;
            const tax = @json(getSetting());
            // Tax Calculation
            // let tax_status = tax.tax_value;
                let tax_value = tax.tax_value;
            // if(tax_status == 1) {
                let hst_amount = total_taxable_amt * (tax_value/100);
                hst_amount = +hst_amount.toFixed(2);
                grand_total = parseFloat(subtotal + hst_amount).toFixed(2);
                $('#spn_hst').html(hst_amount);
                $('input[name="hst_val"]').val(hst_amount);
                $('#spn_grand_total').html(grand_total);
                $('input[name="grand_total"]').val(grand_total);
        }

        function printInvoice(divId) {
            var divContents = document.getElementById(divId).innerHTML;
            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title></title>');
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">'); // Optional: Include Bootstrap if needed
            printWindow.document.write('<style>@media print {* {-webkit-print-color-adjust: exact !important;print-color-adjust: exact !important;}}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        }

        const deleteSoapNote = (filename) => {
            let url = '{{route("admin.delete_soapnote", ":filename")}}';
            url = url.replace(':filename', filename);
            Swal.fire({
            title: "Are you sure?",
            text: "Delete the Soap Note",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
            cancelButtonText: "No"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'get',
                        url: url,
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
                                window.location.href = '{{ route("admin.soap_notes") }}';
                            }
                        },
                        error: function (xhr) {
                            const error = xhr.responseJSON.message;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error
                            });
                        }
                    });
                }
            });
        };

        $('#treatment_notes_9').change(function (){
            if($("#treatment_notes_9").is(":checked")) {
                $('#treat_note_9').removeAttr('readonly');
            }
            else
            {
                $('#treat_note_9').attr('readonly','readonly');
                $('#treat_note_9').val('');
            }
        });

        $('#client_reaction_4').change(function (){
            if($("#client_reaction_4").is(":checked")) {
                $('#clt_reaction_4').removeAttr('readonly');
            }
            else
            {
                $('#clt_reaction_4').attr('readonly','readonly');
                $('#clt_reaction_4').val('');
            }
        });

        $('#home_exercises_5').change(function (){
            if($("#home_exercises_5").is(":checked")) {
                $('#hom_exercises_5').removeAttr('readonly');
            }
            else
            {
                $('#hom_exercises_5').attr('readonly','readonly');
                $('#hom_exercises_5').val('');
            }
        });

        // Show the Customer Statment.
        $('#btnSearch').click(function (){
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_mobile = $('input[name="customer_mobile"]').val();
            let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method, account;
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            if($('#account').prop('checked')) {
                account = $('#account').val();
            }
            // console.log(`${start_dt} <=> ${end_dt} <=> ID: ${customer_id}, Name:${customer_name}, Mobile:${customer_mobile}, Direct:${direct_billing}, Bank:${bank_payment}`);
            // return false;
            
            $.ajax({
                type: 'GET',
                url: "{{ route('admin.customer_report') }}",
                data: {
                    id: customer_id, 
                    name: customer_name, 
                    mobile: customer_mobile, 
                    start_dt: start_dt, 
                    end_dt: end_dt,
                    direct_billing: direct_billing,
                    bank_payment: bank_payment,
                    cash: cash,
                    other_method: other_method,
                    account: account
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(html) {
                    if(html.status == true) {
                        $('#customer_report').html(html.output);
                        $('[data-bs-toggletip="tooltip"]').tooltip();
                    }
                }
            });
        });
        
        $('#btnDownloadCustomerStatment').on('click', function (){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_mobile = $('input[name="customer_mobile"]').val();
            let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method;
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            if(customer_name == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please Select Customer Name"
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.customer_report_download") }}',
                data: {
                    id:customer_id, 
                    name: customer_name, 
                    mobile:customer_mobile, 
                    start_dt:start_dt, 
                    end_dt:end_dt,
                    direct_billing:direct_billing,
                    bank_payment:bank_payment,
                    cash:cash,
                    other_method:other_method
                },
                xhrFields: { responseType: 'blob' },
                beforeSend: function() {
                },
                success: function(data) {
                    var blob = new Blob([data], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Customer-Statement.pdf";
                    link.click();
                }
            });
        });

        $('#btnSingleExcelDownload').on('click', function (){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_mobile = $('input[name="customer_mobile"]').val();
            let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method;
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            if(customer_name == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please Select Customer Name"
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.customer_report_excel_download") }}',
                data: {
                    id:customer_id, 
                    name: customer_name, 
                    mobile:customer_mobile, 
                    start_dt:start_dt, 
                    end_dt:end_dt,
                    direct_billing:direct_billing,
                    bank_payment:bank_payment,
                    cash:cash,
                    other_method:other_method
                },
                xhrFields: { responseType: 'blob' },
                beforeSend: function() {
                },
                success: function(data) {
                    var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "customer-statement.xlsx";
                    link.click();
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: "Something went wrong while downloading Excel."
                    });
                }
            });
        });

        // Download Multiple Customer excel Report 
        const multipleCustomerReportDownload = (typ) => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_name = $('#customer_search').val();
            let customer_id_1, customer_id_2, customer_id_3;
            let direct_billing, bank_payment, cash, other_method;
            if($('input[name="customer_id_1"]').length > 0) {
                customer_id_1 = $('input[name="customer_id_1"]').val();
            }
            if($('input[name="customer_id_2"]').length > 0) {
                customer_id_2 = $('input[name="customer_id_2"]').val();
            }
            if($('input[name="customer_id_3"]').length > 0) {
                customer_id_3 = $('input[name="customer_id_3"]').val();
            }
            
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            if(customer_name == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please Select Customer Name"
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.multiple.customer.excel.download") }}',
                data: {
                    id:customer_id, 
                    start_dt:start_dt, 
                    end_dt:end_dt,
                    id_1: customer_id_1,
                    id_2: customer_id_2,
                    id_3: customer_id_3,
                    type: typ
                },
                xhrFields: { responseType: 'blob' },
                beforeSend: function() {
                },
                success: function(data) {
                    if(typ == 'pdf'){
                        var blob = new Blob([data], { type: 'application/pdf' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "customer-statement.pdf";
                        link.click();
                    }
                    if(typ == 'xlsx') {
                        var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "customer-statement.xlsx";
                        link.click();
                    }
                }
            });
        };

        // Download Revenue Result of range
        $('#btnDownloadRevenuePdf').on('click', function (){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.revenue.pdf.statement.download") }}',
                data: {
                    start_dt:start_dt, 
                    end_dt:end_dt
                },
                xhrFields: { responseType: 'blob' },
                beforeSend: function() {
                },
                success: function(data) {
                    var blob = new Blob([data], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "revenue_statement.pdf";
                    link.click();
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: "Something went wrong while downloading Excel."
                    });
                }
            });
        });
        $('#btnDownloadRevenueExcel').on('click', function (){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.revenue.excel.statement.download") }}',
                data: {
                    start_dt:start_dt, 
                    end_dt:end_dt
                },
                xhrFields: { responseType: 'blob' },
                beforeSend: function() {
                },
                success: function(data) {
                    var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "revenue_statement.xlsx";
                    link.click();
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: "Something went wrong while downloading Excel."
                    });
                }
            });
        });

        // Profit & Loss Statement Ajax Request
        $('#btnProLosSearch').on('click', function(){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.revenue_statement") }}',
                data: {start_dt:start_dt, end_dt:end_dt},
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) {
                    if(data.status = true) {
                        $('.dt_rng').html(`${start_dt} to ${end_dt}`);
                        $('#billed_val').html(`$${data.output.total_billed}`);
                        $('#tax_val').html(`$${data.output.total_tax}`);
                        $('#direct_amt').html(`$${data.output.total_direct_bill}`);
                        $('#bank_amt').html(`$${data.output.total_bank_pay}`);
                        $('#cash_amt').html(`$${data.output.total_cash}`);
                        $('#account_amt').html(`$${data.output.total_account}`);
                        $('#other_amt').html(`$${data.output.total_other_pay}`);
                        $('#received_amt').html(`$${data.output.total_received}`);
                        $('#credit_amt').html(`$${data.output.total_credit}`);
                        $('#pending_amt').html(`$${data.output.pending_amount}`);
                    }
                }
            });
        });

        /**
         * Search the total tax collection.
         */
        $('#btnSalesTaxSearch').on('click', function(){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='tax_start_dt']`).val();
            let end_dt = $(`input[name='tax_end_dt']`).val();
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.sales_tax_statement") }}',
                data: {start_dt:start_dt, end_dt:end_dt},
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) {
                    if(data.status = true) {
                        $('.tx_dt_rng').html(`${start_dt} to ${end_dt}`);
                        $('#tax_val').html(`$${data.net_tax}`);
                    }
                }
            });
        });

        /**
         * Add More Field for add customer name for search the multiple customer Statements.
         */
        
        document.addEventListener("DOMContentLoaded", function () {
            const maxFields = 4; // max allowed textboxes
            const addButton = document.getElementById("addField");
            const fieldWrapper = document.getElementById("customer_fields");
            let routecheck = @json(Route::currentRouteName() == 'admin.multiple_customer');
            if(routecheck) {
                addButton.addEventListener("click", function () {
                    const totalFields = fieldWrapper.querySelectorAll(".customer-field").length;
                    
                    if (totalFields < maxFields) {
                        const fieldDiv = document.createElement("div");
                        fieldDiv.classList.add("form-group", "customer-field", "mt-2");

                        fieldDiv.innerHTML = `
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control customer-input" placeholder="Enter name or mobile" id="customer_search_${totalFields}" onkeyup="searchFamilyMember(${totalFields})" />
                                <button type="button" class="btn btn-danger remove-btn">Remove</button>
                            </div>
                            <div id="customer_suggestions_${totalFields}" class="list-group"></div>
                                <input type="hidden" name="customer_id_${totalFields}" value="">
                                <input type="hidden" name="customer_mobile_${totalFields}" value="">
                                <input type="hidden" name="customer_email_${totalFields}" value="">`;

                        fieldWrapper.appendChild(fieldDiv);

                        // Handle remove button
                        fieldDiv.querySelector(".remove-btn").addEventListener("click", function () {
                            fieldDiv.remove();
                        });
                    } else {
                        alert("You can only add up to " + maxFields + " customers.");
                    }
                });
            }
            
        });

        // Ajax Autocomplete for select the customer.
        const searchFamilyMember = (id) => {
            let query = $(`#customer_search_${id}`).val();
            if (query.length >= 2) {
                $.get("{{ route('admin.customer_search') }}", { query }, function (data) {
                    let suggestions = [];
                    if(data.data.length > 0) {
                        suggestions = data.data.map(c => `<a href="#" class="list-group-item list-group-item-action" onclick="selectVal(${id}, ${c.id})" id="a_${c.id}" data-id="${c.id}" data-name="${c.first_name} ${c.last_name}" data-mobile="${c.mobile}" data-email="${c.email}">${c.first_name} ${c.last_name} (${c.mobile})</a>`);
                    }
                    else {
                        suggestions.push(`
                            <div class="list-group-item text-muted">No records found.</div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addUserPop" class="list-group-item list-group-item-action text-primary" id="addNewCustomerOption">
                                <i class="bi bi-plus-circle"></i> Add New Customer
                            </a>
                        `);
                    }
                    $(`#customer_suggestions_${id}`).html(suggestions.join('')).show();
                    
                });
            } else {
                $(`#customer_suggestions_${id}`).hide();
            }
        };

        // Select Customer
        const selectVal = (obj, c_id) => {
            $(`#customer_search_${obj}`).val($(`#a_${c_id}`).data('name'));
            $(`input[name="customer_id_${obj}"]`).val($(`#a_${c_id}`).data('id'));
            $(`input[name="customer_mobile_${obj}"]`).val($(`#a_${c_id}`).data('mobile'));
            $(`input[name="customer_email_${obj}"]`).val($(`#a_${c_id}`).data('email'));
            $(`#customer_suggestions_${obj}`).hide();
        };

        // Search Multiple Customer Statement
        $('#btnSearchMultiCustStatement').on('click', function(){
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            // let customer_mobile = $('input[name="customer_mobile"]').val();
            // let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method, account;
            let customer_id_1, customer_id_2, customer_id_3;
            // let customer_name_1, customer_name_2, customer_name_3;
            // let customer_mobile_1, customer_mobile_2, customer_mobile_3;
            // let customer_email_1, customer_email_2, customer_email_3;
            if($('input[name="customer_id_1"]').length > 0) {
                customer_id_1 = $('input[name="customer_id_1"]').val();
            }
            if($('input[name="customer_id_2"]').length > 0) {
                customer_id_2 = $('input[name="customer_id_2"]').val();
            }
            if($('input[name="customer_id_3"]').length > 0) {
                customer_id_3 = $('input[name="customer_id_3"]').val();
            }
            
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            if($('#account').prop('checked')) {
                account = $('#account').val();
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.multiple_customer_statement") }}',
                data: {
                    id:customer_id, 
                    start_dt:start_dt, 
                    end_dt:end_dt,
                    direct_billing:direct_billing,
                    bank_payment:bank_payment,
                    cash:cash,
                    other_method:other_method,
                    account:account,
                    id_1: customer_id_1,
                    id_2: customer_id_2,
                    id_3: customer_id_3
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(html) {
                    if(html.status == true) {
                        $('#mcustomer_report').html(html.output);
                        $('[data-bs-toggletip="tooltip"]').tooltip();
                    }
                }
            });
        });

        // Download Multiple Customer Statements
        $('#btnDownloadMultipleCustomerStatment').on('click', function(){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_mobile = $('input[name="customer_mobile"]').val();
            let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method;
            let customer_id_1, customer_id_2, customer_id_3;
            let customer_name_1, customer_name_2, customer_name_3;
            let customer_mobile_1, customer_mobile_2, customer_mobile_3;
            let customer_email_1, customer_email_2, customer_email_3;
            if($('input[name="customer_id_1"]').length > 0) {
                customer_id_1 = $('input[name="customer_id_1"]').val();
            }
            if($('input[name="customer_id_2"]').length > 0) {
                customer_id_2 = $('input[name="customer_id_2"]').val();
            }
            if($('input[name="customer_id_3"]').length > 0) {
                customer_id_3 = $('input[name="customer_id_3"]').val();
            }
            if($('#customer_search_1').length > 0) {
                customer_name_1 = $('#customer_search_1').val();
            }
            if($('#customer_search_2').length > 0) {
                customer_name_2 = $('#customer_search_2').val();
            }
            if($('#customer_search_3').length > 0) {
                customer_name_3 = $('#customer_search_3').val();
            }
            if($('input[name="customer_mobile_1"]').length > 0) {
                customer_mobile_1 = $('input[name="customer_mobile_1"]').val();
            }
            if($('input[name="customer_mobile_2"]').length > 0) {
                customer_mobile_2 = $('input[name="customer_mobile_2"]').val();
            }
            if($('input[name="customer_mobile_3"]').length > 0) {
                customer_mobile_3 = $('input[name="customer_mobile_3"]').val();
            }
            if($('input[name="customer_email_1"]').length > 0) {
                customer_email_1 = $('input[name="customer_email_1"]').val();
            }
            if($('input[name="customer_email_2"]').length > 0) {
                customer_email_2 = $('input[name="customer_email_2"]').val();
            }
            if($('input[name="customer_email_3"]').length > 0) {
                customer_email_3 = $('input[name="customer_email_3"]').val();
            }
            
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            if(customer_name == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please Select Customer Name"
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.multiple.customer.statement.download") }}',
                data: {
                    id:customer_id, 
                    name: customer_name, 
                    mobile:customer_mobile, 
                    start_dt:start_dt, 
                    end_dt:end_dt,
                    direct_billing:direct_billing,
                    bank_payment:bank_payment,
                    cash:cash,
                    other_method:other_method,
                    id_1: customer_id_1,
                    id_2: customer_id_2,
                    id_3: customer_id_3,
                    name_1: customer_name_1,
                    name_2: customer_name_2,
                    name_3: customer_name_3,
                    mobile_1: customer_mobile_1,
                    mobile_2: customer_mobile_2,
                    mobile_3: customer_mobile_3
                },
                xhrFields: { responseType: 'blob' },
                beforeSend: function() {
                },
                success: function(data) {
                    var blob = new Blob([data], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Customer-Statement.pdf";
                    link.click();
                }
            });
        });

        // Send Statement Email to Customer By Ajax Request
        $('#btnSendCustomerStatement').on('click', function (){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_mobile = $('input[name="customer_mobile"]').val();
            let customer_name = $('#customer_search').val();
            let default_mail = '';
            if($('#default_mail').prop("checked")) {
                default_mail = $('#default_mail').val();
            }
            
            let other_single_email = '';
            if($('#other_single_email').length > 0) {
                other_single_email = $('#other_single_email').val();
            }
            if(default_mail == '' && other_single_email == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please select atleast one email id."
                }); 
                return false;
            }

            let direct_billing, bank_payment, cash, other_method;
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            if(customer_name == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please Select Customer Name"
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.email_customer_statement") }}',
                data: {
                    id:customer_id, 
                    name: customer_name, 
                    mobile:customer_mobile, 
                    start_dt:start_dt, 
                    end_dt:end_dt,
                    direct_billing:direct_billing,
                    bank_payment:bank_payment,
                    cash:cash,
                    other_method:other_method,
                    default_mail: default_mail,
                    other_single_email: other_single_email
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#btnSendCustomerStatement').hide();
                    $("#loader").removeClass('d-none');
                },
                success: function(data) {
                    if(data.status == true) {
                        $('#singleMailModal').modal('hide');
                        $('#default_mail').val('');
                        $('#other_single_email').val('');
                        $('#btnSendCustomerStatement').show();
                        $("#loader").addClass('d-none');
                        Toast.fire({
                            icon: 'success',
                            title: `${data.message}`
                        }); 
                    }
                }
            });
        });

        // Send Email to customer for Multiple customer Statement
        $('#btnEmailMultipleCustomerStatement').on('click', function(){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // Validate Email Id Presend or not
            let default_mail = ''; let default_mail_1 = ''; let default_mail_2 = ''; let default_mail_3 = '';
            if($('#default_mail').prop("checked")) {
                default_mail = $('#default_mail').val();
            }
            if($('#default_mail_1').prop("checked")) {
                default_mail_1 = $('#default_mail_1').val();
            }
            if($('#default_mail_2').prop("checked")) {
                default_mail_2 = $('#default_mail_2').val();
            }
            if($('#default_mail_3').prop("checked")) {
                default_mail_3 = $('#default_mail_3').val();
            }
            
            let other_single_email_m = '';
            if($('#other_single_email_m').val() != '') {
                other_single_email_m = $('#other_single_email_m').val();
            }
            if(default_mail == '' && default_mail_1 == '' && default_mail_2 == '' &&default_mail_3 == '' && other_single_email_m == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please Select atleast one email id."
                }); 
                return false;
            }

            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method;
            let customer_id_1, customer_id_2, customer_id_3;
            let customer_email_1, customer_email_2, customer_email_3;
            if($('input[name="customer_id_1"]').length > 0) {
                customer_id_1 = $('input[name="customer_id_1"]').val();
            }
            if($('input[name="customer_id_2"]').length > 0) {
                customer_id_2 = $('input[name="customer_id_2"]').val();
            }
            if($('input[name="customer_id_3"]').length > 0) {
                customer_id_3 = $('input[name="customer_id_3"]').val();
            }
            
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }
            if(start_dt == '' || end_dt == ''){
               Toast.fire({
                    icon: 'error',
                    title: "Please select Start Date and End Date."
                }); 
                return false;
            }
            if(customer_name == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please Select Customer Name"
                }); 
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route("admin.multiple.customer.statement.send") }}',
                data: {
                    id:customer_id, 
                    start_dt:start_dt, 
                    end_dt:end_dt,
                    direct_billing:direct_billing,
                    bank_payment:bank_payment,
                    cash:cash,
                    other_method:other_method,
                    id_1: customer_id_1,
                    id_2: customer_id_2,
                    id_3: customer_id_3,
                    default_mail: default_mail,
                    default_mail_1: default_mail_1,
                    default_mail_2: default_mail_2,
                    default_mail_3: default_mail_3,
                    other_single_email_m: other_single_email_m
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#btnEmailMultipleCustomerStatement').addClass('d-none');
                    $("#loader").removeClass('d-none');
                },
                success: function(data) {
                    if(data.status == true) {
                        $('#btnEmailMultipleCustomerStatement').removeClass('d-none');
                        $("#loader").addClass('d-none');
                        Toast.fire({
                            icon: 'success',
                            title: `${data.message}`
                        }); 
                    }
                }
            });
        });

        $('#btnPrintStatement').click(function(){
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_mobile = $('input[name="customer_mobile"]').val();
            let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method;
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }

            window.open("{{ route('admin.customer.report.print') }}" + "?start_dt=" + start_dt + "&end_dt=" + end_dt + "&id=" + customer_id + "&mobile=" +customer_mobile + "&name="+customer_name+"&direct_billing="+direct_billing+"&bank_payment="+bank_payment+"&cash="+cash+"&other_method="+other_method, "_blank");
        });


        $('#btnPrintMultipleStatement').click(function(){
            let start_dt = $(`input[name='start_dt']`).val();
            let end_dt = $(`input[name='end_dt']`).val();
            let customer_id = $('input[name="customer_id"]').val();
            let customer_mobile = $('input[name="customer_mobile"]').val();
            let customer_name = $('#customer_search').val();
            let direct_billing, bank_payment, cash, other_method;
            let customer_id_1, customer_id_2, customer_id_3;
            let customer_name_1, customer_name_2, customer_name_3;
            let customer_mobile_1, customer_mobile_2, customer_mobile_3;
            
            if($('input[name="customer_id_1"]').length > 0) {
                customer_id_1 = $('input[name="customer_id_1"]').val();
            }
            if($('input[name="customer_id_2"]').length > 0) {
                customer_id_2 = $('input[name="customer_id_2"]').val();
            }
            if($('input[name="customer_id_3"]').length > 0) {
                customer_id_3 = $('input[name="customer_id_3"]').val();
            }
            if($('#customer_search_1').length > 0) {
                customer_name_1 = $('#customer_search_1').val();
            }
            if($('#customer_search_2').length > 0) {
                customer_name_2 = $('#customer_search_2').val();
            }
            if($('#customer_search_3').length > 0) {
                customer_name_3 = $('#customer_search_3').val();
            }
            if($('input[name="customer_mobile_1"]').length > 0) {
                customer_mobile_1 = $('input[name="customer_mobile_1"]').val();
            }
            if($('input[name="customer_mobile_2"]').length > 0) {
                customer_mobile_2 = $('input[name="customer_mobile_2"]').val();
            }
            if($('input[name="customer_mobile_3"]').length > 0) {
                customer_mobile_3 = $('input[name="customer_mobile_3"]').val();
            }
            
            if($('#direct_billing').prop("checked")){
                direct_billing = $('#direct_billing').val();
            }
            if($('#bank_payment').prop('checked')) {
                bank_payment = $('#bank_payment').val();
            }
            if($('#cash').prop('checked')) {
                cash = $('#cash').val();
            }
            if($('#other_method').prop('checked')) {
                other_method = $('#other_method').val();
            }

            window.open("{{ route('admin.multiple.customer.report.print') }}" + "?start_dt=" + start_dt + "&end_dt=" + end_dt + "&id=" + customer_id + "&id_1=" + customer_id_1 +"&id_2="+ customer_id_2 +"&id_3=" + customer_id_3 + "&mobile=" +customer_mobile +"&mobile_1=" + customer_mobile_1 +"&mobile_2=" +customer_mobile_2+"&moile_3="+ customer_mobile_3 + "&name="+customer_name+ "&name_1="+customer_name_1+ "&name_2="+customer_name_2+"&name_3="+customer_name_3+"&direct_billing="+direct_billing+"&bank_payment="+bank_payment+"&cash="+cash+"&other_method="+other_method, "_blank");
        });

        const sendInvoicePopup = (invoiceId) => {
            $.ajax({
                type: 'post',
                url: '{{ route("admin.invoice.mail.popup") }}',
                data: {
                    invoice_id: invoiceId, 
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(html) {
                    if(html.status == true) {
                        $('#default_inv_mail').val(html.email);
                        $('#invoice_id').val(html.id);
                        $('#default_lbl_email').html(html.email);
                    }
                }
            });
        };

        // Send invoice mail to client using popup.
        $('#btnSendInvoiceMail').on('click', function (){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            let inv_id = $('#invoice_id').val();
            let default_mail = '';
            if($('#default_inv_mail').prop("checked")) {
                default_mail = $('#default_inv_mail').val();
            }
            
            let other_single_email = '';
            if($('#other_inv_email').length > 0) {
                other_single_email = $('#other_inv_email').val();
            }
            if(default_mail == '' && other_single_email == '') {
                Toast.fire({
                    icon: 'error',
                    title: "Please select atleast one email id."
                }); 
                return false;
            }
            $.ajax({
                type: 'post',
                url: '{{ route("admin.send_invoice") }}',
                data: {
                    default_mail: default_mail, 
                    other_single_email: other_single_email,
                    id: inv_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(html) {
                    if(html.status == true) {
                        $('#sendInvoiceMailModel').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: `${html.message}`
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    }
                }
            });
        });

        $('#btnSendSingleMail').click(function(){
            let email = $('input[name="customer_email"]').val();
            $('#default_lbl_email').html(email);
            $('#default_mail').val(email)
        });

        $('#btnSendMultipleMail').click(function(){
            let email = '';
            let email_1 = ''; let email_2 = ''; let email_3 = '';
            
            if($('input[name="customer_email"]').val()) {
                email = $('input[name="customer_email"]').val();
            }
            if($('input[name="customer_email_1"]').val()) {
                email_1 = $('input[name="customer_email_1"]').val();
            }
            if($('input[name="customer_email_2"]').val()) {
                email_2 = $('input[name="customer_email_2"]').val();
            }
            if($('input[name="customer_email_3"]').val()) {
                email_3 = $('input[name="customer_email_3"]').val();
            }
            
            if(email != '') {
                $('#default_mail').val(email);
                $('#default_lbl_email').html(email);
            }
            
            if(email_1 != '') {
                $('#default_lbl_email_1').html(email_1);
                $('#default_mail_1').val(email_1);
                $('#default_mail_1').prop("checked");
                $('#eml_1').show();
            }
            else {
                $('#default_mail_1').prop("checked", false);
                $('#eml_1').hide();
            }
            if(email_2 != '') {
                $('#default_lbl_email_2').html(email_2);
                $('#default_mail_2').val(email_2);
                $('#default_mail_2').prop("checked");
                $('#eml_2').show();
            }
            else {
                $('#default_mail_2').prop("checked", false);
                $('#eml_2').hide();
            }

            if(email_3 != '') {
                $('#default_lbl_email_3').html(email_3);
                $('#default_mail_3').val(email_3);
                $('#default_mail_3').prop("checked");
                $('#eml_3').show();
            }
            else {
                $('#default_mail_3').prop("checked", false);
                $('#eml_3').hide();
            }
        });

        $(document).ready(function (){
            // Initialize the tooltip in datatable after coming data from ajax
            $('#services-table, #users-table, #appointment-table, #invoice-table').on('draw.dt', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggletip="tooltip"]'));
                tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });

        // Get Available time Day wise
        $('#day').change(function(){
            let dayval = $(this).val(); 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_schedule") }}',
                data: {
                    dayval:dayval
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    
                },
                success: function(data) {
                    if(data.status == true) {
                        $('#block_avail_time_div').html('');
                        $('#block_avail_time_div').html(data.message);
                    }
                }
            });
        });

        $(document).on('click', '.time_brd', function() {
            var slots = $('.time_brd');
            var startIndex = slots.index(this);
            var requiredDuration = parseInt($(this).data('duration')); // e.g. 90
            var slotCount = Math.ceil(requiredDuration / 30); // e.g. 3 for 90 min
            // console.log(startIndex); return false;
            // slots.removeClass('time_highlight');
            $('#selection_error').html('');

            // Define morning and evening slot arrays (must match your slot values)
            var morningSlots = [
                "09:30am", "10:00am", "10:30am", "11:00am", "11:30am",
                "12:00pm", "12:30pm", "01:00pm", "01:30pm"
            ];
            var eveningSlots = [
                "04:00pm", "04:30pm", "05:00pm", "05:30pm",
                "06:00pm", "06:30pm", "07:00pm"
            ];

            // Get the clicked slot time
            var clickedTime = $(this).data('value');
            // Determine which range the clicked slot is in
            var isMorning = morningSlots.includes(clickedTime);
            var isEvening = eveningSlots.includes(clickedTime);

            // Get the relevant slot array and its start index
            var rangeSlots = isMorning ? morningSlots : (isEvening ? eveningSlots : []);

            var rangeStartIndex = rangeSlots.indexOf(clickedTime);

            // Check if enough consecutive slots are available in the selected range
            if (rangeStartIndex !== -1 && (rangeStartIndex + slotCount) <= rangeSlots.length) {
                // Check for engaged & disable_slots in the required range
                let canSelect = true;
                let selectedBlock = [];
                for (var i = 0; i < slotCount; i++) {
                    let $slot = slots.filter('[data-value="' + rangeSlots[rangeStartIndex + i] + '"]');
                    
                    if ($slot.hasClass('engaged') || $slot.hasClass('disable_times')) {
                        canSelect = false;
                        break;
                    }
                    selectedBlock.push($slot);
                }
                if (canSelect) {
                    // Highlight the slots in the DOM
                    let alreadySelected = selectedBlock.every($slot => $slot.hasClass('time_highlight'));
                    if(alreadySelected) {
                        selectedBlock.forEach($slot => $slot.removeClass('time_highlight'));
                    }
                    else {
                        selectedBlock.forEach($slot => $slot.addClass('time_highlight'));
                    }
                }
            }
        });

        /**
         * @description: Add Block Time for the Day.
        */
        if(document.getElementById('frmAddSchedule')) {
            $("#frmAddSchedule").submit(function(e) {
                e.preventDefault();
                let day = $('#day').val();

                var selected_time = [];
                $('.time_brd.time_highlight').each(function() {
                    selected_time.push($(this).data('value')); // works if HTML has data-value
                });
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

                let postData = {
                    day: day,
                    block_time:selected_time
                }
                // End Post Data
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.save.daytime.schedule")}}',
                    data: postData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnSchedule').hide();
                        $('#loader').removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $('#btnSchedule').show();
                            $('#loader').addClass('d-none');
                            // Reset fields
                            $('#day').val('');
                            // Remove slot highlights
                            $('.time_brd').removeClass('time_highlight');
                            window.location.href="{{ route('admin.day.time.schedule') }}";
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                        } else if (html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                        }
                    }
                });
            });
        }

        /**
         * List the Holidays
        */ 
        $(document).ready(function () {
            // Holiday List
            if(document.getElementById('holidaylist-table')) {
                $('#holidaylist-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    pageLength: 25,
                    ajax: "{{ route('admin.holiday.list') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'id', orderable: false },
                        { data: 'holiday_name', name: 'holiday_name', orderable: true, searchable: true, responsivePriority: 1 },
                        { data: 'holiday_range', name: 'holiday_range', orderable: true, responsivePriority: 1 },
                        { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 2 },
                    ]
                });
            }
        });

        const deleteHoliday = (id) => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let url = '{{ route("admin.delete.holiday") }}';
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
                Swal.fire({
                    title: "Are you sure?",
                    text: 'Delete the Holiday, If This holiday deleted then holiday date open for the future booking.',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No"
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: url,
                            data: {id: id},
                            cache: false,
                            dataType: 'json',
                            beforeSend: function() {},
                            success: function(html) {
                                if (html.status == true) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: html.message
                                    });
                                    window.location.href="{{ route('admin.holiday') }}";
                                }
                                if(html.status == false) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: html.message
                                    });
                                }
                            }
                        });
                    }
                })
            }

        /**
         * @description: Delete Day Time Blockings
        */
        const deleteDayTimeSchedule = (id) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = '{{ route("admin.deletedaytime") }}';
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
            Swal.fire({
                title: "Are you sure?",
                text: 'Delete the Block Time',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!",
                cancelButtonText: "No"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {id: id},
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {},
                        success: function(html) {
                            if (html.status == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: html.message
                                });
                                window.location.href="{{ route('admin.day.time.schedule') }}";
                            }
                            if(html.status == false) {
                                Toast.fire({
                                    icon: 'error',
                                    title: html.message
                                });
                            }
                        }
                    });
                }
            })
        };

         // This function is used for get and check which time available to booking on date.
        $('#txtDate').change(function(){
            let dt = $('#txtDate').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = '{{ route("admin.get_blockdate_and_time") }}';
            $.ajax({
                type: 'GET',
                url: url,
                data: {dt: dt},
                cache: false,
                dataType: 'json',
                beforeSend: function() {},
                success: function(html) {
                    if (html.status == true) {
                        $('#block_avail_time_div').html(html.message);
                    }
                }
            });
        });

        // update the slot time for the particular date.
        if(document.getElementById('frmAddDateTimeBlock')) {
            $("#frmAddDateTimeBlock").submit(function(e) {
                e.preventDefault();
                let dt = $('#txtDate').val();

                var selected_time = [];
                $('.time_brd.time_highlight').each(function() {
                    selected_time.push($(this).data('value')); // works if HTML has data-value
                });
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

                let postData = {
                    dt: dt,
                    block_time:selected_time
                }
                // End Post Data
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.save_blockdate")}}',
                    data: postData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnBlockDtTm').hide();
                        $('#loader').removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $('#btnBlockDtTm').show();
                            $('#loader').addClass('d-none');
                            // Reset fields
                            $('#txtDate').val('');
                            // Remove slot highlights
                            $('.time_brd').removeClass('time_highlight');
                            // window.location.href="{{ route('admin.day.time.schedule') }}";
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                        } else if (html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                        }
                    }
                });
            });
        };

        const unBlockDates = (id) => {
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

            let postData = {
                id: id
            }
            // End Post Data
            $.ajax({
                type: 'post',
                url: '{{route("admin.get_block_dates")}}',
                data: postData,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $(`#href_${id}`).hide();
                    $(`#spn_${id}`).removeClass('d-none');
                },
                success: function(html) {
                    if (html.status == true) {
                        $(`#href_${id}`).show();
                        $(`#spn_${id}`).addClass('d-none');
                        $("#unBlockModelPop").modal('show');
                        $('#id').val(id);
                        $('#blocked_dts').html(html.message);
                    } else if (html.status == false) {
                        Toast.fire({
                            icon: 'error',
                            title: html.message
                        });
                    }
                }
            });
        };

        const unblock_timeslot = (frmid) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let id = $('#id').val();
            
            const checkboxes = document.querySelectorAll('.datschk');
            const selected = [];
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selected.push(checkbox.value);
                }
            });

            if(selected.length <= 0) {
                alert('Please select the Date to unblock');
                return false;
            }
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            $.ajax({
                type: 'post',
                url: '{{route("admin.unblock.datesof.time")}}',
                data: {id:id, dats: selected},
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $(`#btnUnblock`).hide();
                    $(`#loader`).removeClass('d-none');
                },
                success: function(html) {
                    if (html.status == true) {
                        $(`#btnUnblock`).show();
                        $(`#loader`).addClass('d-none');
                        $("#unBlockModelPop").modal('hide');
                        $('#dateblock-table').DataTable().ajax.reload(null, false);
                        Toast.fire({
                            icon: 'success',
                            title: html.message
                        });
                    } else if (html.status == false) {
                        Toast.fire({
                            icon: 'error',
                            title: html.message
                        });
                    }
                }
            });
        };

        // Select All button functionality
        $(document).on('click', '#selectAllTimeSlots', function () {
            var slots = $('.time_brd');

            // Check if ALL are already selected
            // alert(slots.not('.engaged, .disable_times').length);
            // alert(slots.filter('.time_highlight').length);
            var allSelected = slots.not('.engaged, .disable_times').length === slots.filter('.time_highlight').length;

            if (allSelected) {
                // Deselect all
                slots.removeClass('time_highlight');
            } else {
                // Select all available slots
                slots.each(function () {
                    if (!$(this).hasClass('engaged') && !$(this).hasClass('disable_times')) {
                        $(this).addClass('time_highlight');
                    }
                });
            }
        });

        // Add Holiday date.
        if(document.getElementById('frmAddHoliday')) {
            $("#frmAddHoliday").submit(function(e) {
                e.preventDefault();
                let st_dt = $('input[name="start_dt"]').val();
                let ed_dt = $('input[name="end_dt"]').val();
                let holiday_name = $('#holiday_name').val();

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

                let postData = {
                    st_dt: st_dt,
                    ed_dt: ed_dt,
                    holiday_name: holiday_name
                };
                // End Post Data
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.save_holiday")}}',
                    data: postData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnHoliday').hide();
                        $('#loader').removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $('#btnHoliday').show();
                            $('#loader').addClass('d-none');
                            // Reset fields
                            $('input[name="start_dt"]').val('');
                            $('input[name="end_dt"]').val('');
                            $('#holiday_name').val('');
                            $('#holidaylist-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                        } else if (html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                        }
                    }
                });
            });
        };

        const viewHolidayDetail = (id) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = '{{ route("admin.holiday.detail", ":id") }}';
            url = url.replace(':id', id);  
            $.ajax({
                type: 'GET',
                url: url,
                data: {id: id},
                cache: false,
                dataType: 'json',
                beforeSend: function() {},
                success: function(html) {
                    if(html.status == true) {
                        $('input[name="e_id"]').val(html.data.id);
                        $('#e_holiday_name').val(html.data.holiday_name);
                        $('#e_sdt').val(html.data.from);
                        $('#e_edt').val(html.data.to);
                    }
                }
            });
        };

        // Update Holiday Day Date Range.
        if(document.getElementById('frmEditHoliday')) {
            $("#frmEditHoliday").submit(function(e) {
                e.preventDefault();
                let id = $('input[name="e_id"]').val();
                let st_dt = $('#e_sdt').val();
                let ed_dt = $('#e_edt').val();
                let holiday_name = $('#e_holiday_name').val();

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

                let postData = {
                    id:id,
                    st_dt: st_dt,
                    ed_dt: ed_dt,
                    holiday_name: holiday_name
                };
                // End Post Data
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.holiday.update")}}',
                    data: postData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#e_btnHoliday').hide();
                        $('#e_loader').removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $('#e_btnHoliday').show();
                            $('#e_loader').addClass('d-none');
                            // Reset fields
                            $('#e_sdt').val('');
                            $('#e_edt').val('');
                            $('#e_holiday_name').val('');
                            $('#holidaylist-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                            Toast.fire({
                                icon: 'success',
                                title: html.msg
                            });
                        } else if (html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.msg
                            });
                        }
                    }
                });
            });
        };
    </script>
    @if(Route::currentRouteName() == 'admin.revenuechart') 
        <script>
            const months = @json($months);
            const revenues = @json($revenues);
            const sales_chart_options = {
                series: [
                    {
                        name: 'Revenue',
                        data: revenues
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 300,
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                        borderRadius: 5,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                xaxis: {
                    categories: months,
                },
                yaxis: {
                    title: {
                        text: 'Revenue Amount'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return '$ ' + val.toLocaleString();
                        }
                    }
                },
            };

            const sales_chart = new ApexCharts(
                document.querySelector('#sales-chart'),
                sales_chart_options
            );

            sales_chart.render();
            // End Here
        </script>
    @endif
    @if(Route::currentRouteName() === 'admin.company_detail')
    <script>
        $('#frmCompanyDetail').on('submit', function(e) {
            let flag = true;
            let comp_name = $('#company_name').val();
            let comp_phone = $('#company_phone').val();
            let comp_email = $('#company_email').val();
            let whatsapp = $('#whatsapp_no').val();
            let comp_addr = $('#company_address').val();
            let tax_reg_number = $('#company_tax_reg_number').val();
            let tax_name = $('#tax_name').val();
            let tax_value = $('#tax_value').val();

            const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if(comp_name == ''){
                $('#err_comp_nm').html('Please enter company name');
                $('#company_name').focus();
                flag = false;
                return false;
            }
            if(comp_phone == '') {
                $('#err_comp_ph').html('Please enter company phone');
                $('#company_phone').focus();
                flag = false;
                return false;
            }
            if(!mobileRegex.test(comp_phone)) {
                $('#err_comp_ph').html('Please enter valid phone');
                $('#company_phone').focus();
                flag = false;
                return false;
            }
            if(comp_email == '') {
                $('#err_comp_email').html('Please enter company email');
                $('#company_email').focus();
                flag = false;
                return false;
            }
            if(!regex.test(comp_email)) {
                $('#err_comp_email').html('Please enter valid email');
                $('#company_email').focus();
                flag = false;
                return false;
            }

            if(whatsapp == '') {
                $('#err_whats_no').html('Please enter the Whatsapp No.');
                $('#whatsapp_no').focus();
                flag = false;
                return false;
            }
            if(whatsapp != '' && !mobileRegex.test(whatsapp)) {
                $('#err_whats_no').html('Please enter the Whatsapp No.');
                $('#whatsapp_no').focus();
                flag = false;
                return false;
            }

            if(comp_addr == '') {
                $('#err_comp_addr').html('Please enter company email');
                $('#company_address').focus();
                flag = false;
                return false;
            }
            if(tax_reg_number == '') {
                $('#err_reg_no').html('Please enter tax reg. number');
                $('#company_tax_reg_number').focus();
                flag = false;
                return false;
            }
            if(tax_name == '') {
                $('#err_tax_name').html('Please enter the tax name');
                $('#tax_name').focus();
                flag = false;
                return false;
            }
            if(tax_value == '') {
                $('#err_tax_value').html('Please enter the tax value');
                $('#tax_value').focus();
                flag = false;
                return false;
            }

            if(!flag) {
                e.preventDefault();
                return false;
            }
        });
    </script>
    @endif
    @if(Route::currentRouteName() === 'admin.service.providers')
    <script>
        $(document).ready(function (){
            $('#service-provider-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                order: [[1, 'asc']], // default order here
                ajax: {
                    url: "{{ route('admin.provider-list') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'title', name: 'title', orderable: false, responsivePriority: 1 },
                    { data: 'name', name: 'name', orderable: false, responsivePriority: 1 },
                    { data: 'email', name: 'email', orderable: false, responsivePriority: 2 },
                    { data: 'mobile', name: 'mobile', orderable: false, responsivePriority: 2 },
                    { data: 'license', name: 'license', orderable: false, responsivePriority: 2 },
                    { data: 'status', name: 'status', orderable: false, responsivePriority: 2 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 3 },
                ]
            });
        });

        if(document.getElementById('frmAddServiceProvider')) {
            $('#frmAddServiceProvider').submit(function(e){
                let first_name = $('input[name="first_name"]').val();
                let last_name = $('input[name="last_name"]').val();
                let email = $('#email').val();
                let mobile = $('#mobile').val();
                let title = $('#title').val();
                let license = $('#license').val();

                // Validate Form
                let flag = true;
                const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(first_name === "") {
                    $('#err_fn').html('Please enter first name');
                    $('#first_name').focus();
                    flag = false;
                    return false;
                }
                if(last_name === "") {
                    $('#err_ln').html('Please enter last name');
                    $('#last_name').focus();
                    flag = false;
                    return false;
                }
                if(email == "") {
                    $('#err_email').html('Please enter email');
                    $('#email').focus();
                    flag = false;
                    return false;
                }
                if(email.length > 0 && !regex.test(email)) {
                    $('#err_email').html('Please enter valid email');
                    $('#email').focus();
                    flag = false;
                    return false;
                }
                if(mobile == "") {
                    $('#err_mobile').html('Please enter valid mobile');
                    $('#mobile').focus();
                    flag = false;
                    return false;
                }
                if(mobile.length > 0 && !mobileRegex.test(mobile)) {
                    $('#err_mobile').html('Please enter valid mobile');
                    $('#mobile').focus();
                    flag = false;
                    return false;
                }
                if(title == "") {
                    $('#err_title').html('Please choose title');
                    $('#title').focus();
                    flag = false;
                    return false;
                }
                if(license == "") {
                    $('#err_license').html('Please enter License');
                    $('#license').focus();
                    flag = false;
                    return false;
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

                let postData = {
                    first_name:first_name,
                    last_name: last_name,
                    email: email,
                    mobile: mobile,
                    title: title,
                    license: license
                };
                if(!flag) {
                    e.preventDefault();
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.add.service.provider")}}',
                    data: postData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnServiceProviderSubmit').hide();
                        $('#loaderSPSub').removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $('#btnServiceProviderSubmit').show();
                            $('#loaderSPSub').addClass('d-none');
                            // Reset fields
                            $('#first_name').val('');
                            $('#last_name').val('');
                            $('#email').val('');
                            $('#mobile').val('');
                            $('#title').val('');
                            $('#license').val('');
                            $('#service-provider-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                            $('#addServiceProviderPop').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                        } else if (html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                        }
                    }
                });
            })
        }

        // View Service Provider Detail in popup
        const viewProviderDetail = (id) => {
            $.ajax({
                type: 'get',
                url: '{{route("admin.view.service.provider")}}',
                data: {id: id},
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    // $('#btnServiceProviderSubmit').hide();
                    // $('#loaderSPSub').removeClass('d-none');
                },
                success: function(html) {
                    if (html.status == 200) {
                        // Fill the fields by Server Response
                        $('input[name="id"]').val(html.data.id);
                        $('#e_first_name').val(html.data.first_name);
                        $('#e_last_name').val(html.data.last_name);
                        $('#e_email').val(html.data.email);
                        $('#e_mobile').val(html.data.mobile);
                        $('#e_title').val(html.data.title);
                        $('#e_license').val(html.data.license);
                    }
                }
            });
        };

        // Send update request to server for update Service Provider Detail
        if(document.getElementById('frmEditServiceProvider')) {
            $('#frmEditServiceProvider').on('submit', function(e){
                let first_name = $('input[name="e_first_name"]').val();
                let last_name = $('input[name="e_last_name"]').val();
                let email = $('#e_email').val();
                let mobile = $('#e_mobile').val();
                let title = $('#e_title').val();
                let license = $('#e_license').val();

                // Validate Form
                let flag = true;
                const mobileRegex = /^(\d{10}|\d{3}[\s-]\d{3}[\s-]\d{4}|\d{6}[\s-]\d{4}|\d{3}[\s-]\d{7})$/;
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(first_name === "") {
                    $('#err_e_fn').html('Please enter first name');
                    $('#e_first_name').focus();
                    flag = false;
                    return false;
                }
                if(last_name === "") {
                    $('#err_e_ln').html('Please enter last name');
                    $('#e_last_name').focus();
                    flag = false;
                    return false;
                }
                // console.log(`${first_name} <=> ${last_name}`);
                if(email == "") {
                    $('#err_e_email').html('Please enter email');
                    $('#e_email').focus();
                    flag = false;
                    return false;
                }
                if(email.length > 0 && !regex.test(email)) {
                    $('#err_e_email').html('Please enter valid email');
                    $('#e_email').focus();
                    flag = false;
                    return false;
                }
                if(mobile == "") {
                    $('#err_mobile').html('Please enter valid mobile');
                    $('#e_mobile').focus();
                    flag = false;
                    return false;
                }
                if(mobile.length > 0 && !mobileRegex.test(mobile)) {
                    $('#err_mobile').html('Please enter valid mobile');
                    $('#e_mobile').focus();
                    flag = false;
                    return false;
                }
                if(title == "") {
                    $('#err_e_title').html('Please choose title');
                    $('#e_title').focus();
                    flag = false;
                    return false;
                }
                if(license == "") {
                    $('#err_e_license').html('Please enter License');
                    $('#e_license').focus();
                    flag = false;
                    return false;
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

                let postData = {
                    id: $('input[name="id"]').val(),
                    first_name:first_name,
                    last_name: last_name,
                    email: email,
                    mobile: mobile,
                    title: title,
                    license: license
                };
                if(flag) {
                    $.ajax({
                        type: 'post',
                        url: '{{route("admin.update.service.provider")}}',
                        data: postData,
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#btnEServiceProviderSubmit').hide();
                            $('#loaderESPSub').removeClass('d-none');
                        },
                        success: function(html) {
                            if (html.status == true) {
                                $('#btnEServiceProviderSubmit').show();
                                $('#loaderESPSub').addClass('d-none');
                                // Reset fields
                                $('#e_first_name').val('');
                                $('#e_last_name').val('');
                                $('#e_email').val('');
                                $('#e_mobile').val('');
                                $('#e_title').val('');
                                $('#e_license').val('');
                                $('#service-provider-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                                $('#editServiceProviderPop').modal('hide');
                                Toast.fire({
                                    icon: 'success',
                                    title: html.message
                                });
                            } else if (html.status == false) {
                                Toast.fire({
                                    icon: 'error',
                                    title: `${html.message} ${html.error}`
                                });
                            }
                        }
                    })
                }
                else {
                    e.preventDefault();
                    return false;
                }
            });
        }

        const updateProviderStatus = (id) => {
            $.ajax({
                type: 'POST',
                url: '{{route("admin.provider.status")}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {id: id},
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(html) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                    if (html.status == true) {
                        Toast.fire({
                            icon: 'success',
                            title: html.msg
                        });
                        $('#service-provider-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                    }
                    if (html.status == false) {
                        Toast.fire({
                            icon: 'error',
                            title: html.msg
                        });
                    }
                },
                error: function (xhr) {
                    if(xhr.status == 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            Toast.fire({
                                icon: 'error',
                                title: value[0]
                            });
                            
                        });
                    }
                }
            });
        };
    </script>
    @endif

    @if(Route::currentRouteName() === 'admin.weekly.schedule')
    <script>
        const st_tm = flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });
        
        const ed_tm = flatpickr("#end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });
        
        const lun_tm = flatpickr("#lunch_start", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });
        const lun_ed = flatpickr("#lunch_end", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });
        const editWeeklySchedule = (id) =>{
            $.ajax({
                type: 'get',
                url: '{{route("admin.view.weekly.schedule")}}',
                data: {id: id},
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    // $('#btnServiceProviderSubmit').hide();
                    // $('#loaderSPSub').removeClass('d-none');
                },
                success: function(html) {
                    if (html.status == 200) {
                        // Fill the fields by Server Response
                        let weekdayname = {
                            1: 'Monday', 
                            2: 'Tuesday', 
                            3: 'Wednesday', 
                            4: 'Thursday', 
                            5: 'Friday', 
                            6: 'Saturday',
                            7: 'Sunday'
                        };
                        $('#varyingEditServiceProviderLabel').html(`Edit ${weekdayname[html.data.day_of_week]} Schedule`)
                        let is_closed = html.data.is_closed;
                        $('input[name="id"]').val(html.data.id);
                        $('#day_of_week').val(weekdayname[html.data.day_of_week]);
                        $(`input[name="is_closed"][value="${is_closed}"]`).prop('checked', true);
                        if(is_closed == 1) {
                            $('#sted_tm, #lnh_tm').hide();
                            $('#start_time').val('');
                            $('#end_time').val('');
                            $('#lunch_start').val('');
                            $('#lunch_end').val('');
                        }
                        else {
                            $('#sted_tm, #lnh_tm').show();
                            $('#start_time').val(html.data.start_time);
                            $('#end_time').val(html.data.end_time);
                            $('#lunch_start').val(html.data.lunch_start);
                            $('#lunch_end').val(html.data.lunch_end);
                        }
                    }
                }
            });
        };

        $(`input[name="is_closed"]`).on('change', function(){
            let selected_val = $(this).val();
            if(selected_val == 1) {
                $('#sted_tm, #lnh_tm').hide();
            }
            else {
                $('#sted_tm, #lnh_tm').show();
            }
        })
        
        if(document.getElementById('frmEditWeeklySchedule')) {
            $('#frmEditWeeklySchedule').on('submit', function(e){
                $.ajax({
                    type: 'POST',
                    url: '{{route("admin.update.weekly.schedule")}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('form' + '#frmEditWeeklySchedule').serialize(),
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnWekSchSubmit').hide();
                        $("#loaderWekSch").removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == 202) {
                            $("#editWeeklySchedulePop").modal('hide');
                            $('#btnWekSchSubmit').show();
                            $("#loaderWekSch").addClass('d-none');
                            
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 4000);
                        }
                        if(html.status == 422) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                            
                            $('#btnWekSchSubmit').show();
                            $("#loaderWekSch").addClass('d-none');
                        }
                    },
                    error: function (xhr) {
                        if(xhr.status == 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $(`#err_${key}`).html(value[0]);
                            });
                            $('#btnWekSchSubmit').show();
                            $("#loaderWekSch").addClass('d-none');
                        }
                    }
                });
            });
        }
    </script>
    @endif


    @if(Route::currentRouteName() == 'admin.blocktime')
    <script>
        $(document).ready(function (){
            $('#blocktimerange-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                // order: [[2, 'asc']], // default order here
                ajax: {
                    url: "{{ route('admin.blocktime.list') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'type', name: 'type', orderable: true, responsivePriority: 1 },
                    { data: 'dayname', name: 'day_of_week', orderable: false, responsivePriority: 1 },
                    { data: 'start_date', name: 'start_date', orderable: false, responsivePriority: 2 },
                    { data: 'end_date', name: 'end_date', orderable: false, responsivePriority: 2 },
                    { data: 'start_time', name: 'start_time', orderable: false, responsivePriority: 2 },
                    { data: 'end_time', name: 'end_time', orderable: false, responsivePriority: 2 },
                    { data: 'is_closed', name: 'is_full_day', orderable: false, responsivePriority: 2 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 3 }
                ]
            });

            $('#start_date').datepicker({
                format: "M dd, yyyy",
                startDate: "today",
                autoclose: true,
                todayHighlight: true
            });

            $('#end_date').datepicker({
                format: "M dd, yyyy",
                startDate: "today",
                autoclose: true,
                todayHighlight: true
            });

            // Refresh the parent window on close the popup.
            $('#addBlockTmRngPop').on('hidden.bs.modal', function () {
                window.location.href = '{{ route("admin.blocktime") }}';
            });
        });
        const st_tm_pckr = flatpickr("#st_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });
        const ed_tm_pckr = flatpickr("#ed_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });

        $('#block_type').on('change', function (){
            $('#start_date').val('');
            $('#end_date').val('');
            $('#st_time').val('');
            $('#ed_time').val('');
            manageDateFields();
            $(`input[name="is_full_day"]`).prop('checked', false);
            $('#dat_div').addClass('d-none');
            if($('#block_type').val() == 'date' || $('#block_type').val() == 'range') {
                $('#day_of_week').attr('disabled', true);
                $('#day_of_week').val('');
                $('#isfullday_div').removeClass('d-none');
                
            }
            else {
                $('#day_of_week').removeAttr('disabled');
                $('#isfullday_div').addClass('d-none');
                $('#dat_div').addClass('d-none');
                $('#tim_div').addClass('d-none');

            }

            if($('#block_type').val() == 'date') {
                $('#day_of_week').val('');
                $('#day_of_week').attr('disabled', true);
                $('#isfullday_div').removeClass('d-none');
                $(`input[name="is_full_day"]`).prop('checked', false);
                $('#end_date').attr('readonly', true);
                $('#dat_div').addClass('d-none');
                $('#tim_div').addClass('d-none');

            }
            else {
                $('#end_date').removeAttr('readonly');
            }

            if(!$('#isfullday_div').hasClass('d-none') && $('input[name="is_full_day"]:checked').val() == 0 && $('#block_type').val() == 'date') {
                $('#stdspn').html('(Enter only start date.)');
                $('#stdspn').css('color', '#ff0000');
                $('#end_date').addClass('blk_enddt');
            }
            else {
                $('#stdspn').html('');
                $('#end_date').removeClass('blk_enddt');
            }
        });

        $(`input[name="is_full_day"]`).on('change', function(){
            let selected_val = $(this).val();
            let week_day = $('#day_of_week').val();
            manageDateFields();
            if(selected_val == 1 && week_day != '' && $('#block_type').val() == 'weekly') {
                // make empty below fields
                $('#start_date').val('');
                $('#end_date').val('');
                $('#st_time').val('');
                $('#ed_time').val('');
                $('#dat_div, #tim_div').addClass('d-none');
                // $('#tim_div').removeClass('d-none');
            }
            if(selected_val == 1 && week_day == '' && $('#block_type').val() == 'date') {
                // make empty below fields
                $('#start_date').val('');
                $('#end_date').val('');
                $('#st_time').val('');
                $('#ed_time').val('');
                $('#tim_div').addClass('d-none');
                $('#dat_div').removeClass('d-none');
            }
            if(selected_val == 1 && $('#block_type').val() == 'range') {
                $('#tim_div').addClass('d-none');
                $('#dat_div').removeClass('d-none');
            }
            if(selected_val == 0 && week_day == '') {
                if($('#block_type').val() == 'date') {
                    $('#stdspn').html('(Enter only start date.)');
                    $('#stdspn').css('color', '#ff0000');
                }
                else {
                    $('#stdspn').html('');
                }
                $('#dat_div, #tim_div').removeClass('d-none');
            }
            if(selected_val == 0 && week_day != '') {
                $('#tim_div').removeClass('d-none');
                $('#dat_div').removeClass('d-none');
            }
        });

        $('#day_of_week').on('change', function(){
            $('#isfullday_div').removeClass('d-none');
            $(`input[name="is_full_day"]`).prop('checked', false);
            $('#start_date').val('');
            $('#end_date').val('');
            $('#st_time').val('');
            $('#ed_time').val('');
            $('#dat_div, #tim_div').addClass('d-none');
        });

        $('#start_date').on('change', function (){
            if($('#block_type').val() == 'date') {
                if($('#start_date').val() != '') {
                    $('#end_date').val($('#start_date').val());
                }
            }
        });

        function manageDateFields() {
            let blockType = $('#block_type').val();
            let fullDay = $('input[name="is_full_day"]:checked').val();

            $('#start_date').val('');
            $('#end_date').val('');

            // YES + DATE
            if ((fullDay == '1' || fullDay == '0') && blockType == 'date') {
                $('#end_date').closest('.col-md-6').hide();
            }

            // NO + RANGE
            if (fullDay == '0' && blockType == 'range') {
                $('#end_date').closest('.col-md-6').show();
            }
        }

        $('#frmAddBlockTimeRange').on('submit', function(e){
            let flag = true;
            let block_type = $('#block_type').val();
            let day_of_week = $('#day_of_week').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();

            if(block_type == "")
            {
                $('#err_blktyp').html('Please choose Block Type');
                $('#block_type').focus();
                flag = false;
                return false;
            }

            if(block_type == 'weekly') {
                // Day of Week Mandatory
                if(day_of_week == "") {
                    $('#err_dow').html('Please choose day');
                    $('#day_of_week').focus();
                    flag = false;
                    return false;
                }
            }

            if(block_type == 'date' || block_type == 'range') {
                // Start And End Date Mandatory
                if(start_date == "") {
                    $('#err_stdt').html('Please enter Start Date');
                    $('#start_date').focus();
                    flag = false;
                    return false;
                }
                if(end_date == "") {
                    $('#err_ed_date').html('Please enter End Date');
                    $('#end_date').focus();
                    flag = false;
                    return false;
                }
            }
            if(!flag) {
                e.preventDefault();
                return false;
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: '{{route("admin.add.blocktime")}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('form' + '#frmAddBlockTimeRange').serialize(),
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnBlockTmSubmit').hide();
                        $("#loaderABlkTm").removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $("#addBlockTmRngPop").modal('hide');
                            $('#btnBlockTmSubmit').show();
                            $("#loaderABlkTm").addClass('d-none');
                            
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                    },
                    error: function (xhr){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                        if(xhr.status == 422) {
                            const error = xhr.responseJSON.message;
                            $('#server_err').html(error);
                            $('#btnBlockTmSubmit').show();
                            $("#loaderABlkTm").addClass('d-none');
                        }
                    }
                });
            }

        });

        // Delete Block orverride 
        const deleteBlockTime = (id) => {
            let url = '{{ route("admin.delete.blocktime") }}';
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
            Swal.fire({
                title: "Are you sure?",
                text: 'Delete the Block time range record',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!",
                cancelButtonText: "No"
                })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {id: id},
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {},
                        success: function(html) {
                            if (html.status == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: html.message
                                });
                                $('#blocktimerange-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                            }
                            if(html.status == false) {
                                Toast.fire({
                                    icon: 'error',
                                    title: html.message
                                });
                            }
                        }
                    });
                }
            });
        };
    </script>
    @endif

    @if(Route::currentRouteName() == 'admin.date.overrride')
    <script>
        const cus_tm_pckr = flatpickr("#cus_st_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });
        
        const cus_etm_pckr = flatpickr("#cus_ed_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format; use "h:i K" for 12-hour with AM/PM
            minuteIncrement: 30
        });

        $(document).ready(function (){
            $('#date-override-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                // order: [[2, 'asc']], // default order here
                ajax: {
                    url: "{{ route('admin.dateoverride.list') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'custom_date', name: 'date', orderable: true, responsivePriority: 1 },
                    { data: 'is_closed', name: 'is_closed', orderable: false, responsivePriority: 1 },
                    { data: 'custom_start_time', name: 'custom_start_time', orderable: false, responsivePriority: 2 },
                    { data: 'custom_end_time', name: 'custom_end_time', orderable: false, responsivePriority: 2 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 3 }
                ]
            });
        });

        $(`input[name="is_closed"]`).on('change', function(){
            let selected_val = $(this).val();
            if(selected_val == 1) {
                // make empty below fields
                $('#cus_st_time').val('');
                $('#cus_ed_time').val('');
                $('#dorr_tim_div').addClass('d-none');
            }
            else {
                $('#dorr_tim_div').removeClass('d-none');
            }
        });

        $('#frmDateOverride').on('submit', function(){
            let flag = true;
            let dt = $('#date').val();
            let custm_st = $('#cus_st_time');
            let custm_ed = $('#cus_ed_time');
            if(dt == '')
            {
                $('#err_date').html('Please choose date');
                $('#date').focus();
                flag = false;
                return false;
            }
            if($('input[name="is_closed"]:checked').val() == 0) {
                if(custm_st.val() == '') {
                    $('#err_cussttm').html('Please enter the Custom start time');
                    custm_st.focus();
                    flag = false;
                    return false;
                }
                if(custm_ed.val() == '') {
                    $('#err_cusedtm').html('Please enter the Custom end time');
                    custm_ed.focus();
                    flag = false;
                    return false;
                }
            }

            if(!flag) {
                e.preventDefault();
                return false;
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: '{{route("admin.add.override.date")}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('form' + '#frmDateOverride').serialize(),
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnDateOverrideSubmit').hide();
                        $("#loaderDtOvRi").removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $("#addDateOverridePop").modal('hide');
                            $('#btnDateOverrideSubmit').show();
                            $("#loaderDtOvRi").addClass('d-none');
                            
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                    },
                    error: function (xhr){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                        if(xhr.status == 422) {
                            const error = xhr.responseJSON.message;
                            $('#server_err').html(error);
                            $('#btnDateOverrideSubmit').show();
                            $("#loaderDtOvRi").addClass('d-none');
                            // $.each(errors, function (key, value) {
                            //     // err_msg += `${value[0]}<br>`;
                            //     $(`#err_${key}`).html(value[0]);
                            // });
                            // $('#btnLog').show();
                            // $("#loader").addClass('d-none');
                        }
                    }
                });
            }


        });

        // Delete Block orverride 
        const deleteOverrideTime = (id) => {
            let url = '{{ route("admin.delete.override.date") }}';
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
            Swal.fire({
                title: "Are you sure?",
                text: 'Delete the orverride record',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!",
                cancelButtonText: "No"
                })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {id: id},
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {},
                        success: function(html) {
                            if (html.status == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: html.message
                                });
                                $('#date-override-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                            }
                            if(html.status == false) {
                                Toast.fire({
                                    icon: 'error',
                                    title: html.message
                                });
                            }
                        }
                    });
                }
            });
        };
    </script>
    @endif

    @if(Route::currentRouteName() == 'admin.email.templates')
    <script>
        $(document).ready(function(){
            $('#emailtemplates-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                // order: [[2, 'asc']], // default order here
                ajax: {
                    url: "{{ route('admin.email.templates.list') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false },
                    { data: 'template_name', name: 'template_name', orderable: true, responsivePriority: 1 },
                    { data: 'template_key', name: 'template_key', orderable: true, responsivePriority: 1 },
                    { data: 'subject', name: 'subject', orderable: false, responsivePriority: 2 },
                    { data: 'status', name: 'status', orderable: false, responsivePriority: 1 },
                    { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 2 }
                ]
            });
        });
    </script>
    @endif
  {{-- end::Script --}}
  @if(Route::currentRouteName() == 'admin.sms.templates')
  <script>
    $(document).ready(function(){
        $('#smstemplates-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            // order: [[2, 'asc']], // default order here
            ajax: {
                url: "{{ route('admin.sms.templates.list') }}",
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id', orderable: false },
                { data: 'template_name', name: 'template_name', orderable: true, responsivePriority: 1 },
                { data: 'sms_key', name: 'sms_key', orderable: true, responsivePriority: 1 },
                { data: 'status', name: 'status', orderable: false, responsivePriority: 1 },
                { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 2 }
            ]
        });

        $('#template_name').on('blur', function (){
            let tempname = $('#template_name').val();
            if(tempname.length > 0) {
                let formattedName = tempname.trim().toLowerCase().replace(/\s+/g, '_');
                $('input[name="sms_key"]').val(formattedName);
            }
        });

        $('#e_template_name').on('blur', function (){
            let tempname = $('#e_template_name').val();
            if(tempname.length > 0) {
                let formattedName = tempname.trim().toLowerCase().replace(/\s+/g, '_');
                $('input[name="e_sms_key"]').val(formattedName);
            }
        });

        $('#body').on('input', function (){
            let count = $(this).val().length;
            $('#sms_count').text(`Characters: ${count}`);
        });
        $('#e_body').on('input', function (){
            let count = $(this).val().length;
            $('#esms_count').text(`Characters: ${count}`);
        });

        if(document.getElementById('frmAddSMS')) {
            $('#frmAddSMS').on('submit', function(e){
                // Validate Form
                let flag = true;
                let temp_name = $('input[name="template_name"]').val();
                let sms_key = $('input[name="sms_key"]').val();
                let body = $('#body').val();

                if(temp_name == ''){
                    $('.err-template_name').html('Please enter template name');
                    $('input[name="template_name"]').focus();
                    flag = false;
                    return false;
                }
                if(body == '') {
                    $('.err-body').html('Please enter sms content here');
                    $('#body').focus();
                    flag = false;
                    return false;
                }
                if(!flag) {
                    e.preventDefault();
                    return false;
                }
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                let postData = {
                    template_name:temp_name,
                    sms_key: sms_key,
                    body: body
                };
                $.ajax({
                    type: 'post',
                    url: '{{route("admin.save.sms.template")}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: postData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnSmsSubmit').hide();
                        $('#a_loader').removeClass('d-none');
                    },
                    success: function(html) {
                        if (html.status == true) {
                            $('#btnSmsSubmit').show();
                            $('#a_loader').addClass('d-none');
                            // Reset fields
                            $('#template_name').val('');
                            $('#sms_key').val('');
                            $('#body').val('');
                            $('#smstemplates-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                            $('#addSMSTemplatePop').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: html.message
                            });
                        } else if (html.status == false) {
                            Toast.fire({
                                icon: 'error',
                                title: html.message
                            });
                        }
                    },
                    error: function (xhr) {
                        if(xhr.status == 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                Toast.fire({
                                    icon: 'error',
                                    title: value[0]
                                });
                                
                            });
                        }
                    }
                });
            });
        }

    });
    const editSmsTemplate = (id) => {
        let url = '{{ route("admin.edit.sms.template", ":id") }}';
        url = url.replace(':id', id);  
        $.ajax({
            type: 'GET',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            dataType: 'json',
            beforeSend: function() {},
            success: function(html) {
                if (html.status == true) {
                    $('input[name="id"]').val(html.data.id);
                    $('input[name=e_template_name]').val(html.data.template_name);
                    $('input[name="e_sms_key"]').val(html.data.sms_key);
                    $('#e_body').val(html.data.body);
                }
            }
        });
    };

    if(document.getElementById('frmEditSMS')) {
        $('#frmEditSMS').on('submit', function(e){
            // Validate Form
            let flag = true;
            let temp_name = $('input[name="e_template_name"]').val();
            let sms_key = $('input[name="e_sms_key"]').val();
            let body = $('#e_body').val();

            if(temp_name == ''){
                $('.error-template_name').html('Please enter template name');
                $('#e_template_name').focus();
                flag = false;
                return false;
            }
            if(body == '') {
                $('.error-body').html('Please enter sms content here');
                $('#e_body').focus();
                flag = false;
                return false;
            }
            if(!flag) {
                e.preventDefault();
                return false;
            }
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            let postData = {
                id: $('input[name="id"]').val(),
                template_name:temp_name,
                sms_key: sms_key,
                body: body
            };
            $.ajax({
                type: 'post',
                url: '{{route("admin.update.sms.template")}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: postData,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#btnESmsSubmit').hide();
                    $('#e_loader').removeClass('d-none');
                },
                success: function(html) {
                    if (html.status == true) {
                        $('#btnESmsSubmit').show();
                        $('#e_loader').addClass('d-none');
                        $('#smstemplates-table').DataTable().ajax.reload(null, false);  // reload DataTable without page refresh
                        $('#editSMSTemplatePop').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: html.message
                        });
                    } else if (html.status == false) {
                        Toast.fire({
                            icon: 'error',
                            title: html.message
                        });
                    }
                },
                error: function (xhr) {
                    if(xhr.status == 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            Toast.fire({
                                icon: 'error',
                                title: value[0]
                            });
                        });
                    }
                }
            });
        });
    }
  </script>
  @endif
  @if(Route::currentRouteName() == 'admin.add.sms.template' || Route::currentRouteName() == 'admin.edit.sms.template')
  
  @endif