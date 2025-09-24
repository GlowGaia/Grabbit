<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit;

use GlowGaia\Grabbit\Shared\Contracts\GSIOperationInterface;
use GlowGaia\Grabbit\Shared\GSIOperation;
use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @property Method $method;
 * @property Collection<GSIOperation> $operations;
 */
class GSIRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(public Collection $operations) {}

    public function resolveEndpoint(): string
    {
        return '/chat/gsi/json.php';
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => $this->operations->map(function (GSIOperationInterface $operation): array {
                return [
                    $operation->method,
                    $operation->parameters,
                ];
            })->jsonSerialize(),
        ];
    }

    protected function defaultHeaders(): array
    {
        return [
            // For UserEnvironment requests, we need to send a cookie shaped like a session ID
            'Cookie' => 'gaia55_sid=aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
    }
}
