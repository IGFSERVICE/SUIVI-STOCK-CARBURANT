<?php

use Carbon\Carbon;

if (!function_exists('formatDateToYMD')) {
    function formatDateToYMD($date)
    {
        return Carbon::parse($date)->format('Y-d-m');
    }
}
