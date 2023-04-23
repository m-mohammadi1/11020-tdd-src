<?php

namespace App\Services\InternetPackage\Interfaces;

use App\Models\InternetPackage;
use App\Models\Order;
use App\Models\User;
use App\Services\Http\Internet\Types\Operator;

interface BuyInternetInterface
{
    public function buyPackageForUser(User $user, Operator $operator, InternetPackage $package): Order;

}
