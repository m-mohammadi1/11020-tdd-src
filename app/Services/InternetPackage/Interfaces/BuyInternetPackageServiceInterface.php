<?php

namespace App\Services\InternetPackage\Interfaces;

use App\Models\InternetPackage;
use App\Models\Order;
use App\Models\User;

interface BuyInternetPackageServiceInterface
{

    public function buyPackageForUser(User $user, InternetPackage $package): Order;

}
