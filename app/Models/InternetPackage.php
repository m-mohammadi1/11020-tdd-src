<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $title
 * @property int $price
 * @property int $duration
 * @property int $traffic
 */
class InternetPackage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

}
