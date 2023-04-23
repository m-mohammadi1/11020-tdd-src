<?php

namespace App\Services\InternetPackage\Interfaces;

use App\Models\InternetPackage;
use App\Models\Order;
use App\Models\User;

interface BuyInternetInterface
{

    public function buyPackageForUser(User $user, InternetPackage $package): Order;

}
