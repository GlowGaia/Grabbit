<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\Requests;

use GlowGaia\Grabbit\Common\Requests\AbstractRequest;
use GlowGaia\Grabbit\Environment\DTOs\Environment;
use JsonException;
use Saloon\Http\Response;

/**
 * Loads configuration information for environments.
 *
 * Note: Seemingly, there is only one environment - aquariums.
 *
 * @extends AbstractRequest<Environment>
 */
final class GetEnvironment extends AbstractRequest
{
    public int $code = 6500;

    public string $name = 'environment.getEnvironment';

    public function __construct(
        public int $environment_id,
    ) {
        $this->parameters = [
            $this->environment_id,
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Environment
    {
        /** @var Environment */
        return $this->serializer()->denormalize(
            $this->data($response),
            Environment::class,
        );
    }

    protected function dto(): string
    {
        return Environment::class;
    }
}
