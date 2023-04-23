<?php

namespace App\Services\Http\Internet\Types;

enum Operator: string
{
    case MCI = 'mci';

    case MTN = 'mtn';

    case RIGHTEL = 'rightel';
}
