<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Contracts;

use GlowGaia\Grabbit\Shared\Exceptions\GSIRequestException;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

abstract class GSIRequest extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/chat/gsi/json.php';
    }

    public function hasRequestFailed(Response $response): bool
    {
        return ! $this->hasRequestSucceeded($response);
    }

    public function hasRequestSucceeded(Response $response): bool
    {
        try {
            $data = $response->json();

            return isset($data[0][1]) && $data[0][1] === true;
        } catch (JsonException) {
            return false;
        }
    }

    /**
     * @throws GSIRequestException
     */
    protected function validateResponse(Response $response): array
    {
        try {
            $data = $response->json();
        } catch (JsonException $e) {
            throw new GSIRequestException($response, 'Failed to parse Gaia GSI response: '.$e->getMessage());
        }

        if (! isset($data[0])) {
            throw new GSIRequestException($response, 'Invalid Gaia GSI response structure.');
        }

        if (($data[0][1] ?? false) === false) {
            $errorCode = null;
            $errorMessage = 'Gaia GSI reported a failure status.';

            if (isset($data[0][2]) && is_array($data[0][2])) {
                $errorCode = isset($data[0][2][0]) ? (int) $data[0][2][0] : null;
                $errorMessage = isset($data[0][2][1]) ? (string) $data[0][2][1] : $errorMessage;
            }

            throw new GSIRequestException($response, $errorMessage, $errorCode);
        }

        return $data;
    }
}
