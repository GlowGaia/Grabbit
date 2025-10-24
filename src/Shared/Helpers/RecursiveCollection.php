<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Helpers;

use Illuminate\Support\Collection;

class RecursiveCollection extends Collection
{
    public static function recursive($item): RecursiveCollection
    {
        return static::make($item)->map(function ($item) {
            if (is_array($item) || is_object($item)) {
                return static::recursive($item);
            }

            return $item;
        });
    }
}
