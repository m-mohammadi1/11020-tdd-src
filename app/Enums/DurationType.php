<?php

namespace App\Enums;

enum DurationType: string
{
    case DAY = 'day';

    case WEEK = 'week';

    case MONTH = 'month';

    case YEAR = 'year';
}
