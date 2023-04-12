<?php

namespace App\Services\InternetPackage\Functionality;

use App\Enums\OrderStatus;
use App\Models\InternetPackage;
use App\Models\Order;
use App\Models\User;
use App\Services\Discount\DiscountServiceInterface;
use App\Services\Http\InternetPackage\Interfaces\KaraneInternetPackageBuyServiceInterface;
use App\Services\InternetPackage\Exceptions\UserWalletAmountNotEnoughException;
use App\Services\InternetPackage\Interfaces\BuyInternetPackageServiceInterface;
use Illuminate\Support\Facades\DB;

class BuyInternetPackageService implements BuyInternetPackageServiceInterface
{

    public function __construct(
        private KaraneInternetPackageBuyServiceInterface $internetPackageBuyService,
        private DiscountServiceInterface $discountService,
    )
    {
    }

    public function buyPackageForUser(User $user, InternetPackage $package): Order
    {
        if ($user->wallet_amount < $package->price) {
            UserWalletAmountNotEnoughException::throw();
        }

        $response = $this->internetPackageBuyService->buyPackage(
            $user->getPhoneNumber(),
            $package->code
        );

        $order = Order::query()
            ->create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'api_order_id' => $response->orderId,
                'status' => $response->wasSuccessful ? OrderStatus::SUCCESS : OrderStatus::FAILURE,
            ]);


        $this->updateUserWalletAmount($user, $package);


        return $order;
    }


    private function updateUserWalletAmount(User $user, InternetPackage $package): void
    {
        try {
            DB::beginTransaction();

            $user = User::query()
                ->lockForUpdate()
                ->find($user->id);

            $user->wallet_amount -= $package->getFinalPriceWithDiscount(
                $this->discountService->getInternetPackageDiscount()
            );
            $user->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

}
