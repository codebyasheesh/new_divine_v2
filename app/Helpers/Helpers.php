<?php

use App\Models\Invoice;
use App\Models\Setting;
use App\Models\Tax;

if(!function_exists('pr')) {
    function pr($data) {
        echo '<pre>';print_r($data); echo '</pre>';
    }
}

if(!function_exists('generateTimeSlots')) {
    function generateTimeSlots($start, $end, $interval = 30) {
        $slots = [];
        $current = strtotime($start);
        $end = strtotime($end);
        while ($current <= $end) {
            $slots[] = date('h:ia', $current);
            $current = strtotime("+{$interval} minutes", $current);
        }
        return $slots;
    }
}

if(!function_exists('get_formatted_date')) {
    function get_formatted_date($date, $format = 'd-M-Y') {
        return date($format, strtotime($date));
    }
}

if(!function_exists('getSetting')) {
    function getSetting() {
        $setting = Setting::first();
        return $setting;
    }
}

if(!function_exists('getTax')) {
    function getTax() {
        $tax = Tax::first();
        return $tax;
    }
}

if(!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber() {
        $prefix = '';
        $number = 16000;

        do {
            $invoiceNumber = $prefix . str_pad($number, 5, '0',STR_PAD_LEFT);
            $exists = Invoice::withTrashed()->where('invoice_number', $invoiceNumber)->exists();
            $number++;
        }
        while ($exists);

        return $invoiceNumber;
    }
}

if(!function_exists('newGenerateInvoiceNumber')) {
    function newGenerateInvoiceNumber($invoice_dt)
    {
        $prefix = $invoice_dt . '-';

        // Get all invoices (including soft deleted) for the date
        $invoices = Invoice::withTrashed()
            ->where('invoice_number', 'like', $prefix . '%')
            ->get(['invoice_number', 'deleted_at']);

        if ($invoices->isEmpty()) {
            return $prefix . '01';
        }

        $usedSequences = [];
        $deletedSequences = [];

        foreach ($invoices as $invoice) {
            $sequence = (int) explode('-', $invoice->invoice_number)[1];

            if ($invoice->deleted_at) {
                $deletedSequences[] = $sequence;
            } else {
                $usedSequences[] = $sequence;
            }
        }

        sort($deletedSequences);
        sort($usedSequences);

        // Try to reuse lowest deleted sequence not already active
        foreach ($deletedSequences as $seq) {
            if (!in_array($seq, $usedSequences)) {
                return $prefix . str_pad($seq, 2, '0', STR_PAD_LEFT);
            }
        }

        // Otherwise generate next increment
        $nextSequence = empty($usedSequences)
            ? 1
            : max($usedSequences) + 1;

        return $prefix . str_pad($nextSequence, 2, '0', STR_PAD_LEFT);
    }
}

if(!function_exists('getDayName')) {
    function getDayName($id) {
        $dayname_array = [1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'];
        return $dayname_array[$id];
    }
}

if(!function_exists('getDaysByFromToDate')) {
    function getDaysByFromToDate(string $from_date, string $to_date): int
    {
        // Convert the date strings to Unix timestamps (seconds since 1970-01-01)
        $from_timestamp = strtotime($from_date);
        $to_timestamp = strtotime($to_date);

        // Calculate the difference in seconds
        $time_difference_seconds = $to_timestamp - $from_timestamp;

        // Convert the difference from seconds to days
        // There are 86400 seconds in a day (60 * 60 * 24)
        $difference_in_days = $time_difference_seconds / 86400;

        // Add 1 to make the count "inclusive" (counting both the start and end date)
        $total_inclusive_days = (int) $difference_in_days + 1;

        return $total_inclusive_days;
    }
}

if(!function_exists('escapeString')) {
    function escapeString($string)
    {
        return preg_replace('/([\,;])/','\\\$1', str_replace("\n", "\\n", $string));
    }
}

if(!function_exists('generateOtp')) {
    function generateOtp()
    {
        $otp = random_int(100000, 999999); // It will generate 6 digit random code
        return $otp;
    }
}
    