<?php

namespace App\Services\InternetPackage\Exceptions;

class UserWalletAmountNotEnoughException extends \Exception
{

    public static function throw(): never
    {
        throw new self('User wallet amount is not enough.');
    }

}
