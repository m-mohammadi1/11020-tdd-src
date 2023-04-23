<?php

namespace App\Services\Http\Internet\Exceptions;

class InvalidPackageTypeException extends \Exception
{
    public static function throwBecauseInvalidType(): self
    {
        return new self('Invalid internet package type.');
    }
}
