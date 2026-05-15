<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\admin\BlockDateTimeController;
use App\Http\Controllers\admin\BlockTimeRangeController;
use App\Http\Controllers\admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DateOverrideController;
use App\Http\Controllers\admin\DayTimeScheduleController;
use App\Http\Controllers\admin\EmailTemplateController;
use App\Http\Controllers\admin\HolidayListController;
use App\Http\Controllers\admin\InvoiceController;
use App\Http\Controllers\admin\OldCustomerController;
use App\Http\Controllers\admin\OldReservationController as AdminOldReservationController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\ServiceProviderController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\SmsTemplateController;
use App\Http\Controllers\admin\SoapNoteController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\WeeklyScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ThanksController;
use App\Http\Controllers\DashboardController as FrontendDashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaserHairRemovalController;
use App\Http\Controllers\MassageController;
use App\Http\Controllers\MedicalFormController;
use App\Http\Controllers\MicroneedlingController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SkinCareController;
use App\Http\Controllers\SquareWebhookController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Architecture\Services\ServiceContainer;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'guest'], function () {
   Route::get("/register", [HomeController::class, 'register'])->name('register'); 
   Route::get("/login", [HomeController::class, 'login'])->name('login');
   Route::post("/process-login", [HomeController::class, 'processLogin'])->name('process_login');
   Route::post("/process-register", [HomeController::class, 'processRegister'])->name('process_register');
   Route::get('/contact', [ContactController::class, 'index'])->name('contact');
   Route::get('/medical-form/{id}', [MedicalFormController::class, 'index'])->name('medical_form');
   Route::post('process-medical-form', [MedicalFormController::class, 'store'])->name('save_medical_form');

// Temporary Route
    Route::get('/book-appointment', [AppointmentController::class, 'index'])->name('book_appointment');
    Route::post('/check-availability', [AppointmentController::class, 'checkAvailability'])->name('check_availability');
    Route::post('/process-booking', [AppointmentController::class, 'processBooking'])->name('process_booking');
    Route::post('/get-register-user-detail', [AppointmentController::class, 'getRegisterDetail'])->name('get_or_register_user');
// End Here

   Route::get('/verify-email/{token}',[HomeController::class, 'verifyEmail'])->name('verify_email');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get("/sign-out", [HomeController::class, 'signOut'])->name('logout');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change_password');
    // Route::get('/book-appointment', [AppointmentController::class, 'index'])->name('book_appointment');
    // Route::post('/check-availability', [AppointmentController::class, 'checkAvailability'])->name('check_availability');
    // Route::post('/process-booking', [AppointmentController::class, 'processBooking'])->name('process_booking');
    Route::get('/my-account', [FrontendDashboardController::class, 'index'])->name('my_account');
    Route::post('/list-booking', [FrontendDashboardController::class, 'bookingListAjax'])->name('list_booking');
    Route::post('/cancel-booking', [FrontendDashboardController::class, 'cancelBookingByAjax'])->name('cancel_booking');
    Route::get('/waiting-appointment', [AppointmentController::class, 'waitingAppointment'])->name('waited_booking');
    Route::get('/family-member', [FrontendDashboardController::class, 'familyMembersByAjax'])->name('family_member');
    Route::get('/account-detail', [FrontendDashboardController::class, 'accountDetailByAjax'])->name('account_detail');
    Route::post('/update-account', [FrontendDashboardController::class, 'updateAccountDetailByAjax'])->name('update_account');
    Route::post('/add-member', [FrontendDashboardController::class, 'addMemberByAjax'])->name('add_family_member');
    Route::post('/add-individual-in-family', [FrontendDashboardController::class, 'addIndividualInFamilyRequest'])->name('add_individual_in_family_request');

    // Route::get('/medical-form/{id}', [MedicalFormController::class, 'index'])->name('medical_form');
    // Route::post('process-medical-form', [MedicalFormController::class, 'store'])->name('save_medical_form');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/laser-hair-removal', [LaserHairRemovalController::class, 'index'])->name('laser_hair_removal');
Route::get('/skin-care', [SkinCareController::class, 'index'])->name('skincare');
Route::get('/twist-microneedling', [MicroneedlingController::class, 'index'])->name('twist_microneedling');
Route::get('/massage-therapy', [MassageController::class, 'index'])->name('massage_therapy');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/price', [PriceController::class, 'index'])->name('price');
route::post('/process-sendmail', [ContactController::class, 'sendcontactmail'])->name('send.contact.mail');
Route::post('/checkemail-during-booking', [AppointmentController::class, 'validateEmail'])->name('check.email');
Route::post('/checkemail-otp', [AppointmentController::class, 'checkemailotp'])->name('check.emailotp');
Route::post('/send-mobile-otp', [AppointmentController::class, 'sendOtpOnMobile'])->name('send.mobile.otp');
Route::post('/check-early-date', [AppointmentController::class, 'checkearlydateforbooking'])->name('check.early.booking.date');
Route::post('/send-contact-email-otp', [ContactController::class, 'sendOtpEmail'])->name('send.contact.otp');
Route::post('/check-contact-otp', [ContactController::class, 'checkcontactemailotp'])->name('verify.contact.otp');
Route::post('/square/webhook', [SquareWebhookController::class, 'handle'])->name('square.webhook');
Route::get('/thanks', [ThanksController::class, 'index'])->name('thanks');

Route::post('/sentmedicalform-otp', [MedicalFormController::class, 'sendOtpMail'])->name('send.medicalform.otp');
Route::post('/verifiy-form-otp', [MedicalFormController::class, 'validateFormOTP'])->name('verify.otp');



// Admin Routes----------------

Route::group(['prefix' => 'admin'], function() {
    // Guest Middleware for Admin
    Route:: group(['middleware' => 'admin.guest'], function (){
        Route::get('/', [LoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('admin.authenticate');
        Route::get('/relogin', [LoginController::class, 'unsetOTPSessions'])->name('admin.relogin');
    });

    
    // Authenticated Middleware for Admin
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('event-list', [DashboardController::class, 'events'])->name('admin.event.list');
        Route::get('services', [ServiceController::class, 'index'])->name('services');

        Route::get('service-list', [ServiceController::class, 'getServicesList'])->name('admin.servicelist');

        Route::post('add-service', [ServiceController::class, 'add'])->name('admin.addservice');
        Route::get('show-service/{id}', [ServiceController::class, 'showService'])->name('admin.show_service');
        Route::post('update-service', [ServiceController::class, 'updateService'])->name('admin.update_service');
        Route::post('update-service-status', [ServiceController::class, 'updateStatus'])->name('admin.service_status');
        Route::get('service-price', [ServiceController::class, 'servicePrice'])->name('admin.find_price');
        Route::get('delete-service', [ServiceController::class, 'destroy'])->name('admin.deleteservice');
        Route::get('delete-related-services', [ServiceController::class, 'destroyAll'])->name('admin.services_destroy');

        Route::get('service-providers', [ServiceProviderController::class, 'index'])->name('admin.service.providers');
        Route::get('provider-list', [ServiceProviderController::class, 'list'])->name('admin.provider-list');
        Route::post('add-service-provider', [ServiceProviderController::class, 'add'])->name('admin.add.service.provider');
        Route::get('view-service-provider', [ServiceProviderController::class, 'view'])->name('admin.view.service.provider');
        Route::post('update-service-provider', [ServiceProviderController::class, 'update'])->name('admin.update.service.provider');
        Route::post('update-provider-status', [ServiceProviderController::class, 'updateStatus'])->name('admin.provider.status');
        Route::get('profile/{id}', [UserController::class, 'adminProfile'])->name('admin.profile'); // Show the form of Admin Profile.
        Route::post('update-admin-profile', [UserController::class, 'updateAdminProfile'])->name('admin.update_admin_profile');
        Route::post('update-password', [UserController::class, 'updatePassword'])->name('admin.update_password'); // This is for change password of Admin Person

        Route::get('users', [UserController::class, 'index'])->name('admin.users');
        Route::get('user-list', [UserController::class, 'list'])->name('admin.userlist');
        Route::get('view-user', [UserController::class, 'view'])->name('admin.viewuser');
        Route::get('delete-client', [UserController::class, 'delete'])->name('admin.deleteclient');
        Route::get('delete-related-client', [UserController::class, 'deleteRelatedClient'])->name('admin.delete_related_client');

        Route::get('user-profile/{id}', [UserController::class, 'profile'])->name('admin.userprofile');
        Route::get('download-medical-Detail/{id}', [UserController::class, 'downloadMedicalDetail'])->name('admin.download.medicaldetail');

        Route::post('add-user', [UserController::class, 'add'])->name('admin.adduser');
        Route::post('edit-user', [UserController::class, 'edit'])->name('admin.edituser');

        Route::get('family-members/{id}', [UserController::class, 'getFamilyMembers'])->name('admin.members');
        Route::post('add-member', [UserController::class, 'addMember'])->name('admin.addmember');
        Route::post('add-individual-as-member', [UserController::class, 'addIndividualPerson'])->name('admin.add.individual.as.member');
        Route::post('change-parent', [UserController::class, 'changeParent'])->name('admin.change.parent');
        Route::get('view-member-detail/{id}', [UserController::class, 'memberDetail'])->name('admin.viewmember');
        Route::post('update-member', [UserController::class, 'updateMember'])->name('admin.updatemember');
        Route::get('search-customer', [UserController::class, 'searchCustomer'])->name('admin.customer_search'); // this route is for ajax autocomplete search
        Route::get('search-individual', [UserController::class, 'searchIndividualCustomer'])->name('admin.search.individual');
        Route::post('family-email', [UserController::class, 'getFamilyEmail'])->name('admin.getFamilyEmail');
        Route::post('family-mobile', [UserController::class, 'getFamilyMobile'])->name('admin.getFamilyMobile');
        Route::post('remove-client', [UserController::class, 'removeMember'])->name('admin.remove_member');

        Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('admin.appointments');
        Route::get('appointment-list', [AdminAppointmentController::class, 'list'])->name('admin.appointmentlist');
        Route::get('appointment-status-update', [AdminAppointmentController::class, 'updateAppointmentStatus'])->name('admin.update_appointment_status');
        Route::get('add-appointment/{id?}', [AdminAppointmentController::class, 'add'])->name('admin.add.appointment');
        Route::post('check-booking-date', [AdminAppointmentController::class, 'checkAvailability'])->name('admin.check_availability');
        Route::post('editcase-check-booking-date', [AdminAppointmentController::class, 'checkAvailabilityInEdit'])->name('admin.in_edit.check_availability');
        Route::post('save-appointment', [AdminAppointmentController::class, 'save'])->name('admin.save_appointment');
        Route::get('edit-appointment/{id}', [AdminAppointmentController::class, 'edit'])->name('admin.edit_appointment');
        Route::post('update-appointment', [AdminAppointmentController::class, 'update'])->name('admin.update.appointment');
        Route::get('delete-appointment/{id}', [AdminAppointmentController::class, 'delete'])->name('admin.delete.appointment');
        Route::get('past-appointment', [AdminAppointmentController::class, 'pastAppointments'])->name('admin.pastappointment');
        Route::get('past-appointment-list', [AdminAppointmentController::class, 'pastAppointmentList'])->name('admin.past.appointment.list');

        // Schedule Module
        Route::get('day-time-schedule', [DayTimeScheduleController::class, 'index'])->name('admin.day.time.schedule');
        Route::get('add-daytime-schedule', [DayTimeScheduleController::class, 'add'])->name('admin.add_schedule');
        Route::get('get-schedule', [DayTimeScheduleController::class, 'checkSchedule'])->name('admin.get_schedule');
        Route::post('save-day-time-schedule', [DayTimeScheduleController::class, 'save'])->name('admin.save.daytime.schedule');
        Route::get('edit-daytime/{id}', [DayTimeScheduleController::class, 'edit'])->name('admin.daytime.edit');
        Route::get('delete-daytime-schedule', [DayTimeScheduleController::class, 'deleteDayTime'])->name('admin.deletedaytime');
        
        // Route::get('block-date-times', [BlockDateTimeController::class, 'index'])->name('admin.block_date_time');
        // Route::get('block-date-times-list', [BlockDateTimeController::class, 'list'])->name('admin.blockdatetimelist');
        // Route::get('calendar-dates', [BlockDateTimeController::class, 'calendarDates'])->name('admin.calendar_dates');
        Route::get('block-date-time', [BlockDateTimeController::class, 'addBlockDateTime'])->name('admin.add_blockdatetime');
        Route::get('get-block-time-of-date', [BlockDateTimeController::class, 'getBlockDateAndTime'])->name('admin.get_blockdate_and_time');
        Route::post('update-date-on-time', [BlockDateTimeController::class, 'saveBlockDate'])->name('admin.save_blockdate');
        Route::post('get-block-dates', [BlockDateTimeController::class, 'getBlockDatesById'])->name('admin.get_block_dates');
        Route::post('unblock-dates', [BlockDateTimeController::class, 'unBlockDatesOfTime'])->name('admin.unblock.datesof.time');
        // Route::get('add-holiday', [BlockDateTimeController::class, 'addHoliday'])->name('admin.add_holiday');
        Route::post('save-holiday', [HolidayListController::class, 'add'])->name('admin.save_holiday');
        Route::get('holiday', [HolidayListController::class, 'index'])->name('admin.holiday');
        Route::get('holiday-list', [HolidayListController::class, 'list'])->name('admin.holiday.list');
        Route::get('holiday-detail/{id}', [HolidayListController::class, 'view'])->name('admin.holiday.detail');
        Route::post('update-holiday', [HolidayListController::class,'update'])->name('admin.holiday.update');
        Route::post('delete-holiday', [HolidayListController::class, 'delete'])->name('admin.delete.holiday');


        // End Schedule Module

        Route::get('invoices', [InvoiceController::class, 'index'])->name('admin.invoices');
        Route::get('invoice-list', [InvoiceController::class, 'list'])->name('admin.invoice_list');
        Route::get('create-invoice/{booking_id}', [InvoiceController::class, 'invoiceForm'])->name('admin.invoice_form');
        
        Route::post('save-invoice', [InvoiceController::class, 'save'])->name('admin.save_invoice');
        Route::get('view-invoice/{id}', [InvoiceController::class, 'view'])->name('admin.view_invoice');

        Route::get('new-invoice', [InvoiceController::class, 'newInvoiceForm'])->name('admin.new_invoice');
        Route::get('invoice-service-row', [InvoiceController::class, 'addServiceRow'])->name('admin.invoice_service_row');
        Route::post('save-unlinked-invoice', [InvoiceController::class, 'saveUnLinkedInvoice'])->name('admin.save_unlinked_invoice');
        Route::get('edit-invoice/{id}', [InvoiceController::class, 'editNewInvoiceForm'])->name('admin.edit_invoice');
        Route::post('save-edit-invoice', [InvoiceController::class, 'saveEditedInvoice'])->name('admin.save_edit_invoice');
        Route::post('invoice-mail-popup', [InvoiceController::class, 'invoiceMailId'])->name('admin.invoice.mail.popup');
        Route::post('send-invoice', [InvoiceController::class, 'sendInvoice'])->name('admin.send_invoice');
        Route::get('delete-invoice/{id}', [InvoiceController::class, 'delete'])->name('admin.delete_invoice');
        Route::get('download-invoice/{id}', [InvoiceController::class, 'download'])->name('admin.download.invoice');
        Route::get('copy-invoice/{id}', [InvoiceController::class, 'showCopyInvoiceForm'])->name('admin.copy_invoice');
        Route::get('send-payment-link/{id}', [InvoiceController::class, 'sendGeneratedPaymentLnk'])->name('admin.send_pay_lnk');


        Route::get('record-payment/{invoice_id}', [PaymentController::class, 'recordPayment'])->name('admin.recordpayment');
        Route::post('save-record-payment', [PaymentController::class, 'saveRecordPayment'])->name('admin.save_payment');

        Route::get('send-medical-form/{booking_id}', [AdminAppointmentController::class, 'sendMedicalForm'])->name('admin.sendmedicalform');
        Route::get('appointment-detail/{id}', [AdminAppointmentController::class, 'viewBookingDetail'])->name('admin.viewbookingdetail');

        // Report Routes
        Route::get('reports', [ReportController::class, 'index'])->name('admin.report');
        Route::get('customer-report', [ReportController::class, 'customerReport'])->name('admin.customer_report');
        Route::post('customer-statement-download', [ReportController::class, 'customerStatementDownload'])->name('admin.customer_report_download');
        Route::get('revenue', [ReportController::class, 'revenue'])->name('admin.revenue');
        Route::post('revenue-statement', [ReportController::class, 'revenueStatement'])->name('admin.revenue_statement');
        Route::get('sales-tax', [ReportController::class, 'salesTax'])->name('admin.sales_tax');
        Route::post('sales-tax-statement', [ReportController::class, 'salesTaxStatement'])->name('admin.sales_tax_statement');
        Route::get('multiple-customer', [ReportController::class, 'multipleCustomer'])->name('admin.multiple_customer');
        Route::post('multiple-customer-statement', [ReportController::class, 'multipleCustomerStatement'])->name('admin.multiple_customer_statement');
        Route::post('customer-email-statement', [ReportController::class, 'sendStatementToCustomer'])->name('admin.email_customer_statement');
        Route::get('customer-report/print', [ReportController::class, 'printCustomerReport'])->name('admin.customer.report.print');
        Route::post('multiple-customer-report-download', [ReportController::class, 'multipleCustomerStatementDownload'])->name('admin.multiple.customer.statement.download');
        Route::post('multiple-customer-report-send', [ReportController::class, 'multipleCustomerStatementEmail'])->name('admin.multiple.customer.statement.send');
        Route::get('multiple-customer-report/print', [ReportController::class, 'printMultipleCustomerReport'])->name('admin.multiple.customer.report.print');
        Route::post('excel-customer-report', [ReportController::class, 'customerStatementExcelDownload'])->name('admin.customer_report_excel_download');
        Route::post('multiple-customer-report', [ReportController::class, 'multipleCustomerStatementExcelDownload'])->name('admin.multiple.customer.excel.download');
        Route::post('revenue-excel-download', [ReportController::class, 'revenueExcelDownload'])->name('admin.revenue.excel.statement.download');
        Route::post('revenue-pdf-download', [ReportController::class, 'revenuePdfDownload'])->name('admin.revenue.pdf.statement.download');
        Route::get('revenue-chart', [ReportController::class, 'revenueChart'])->name('admin.revenuechart');
        // Route::get('revenue-chart-list', [ReportController::class, 'revenueChartData'])->name('admin.revenuechart.data');

        // Old Customer Data and Reservation Data
        Route::get('old-customer-data', [OldCustomerController::class, 'index'])->name('admin.old_customer_data');
        Route::get('old-customer-list', [OldCustomerController::class, 'list'])->name('admin.old_customer_list');

        Route::get('reservation-data', [AdminOldReservationController::class, 'index'])->name('admin.reservation_data');
        Route::get('old-reservation-list', [AdminOldReservationController::class, 'list'])->name('admin.old_reservation_list');
        // End Old Customer Data and Reservation Data

        // Generate Soap Note 
        Route::get('soap-notes', [SoapNoteController::class, 'index'])->name('admin.soap_notes');
        Route::get('generate-soap-note/{id}', [SoapNoteController::class, 'generateSoapNote'])->name('admin.generate_soapnote');
        Route::post('generate-soapnote-pdf',[SoapNoteController::class, 'generateSoapNotePDF'])->name('admin.generate_soap_note_pdf');
        Route::get('download-soap/{filename}', [SoapNoteController::class, 'download'])->name('admin.download_soap');
        Route::get('delete-soapnote/{filename}', [SoapNoteController::class, 'delete'])->name('admin.delete_soapnote');
        // End To Generate Soap Note

        Route::get('settings', [SettingController::class, 'index'])->name('admin.setting');
        Route::post('update-setting', [SettingController::class, 'updateSetting'])->name('admin.update_setting');
        Route::get('company-detail', [SettingController::class, 'companyDetail'])->name('admin.company_detail');
        Route::post('update-company-detail', [SettingController::class, 'updateCompanyDetail'])->name('admin.update_company_detail');
        Route::get('system-settings', [SettingController::class, 'systemSettings'])->name('admin.system.settings');
        Route::post('update-system-settings', [SettingController::class, 'updateSystemSettings'])->name('admin.update.system.settings');
        Route::get('api-setting', [SettingController::class, 'apiSetting'])->name('admin.api.setting');
        Route::post('update-api', [SettingController::class, 'updateApi'])->name('admin.update.api');
        Route::get('smtp-setting', [SettingController::class, 'smtpSetting'])->name('admin.smtp.setting');
        Route::post('update-smtp', [SettingController::class, 'updatesmtp'])->name('admin.update.smtp');
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

        // Weekly Schedule Routes
        Route::get('weekly-schedules', [WeeklyScheduleController::class, 'index'])->name('admin.weekly.schedule');
        Route::get('view-weekly-schedule', [WeeklyScheduleController::class, 'view'])->name('admin.view.weekly.schedule');
        Route::post('update-weekly-schedule', [WeeklyScheduleController::class, 'update'])->name('admin.update.weekly.schedule');

        // Block Time Range
        Route::get('block-time-range', [BlockTimeRangeController::class, 'index'])->name('admin.blocktime');
        Route::get('block-time-range-list', [BlockTimeRangeController::class, 'list'])->name('admin.blocktime.list');
        Route::post('add-block-time-range', [BlockTimeRangeController::class, 'add'])->name('admin.add.blocktime');
        Route::get('delete-blocktime-date', [BlockTimeRangeController::class, 'delete'])->name('admin.delete.blocktime');
        Route::get('schedule-fullcalendar-page', [BlockTimeRangeController::class, 'blockSchedules'])->name('admin.blockSchedules');
        Route::get('schedule-fullcalendar', [BlockTimeRangeController::class, 'scheduleFullCalendar'])->name('admin.schedule.fullcalendar');

        Route::get('date-orverride', [DateOverrideController::class, 'index'])->name('admin.date.overrride');
        Route::get('date-orverride-list', [DateOverrideController::class, 'list'])->name('admin.dateoverride.list');
        Route::post('add-override-date', [DateOverrideController::class, 'add'])->name('admin.add.override.date');
        Route::get('delete-override-date', [DateOverrideController::class, 'delete'])->name('admin.delete.override.date');

        // Email Template Routes
        Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('admin.email.templates');
        Route::get('email-template-list', [EmailTemplateController::class, 'list'])->name('admin.email.templates.list');
        Route::get('add-email-template', [EmailTemplateController::class, 'add'])->name('admin.add.email.template');
        Route::get('edit-email-template/{id}', [EmailTemplateController::class, 'edit'])->name('admin.edit.email.template');
        Route::post('save-email-template', [EmailTemplateController::class, 'save'])->name('admin.save.email.template');
        Route::post('update-email-template', [EmailTemplateController::class, 'update'])->name('admin.update.email.template');
        Route::get('update-email-status/{id}', [EmailTemplateController::class, 'updateEmailStatus'])->name('admin.email.status');

        // SMS Templae Routes
        Route::get('sms-templates', [SmsTemplateController::class, 'index'])->name('admin.sms.templates');
        Route::get('sms-template-list', [SmsTemplateController::class, 'list'])->name('admin.sms.templates.list');
        Route::get('edit-sms-template/{id}', [SmsTemplateController::class, 'edit'])->name('admin.edit.sms.template');
        Route::post('save-sms-template', [SmsTemplateController::class, 'save'])->name('admin.save.sms.template');
        Route::post('update-sms-template', [SmsTemplateController::class, 'update'])->name('admin.update.sms.template');
        Route::get('update-sms-status/{id}', [SmsTemplateController::class, 'updateSmsStatus'])->name('admin.sms.status');
        
    });
});