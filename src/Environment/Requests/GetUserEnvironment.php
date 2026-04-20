<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\Requests;

use GlowGaia\Grabbit\Common\Requests\AbstractRequest;
use GlowGaia\Grabbit\Environment\DTOs\AttributeSetting;
use GlowGaia\Grabbit\Environment\DTOs\InhabRetire;
use GlowGaia\Grabbit\Environment\DTOs\UserEnvironment;
use GlowGaia\Grabbit\Environment\Exceptions\UserEnvironmentNotFoundException;
use Illuminate\Support\Collection;
use Saloon\Http\Response;
use Throwable;

/**
 * Retrieve all user environment information and state
 *
 * Note: This will not return accurate GameInfo player counts without a
 * gaia55_sid cookie. These cookies do not need to be actual session IDs,
 * they just need to be shaped like one. For example, you can send a string of
 * 48 "a"s repeated and that would satisfy the checks.
 *
 * @extends AbstractRequest<UserEnvironment>
 */
class GetUserEnvironment extends AbstractRequest
{
    public int $code = 6510;

    public string $name = 'environment.getUserEnvironment';

    /**
     * @param  bool  $location  true = editor; false = profile
     */
    public function __construct(
        public int $user_environment_id,
        public ?bool $location = false,
        public ?bool $remove_notification = null,
    ) {
        $this->parameters = [
            $this->user_environment_id,
            $this->location,
            $this->remove_notification,
        ];
    }

    public function defaultHeaders(): array
    {
        return [
            'Cookie' => 'gaia55_sid=' . str_repeat('a', 48),
        ];
    }

    public function getRequestException(
        Response $response,
        ?Throwable $senderException,
    ): ?Throwable {
        return new UserEnvironmentNotFoundException(
            $response,
            'UserInfo environment not found',
            0,
            $senderException,
        );
    }

    /**
     * @return class-string<UserEnvironment>
     */
    protected function dto(): string
    {
        return UserEnvironment::class;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function denormalize(
        array $data,
        ?string $class = null,
    ): UserEnvironment {
        /** @var array<string, mixed> $environment */
        $environment = $data["$this->user_environment_id"];

        /** @var array<int, array<string, mixed>> $attr_settings */
        $attr_settings = $environment['attr_settings'];

        /** @var array<int, array<string, mixed>> $inhab_retire */
        $inhab_retire = is_array($environment['inhab_retire'])
            ? $environment['inhab_retire'] : [];

        $environment['id'] = $this->user_environment_id;
        $environment['attr_settings'] = Collection::make($attr_settings)->map(
            fn($attr_setting)
                => $this->serializer()->denormalize(
                $attr_setting,
                AttributeSetting::class,
            ),
        );
        $environment['inhab_retire'] = Collection::make($inhab_retire)->map(
            fn($inhabitant)
                => $this->serializer()->denormalize(
                $inhabitant,
                InhabRetire::class,
            ),
        );

        /** @var UserEnvironment */
        return $this->serializer()->denormalize(
            $environment,
            UserEnvironment::class,
        );
    }
}
