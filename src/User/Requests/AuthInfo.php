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
 * Retrieve user info for a given session ID
 *
 * @extends AbstractRequest<UserInfo>
 */
class AuthInfo extends AbstractRequest
{
    public int $code = 107;

    public string $name = 'user.authInfo';

    public function __construct(string $authentication)
    {
        $this->parameters = [
            $authentication,
        ];
    }

    protected function dto(): string
    {
        return UserInfo::class;
    }
}
