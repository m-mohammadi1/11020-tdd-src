<?php

namespace App\Services\Http\Internet\Types;

use App\Enums\TrafficType as TrafficTypeEnum;

class TrafficType
{
    public function __construct(
        string $type
    )
    {
        if (!in_array(strtolower($type), self::getAcceptedTypes())) {
            throw new \Exception('Invalid traffic type');
        }

        $this->type = strtolower($type);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function getAcceptedTypes(): array
    {
        return ['gb', 'mb'];
    }

    public static function acceptsDurationType(string $type): bool
    {
        return in_array(strtolower($type), self::getAcceptedTypes());
    }

    public function getTypeEnum(): TrafficTypeEnum
    {
        return TrafficTypeEnum::from($this->type);
    }
}
