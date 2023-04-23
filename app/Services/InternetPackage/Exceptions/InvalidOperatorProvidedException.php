<?php

namespace App\Services\InternetPackage\Exceptions;

use App\Enums\Operator;

class InvalidOperatorProvidedException extends \Exception
{
    public static function throw(Operator $validOperator, Operator $providedOperator): never
    {
        throw new self("operator {$validOperator->value} is accepted. provided {$providedOperator->value}");
    }
}
