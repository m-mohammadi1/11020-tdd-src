<?php

namespace App\Services\Http\Internet\Exceptions;

class KaraneProviderFailedException extends \Exception
{
    public static function throwBecauseGettingPackagesFailed(): self
    {
        return new self('Getting packages failed.');
    }
}
