<?php

namespace App\Services;

use Carbon\Carbon;

class Helper
{
    public static function generateYears(int $startYear = 1900): array
    {
        $currentYear = Carbon::now()->year;
        $years = range($startYear, $currentYear + 1);
        return array_reverse($years);
    }
}
