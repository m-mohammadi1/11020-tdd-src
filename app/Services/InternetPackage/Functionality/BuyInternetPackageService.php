<?php

namespace App\Services\InternetPackage\Functionality;

use App\Enums\OrderStatus;
use App\Models\InternetPackage;
use App\Models\Order;
use App\Models\User;
use App\Services\Http\InternetPackage\Interfaces\KaraneInternetPackageBuyServiceInterface;
use App\Services\InternetPackage\Interfaces\BuyInternetPackageServiceInterface;
use App\Services\InternetPackage\Types\InternetPackageBuyResponse;

class BuyInternetPackageService implements BuyInternetPackageServiceInterface
{

    public function __construct(
        private KaraneInternetPackageBuyServiceInterface $internetPackageBuyService
    )
    {
    }

    public function buyPackageForUser(User $user, InternetPackage $package): Order
    {
        $response = $this->internetPackageBuyService->buyPackage(
            $user->getPhoneNumber(),
            $package->code
        );

        return Order::query()
            ->create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'api_order_id' => $response->orderId,
                'status' => $response->wasSuccessful ? OrderStatus::SUCCESS : OrderStatus::FAILURE,
            ]);
    }

}
