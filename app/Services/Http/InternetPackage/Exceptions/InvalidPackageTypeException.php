<?php

namespace App\Services\Http\InternetPackage\Exceptions;

class InvalidPackageTypeException extends \Exception
{
    public static function throwBecauseInvalidType(): self
    {
        return new self('Invalid internet package type.');
    }
}
