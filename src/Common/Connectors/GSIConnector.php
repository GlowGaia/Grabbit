<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Common\Connectors;

use GlowGaia\Grabbit\Common\DTOs\Error;
use GlowGaia\Grabbit\Common\Exceptions\GSIException;
use GlowGaia\Grabbit\Common\Responses\GSIResponse;
use GlowGaia\Grabbit\Environment\EnvironmentResource;
use GlowGaia\Grabbit\Inventory\InventoryResource;
use GlowGaia\Grabbit\User\UserResource;
use JsonException;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Throwable;

final class GSIConnector extends Connector
{
    use AlwaysThrowOnErrors;

    protected ?string $response = GSIResponse::class;

    public function __construct(public ?string $server = 'www') {}

    public function resolveBaseUrl(): string
    {
        return "https://{$this->subdomain()}gaiaonline.com/chat/gsi";
    }

    public function subdomain(): string
    {
        return $this->server ? "$this->server." : '';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return ['X' => time()];
    }

    /**
     * @throws JsonException
     */
    public function hasRequestFailed(Response $response): bool
    {
        assert($response instanceof GSIResponse);

        return $response->gsiFailed()
            || $response->hasNoData();
    }

    /**
     * @throws JsonException
     */
    public function getRequestException(
        Response $response,
        ?Throwable $senderException,
    ): ?Throwable {
        assert($response instanceof GSIResponse);

        if (!$response->gsiFailed()) {
            return parent::getRequestException($response, $senderException);
        }

        /** @var array{0: int, 1: string} $data */
        $data = $response->data();

        $error = new Error($data);

        return new GSIException($response, $error, $senderException);
    }

    public function environment(): EnvironmentResource
    {
        return new EnvironmentResource($this);
    }

    public function inventory(): InventoryResource
    {
        return new InventoryResource($this);
    }

    public function user(): UserResource
    {
        return new UserResource($this);
    }

    /**
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'UserInfo-Agent' => 'Mozilla/5.0 Version/17.10 Safari/605.1.1',
        ];
    }
}
