<?php

namespace App\Services\InternetPackage\Functionality;

use App\Enums\OrderStatus;
use App\Models\InternetPackage;
use App\Models\Order;
use App\Models\User;
use App\Services\Http\Internet\Interfaces\KaraneSyncInternetInterface;
use App\Services\Http\Internet\Types\Operator;
use App\Services\InternetPackage\Exceptions\InvalidOperatorProvidedException;
use App\Services\InternetPackage\Exceptions\UserWalletAmountNotEnoughException;
use App\Services\InternetPackage\Interfaces\BuyInternetInterface;
use App\Services\InternetPackage\SubServices\Discount\DiscountServiceInterface;
use Illuminate\Support\Facades\DB;

class BuyInternet implements BuyInternetInterface
{

    public function __construct(
        private KaraneSyncInternetInterface $internetPackageBuyService,
        private DiscountServiceInterface    $discountService,
    )
    {
    }

    public function buyPackageForUser(User $user, Operator $operator, InternetPackage $package): Order
    {
        if ($user->wallet_amount < $package->price) {
            UserWalletAmountNotEnoughException::throw();
        }

        if ($package->operator !== $operator) {
            InvalidOperatorProvidedException::throw($package->operator, $operator);
        }

        $response = $this->internetPackageBuyService->buyPackage(
            $user->getPhoneNumber(),
            $operator,
            $package->code
        );

        $order = Order::query()
            ->create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'api_order_id' => $response->orderId,
                'status' => $response->wasSuccessful ? OrderStatus::SUCCESS : OrderStatus::FAILURE,
                'operator' => $operator,
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
