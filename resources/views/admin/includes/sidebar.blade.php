<!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        {{-- begin::Sidebar Brand --}}
        <div class="sidebar-brand">
          {{-- begin::Brand Link --}}
          <a href="" class="brand-link">
            {{-- begin::Brand Image --}}
            <img
              src="{{asset('admin_assets/assets/img/divine-w-logo.png')}}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            {{-- end::Brand Image --}}
            {{-- begin::Brand Text --}}
            {{-- <span class="brand-text fw-light">Divine Touch</span> --}}
            {{-- end::Brand Text --}}
          </a>
          {{-- end::Brand Link --}}
        </div>
        {{-- end::Sidebar Brand --}}
        {{-- begin::Sidebar Wrapper --}}
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            {{-- begin::Sidebar Menu --}}
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.dashboard')?'active':'' }}">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.appointments') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.appointments')?'active':'' }}">
                  <i class="nav-icon bi bi-journal-bookmark"></i>
                  <p>Appointments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.pastappointment') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.pastappointment')?'active':'' }}">
                  <i class="nav-icon bi bi-journal-bookmark"></i>
                  <p>Past Appointments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ (Route::currentRouteName() == 'admin.day.time.schedule')?'active':'' }}">
                  <i class="nav-icon bi bi-journal-bookmark"></i>
                  <p>
                    Schedules
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  {{-- <li class="nav-item">
                    <a href="{{ route('admin.day.time.schedule') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.day.time.schedule')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Block TimeSlots</p>
                    </a>
                  </li> --}}
                  {{-- <li class="nav-item">
                    <a href="{{ route('admin.add_blockdatetime') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.add_blockdatetime')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Block Slots by Date</p>
                    </a>
                  </li>--}}
                  {{-- <li class="nav-item">
                    <a href="{{ route('admin.block_date_time') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.block_date_time')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Unblock Slots + Calendar</p>
                    </a>
                  </li> --}}
                  <li class="nav-item">
                    <a href="{{ route('admin.blockSchedules') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.blockSchedules')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Calendar</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{ route('admin.holiday') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.holiday')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Holiday List</p>
                    </a>
                  </li> --}}
                  <li class="nav-item">
                    <a href="{{ route('admin.weekly.schedule') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.weekly.schedule')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Weekly Schedule</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.blocktime') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.blocktime')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Block Time Range</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.date.overrride') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.date.orderride')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Date Orverride</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link {{ (Route::currentRouteName() == 'admin.invoices')?'active':'' }}">
                  <i class="nav-icon bi bi-list-check"></i>
                  <p>
                    Invoices
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.invoices') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.invoices')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>list</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.new_invoice') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.new_invoice')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Create</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.users')?'active':'' }}">
                  <i class="nav-icon bi bi-people-fill"></i>
                  <p>Client Profiles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.service.providers') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.service.providers')?'active':'' }}">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Service Providers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('services') }}" class="nav-link {{ (Route::currentRouteName() == 'services')?'active':'' }}">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Services</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ (Route::currentRouteName() == 'admin.report')?'active':'' }}">
                  <i class="nav-icon bi bi-file-earmark-text"></i>
                  <p>
                    Reports
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.report') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.report')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Customer Statement</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.multiple_customer') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.multiple_customer')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Multiple Customer Statement</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.revenue') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.revenue')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Revenue Statement</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.sales_tax') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.sales_tax')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sales Tax</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ (Route::currentRouteName() == 'admin.soap_notes')?'active':'' }}">
                  <i class="nav-icon bi bi-filetype-pdf"></i>
                  <p>
                    Soap Notes
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.soap_notes') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.soap_notes')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>list</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{ route('admin.generate_soapnote') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.generate_soapnote')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Generate Soap Note</p>
                    </a>
                  </li> --}}
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ (Route::currentRouteName() == 'admin.company_detail' || Route::currentRouteName() == 'admin.setting')?'active':'' }}">
                  <i class="nav-icon bi bi-filetype-pdf"></i>
                  <p>
                    Settings
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.profile', Auth::guard('admin')->user()->id) }}" class="nav-link {{ (Route::currentRouteName() == 'admin.setting')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Admin Settings</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.api.setting') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.api.setting')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>API Settings</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.system.settings') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.system.settings')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>System Settings</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.smtp.setting') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.smtp.setting')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>SMTP Setting</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.company_detail') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.company_detail')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Clinic Settings</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.setting') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.setting')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Basic Settings</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle-fill"></i>
                      <p>
                        Templates
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{ route('admin.email.templates') }}" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Email Templates</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('admin.sms.templates') }}" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>SMS Templates</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  
                  {{-- <li class="nav-item">
                    <a href="{{ route('admin.setting') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.setting')?'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Other Settings</p>
                    </a>
                  </li> --}}
                </ul>
              </li>
              {{-- <li class="nav-item">
                <a href="{{ route('admin.setting') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.setting')?'active':'' }}">
                  <i class="nav-icon bi bi-gear"></i>
                  <p>Settings</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="{{ route('admin.old_customer_data') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.old_customer_data')?'active':'' }}">
                  <i class="nav-icon bi bi-people-fill"></i>
                  <p>Old Customer Records</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.reservation_data') }}" class="nav-link {{ (Route::currentRouteName() == 'admin.reservation_data')?'active':'' }}">
                  <i class="nav-icon bi bi-people-fill"></i>
                  <p>Old Reservations</p>
                </a>
              </li> --}}
              
              {{--<li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>
                    Layout Options
                    <span class="nav-badge badge text-bg-secondary me-3">6</span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./layout/unfixed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Default Sidebar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Sidebar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/layout-custom-area.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Layout <small>+ Custom Area </small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/sidebar-mini.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/collapsed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini <small>+ Collapsed</small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/logo-switch.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini <small>+ Logo Switch</small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/layout-rtl.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Layout RTL</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-tree-fill"></i>
                  <p>
                    UI Elements
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./UI/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/icons.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Icons</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/timeline.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Timeline</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-pencil-square"></i>
                  <p>
                    Forms
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./forms/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General Elements</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Tables
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./tables/simple.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Simple Tables</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">EXAMPLES</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-box-arrow-in-right"></i>
                  <p>
                    Auth
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="./examples/lockscreen.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Lockscreen</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">DOCUMENTATIONS</li>
              <li class="nav-item">
                <a href="./docs/introduction.html" class="nav-link">
                  <i class="nav-icon bi bi-download"></i>
                  <p>Installation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/layout.html" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Layout</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/color-mode.html" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Color Mode</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-ui-checks-grid"></i>
                  <p>
                    Components
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/components/main-header.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Header</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./docs/components/main-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Sidebar</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-filetype-js"></i>
                  <p>
                    Javascript
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/javascript/treeview.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Treeview</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="./docs/browser-support.html" class="nav-link">
                  <i class="nav-icon bi bi-browser-edge"></i>
                  <p>Browser Support</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/how-to-contribute.html" class="nav-link">
                  <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                  <p>How To Contribute</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/faq.html" class="nav-link">
                  <i class="nav-icon bi bi-question-circle-fill"></i>
                  <p>FAQ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/license.html" class="nav-link">
                  <i class="nav-icon bi bi-patch-check-fill"></i>
                  <p>License</p>
                </a>
              </li>
              <li class="nav-header">MULTI LEVEL EXAMPLE</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>
                    Level 1
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Level 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li>
              <li class="nav-header">LABELS</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-danger"></i>
                  <p class="text">Important</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-warning"></i>
                  <p>Warning</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-info"></i>
                  <p>Informational</p>
                </a>
              </li>--}}
            </ul>
            {{-- end::Sidebar Menu  --}}
          </nav>
        </div>
        {{-- end::Sidebar Wrapper --}}
      </aside>
      {{-- end::Sidebar --}}