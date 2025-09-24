<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared;

use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;
use GlowGaia\Grabbit\Shared\Contracts\GSIOperationInterface;
use Illuminate\Support\Collection;
use Saloon\Http\Request;

class GSIOperation implements GSIOperationInterface
{
    public ?array $response;

    public ?Request $request;

    /** @var class-string<DTOInterface> */
    public string $dto;

    public function __construct(public int $method, public ?array $parameters) {}

    public function json(): array
    {
        if ($this->response) {
            return $this->response[2];
        }

        return [];
    }

    /**
     * @return Collection<DTOInterface>|DTOInterface
     */
    public function dto(): Collection|DTOInterface
    {
        return $this->dto::fromArray($this->json());
    }
}
