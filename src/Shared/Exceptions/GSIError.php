<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Exceptions;

use Exception;

class GSIError extends Exception
{
    /**
     * @param  array{0:int, 1:string}  $data
     *
     * @throws GSIError
     */
    public static function from(array $data): void
    {
        $code = $data[0] ?? null;
        $message = $data[1] ?? '';
        throw new self("$code - $message");
    }
}
