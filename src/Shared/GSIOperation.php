<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared;

use Exception;
use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;
use GlowGaia\Grabbit\Shared\Contracts\GSIOperationInterface;
use GlowGaia\Grabbit\Shared\Exceptions\GSIError;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

class GSIOperation implements GSIOperationInterface
{
    public ?array $response;

    /** @var class-string<DTOInterface> */
    public string $dto;

    /** @var class-string<DTOInterface> */
    public string $null_dto;

    public function __construct(public int $method, public ?array $parameters) {}

    /**
     * @return Collection<DTOInterface>|DTOInterface
     */
    public function dto(): Collection|DTOInterface
    {
        return $this->dto::fromArray($this->json());
    }

    public function json(): array
    {
        return $this->response ?? [];
    }

    public function response(Response $response, int $index): void
    {
        if ($this->validateResponse($response, $index)) {
            $this->setResponse();
        }
    }

    public function validateResponse(Response $response, int $index): bool
    {
        try {
            $response = $response->json();
            if (count($response) <= $index) {
                // Malformed request JSON usually is what causes this.
                // Unlikely since our JSON request is built programmatically, but you never know
                GSIError::from($response[0][2]);
            }

            $response = $response[$index];

            if ($response[1] && count($response[2])) {
                $this->response = $response;

                return true;
            }

            GSIError::from($response[2]);
        } catch (Exception $exception) {
            error_log($exception->getMessage());
        }

        $this->dto = $this->null_dto;

        return false;
    }

    public function setResponse(): void
    {
        $this->response = $this->response[2];
    }
}
