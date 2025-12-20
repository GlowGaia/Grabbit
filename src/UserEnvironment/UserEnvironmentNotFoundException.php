<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Exceptions\GSIRequestException;
use Saloon\Http\Response;
use Throwable;

class UserEnvironmentNotFoundException extends GSIRequestException
{
    public function __construct(Response $response, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        $message ??= 'The requested user environment could not be found.';

        parent::__construct($response, $message, $code, $previous);
    }
}
