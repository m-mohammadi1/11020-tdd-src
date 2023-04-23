<?php

namespace App\Models;

use App\Enums\DurationType;
use App\Enums\Operator;
use App\Enums\TrafficType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $title
 * @property int $price
 * @property int $duration
 * @property DurationType $duration_type
 * @property int $traffic
 * @property TrafficType $traffic_type
 * @property Operator $operator
 */
class InternetPackage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'duration_type' => DurationType::class,
        'traffic_type' => TrafficType::class,
        'operator' => Operator::class,
    ];

    public function getFinalPriceWithDiscount(int $discountPercentage): float
    {
        return $this->price - ($this->price * ($discountPercentage / 100));
    }
}
