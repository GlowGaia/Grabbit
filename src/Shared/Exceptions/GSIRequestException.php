<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Exceptions;

use RuntimeException;
use Saloon\Http\Response;
use Throwable;

class GSIRequestException extends RuntimeException
{
    public function __construct(
        protected Response $response,
        string $message = 'Gaia GSI request unsuccessful.',
        protected ?int $gaiaErrorCode = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $gaiaErrorCode ?? $response->status(), $previous);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getGaiaErrorCode(): ?int
    {
        return $this->gaiaErrorCode;
    }
}
