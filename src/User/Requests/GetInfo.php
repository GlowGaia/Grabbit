<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\User\Requests;

use GlowGaia\Grabbit\Common\Requests\AbstractRequest;
use GlowGaia\Grabbit\User\DTOs\UserInfo;

/**
 * Retrieve user info for a given user ID, username, or email address
 *
 * @extends AbstractRequest<UserInfo>
 */
final class GetInfo extends AbstractRequest
{
    public int $code = 102;

    public string $name = 'user.getinfo';

    public string|int $identifier {
        // "3.14" -> "3-14"
        set => is_string($value) && is_numeric($value)
        && str_contains(
            $value,
            '.',
        )
            ? str_replace('.', '-', $value)
            : $value;
    }

    public function __construct(string|int $identifier)
    {
        $this->identifier = $identifier;

        $this->parameters = [
            $this->identifier,
        ];
    }

    protected function dto(): string
    {
        return UserInfo::class;
    }
}
