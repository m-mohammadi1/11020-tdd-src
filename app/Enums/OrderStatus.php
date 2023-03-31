<?php

namespace App\Enums;

enum OrderStatus: string
{
    case SUCCESS = 'success';

    case FAILURE = 'failure';
}
