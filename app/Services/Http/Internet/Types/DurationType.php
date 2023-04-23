<?php

namespace App\Services\Http\Internet\Types;

use \App\Enums\DurationType as DurationTypeEnum;

class DurationType
{
    private string $type;

    public function __construct(
        string $type
    )
    {
        if (!in_array(strtolower($type), self::getAcceptedTypes())) {
            throw new \Exception('Invalid duration type');
        }

        $this->type = strtolower($type);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function getAcceptedTypes(): array
    {
        return ['day', 'week', 'month', 'year'];
    }

    public static function acceptsDurationType(string $type): bool
    {
        return in_array(strtolower($type), self::getAcceptedTypes());
    }

    public function getTypeEnum(): DurationTypeEnum
    {
        return DurationTypeEnum::from($this->type);
    }
}
