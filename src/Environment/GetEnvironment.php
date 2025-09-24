<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\GSIOperation;

class GetEnvironment extends GSIOperation
{
    public function __construct(int $method, ?array $parameters)
    {
        parent::__construct($method, $parameters);

        $this->dto = Environment::class;
    }

    public static function make(): GetEnvironment
    {
        return new self(6500, [1]);
    }
}
