<?php

namespace Tests\Feature\Internet;

use App\Enums\OrderStatus;
use App\Models\InternetPackage;
use App\Models\User;
use App\Services\Http\Internet\Types\Operator;
use App\Services\InternetPackage\Exceptions\InvalidOperatorProvidedException;
use App\Services\InternetPackage\Exceptions\UserWalletAmountNotEnoughException;
use App\Services\InternetPackage\Interfaces\BuyInternetInterface;
use App\Services\InternetPackage\Interfaces\GetInternetInterface;
use App\Services\InternetPackage\SubServices\Discount\DiscountServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class InternetPackageBuyProcessTest extends TestCase
{
    use RefreshDatabase;

    private Operator $operator;

    protected function setUp(): void
    {
        parent::setUp();

        resolve(GetInternetInterface::class)
            ->syncInternetPackagesInSystem();

        $this->operator = Operator::MCI;
    }

    public function test_can_buy_packages_from_provider()
    {
        $packagge = InternetPackage::query()->where('operator', $this->operator)->first();

        $user = User::factory()
            ->createOne([
                'wallet_amount' => $packagge->price + 1
            ]);

        $result = resolve(BuyInternetInterface::class)
            ->buyPackageForUser($user, $this->operator, $packagge);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'package_id' => $packagge->id,
            'api_order_id' => $result->api_order_id,
            'status' => OrderStatus::SUCCESS,
            'operator' => $this->operator
        ]);
    }

    public function test_user_cannot_buy_package_if_its_wallet_amount_is_not_enough()
    {
        $packagge = InternetPackage::query()->where('operator', $this->operator)->first();

        $user = User::factory()
            ->createOne([
                'wallet_amount' => $packagge->price - 1
            ]);

        $this->expectException(UserWalletAmountNotEnoughException::class);

        resolve(BuyInternetInterface::class)
            ->buyPackageForUser($user, $this->operator, $packagge);
    }

    public function test_user_wallet_amount_is_edited_correctly_after_successful_order()
    {
        $this->mock(DiscountServiceInterface::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getInternetPackageDiscount')
                ->once()
                ->andReturn(0);
        });

        $packagge = InternetPackage::query()->where('operator', $this->operator)->first();

        $userWalletAmount = 12_000 + $packagge->price;
        $user = User::factory()
            ->createOne([
                'wallet_amount' => $userWalletAmount
            ]);

        resolve(BuyInternetInterface::class)
            ->buyPackageForUser($user, $this->operator, $packagge);

        $user = $user->fresh();
        $this->assertEquals(12_000, $user->wallet_amount);
    }

    public function test_user_cannot_buy_package_with_in_correct_operator()
    {
        $packagge = InternetPackage::query()->where('operator', Operator::MTN)->first();
        $user = User::factory()->createOne([
            'wallet_amount' => $packagge->price + 1
        ]);

        $this->expectException(InvalidOperatorProvidedException::class);

        resolve(BuyInternetInterface::class)
            ->buyPackageForUser($user, Operator::MCI, $packagge);
    }
}
