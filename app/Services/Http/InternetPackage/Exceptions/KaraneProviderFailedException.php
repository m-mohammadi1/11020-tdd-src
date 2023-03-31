<?php

namespace App\Services\Http\InternetPackage\Exceptions;

class KaraneProviderFailedException extends \Exception
{
    public static function throwBecauseGettingPackagesFailed(): self
    {
        return new self('Getting packages failed.');
    }
}
