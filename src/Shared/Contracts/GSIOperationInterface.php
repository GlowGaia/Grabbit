<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Contracts;

interface GSIOperationInterface
{
    public int $method { get; }

    public ?array $parameters { get; }

    public function __construct(int $method, ?array $parameters);
}
