<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\User;

use GlowGaia\Grabbit\User\Requests\AuthInfo;
use GlowGaia\Grabbit\User\Requests\GetInfo;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class UserResource extends BaseResource
{
    /**
     * 102: user.getinfo
     *
     * @param  string|int  $identifier
     * @return Response
     * @throws RequestException
     * @throws FatalRequestException
     */
    public function getInfo(string|int $identifier): Response
    {
        return $this->connector->send(
            new GetInfo($identifier),
        );
    }

    /**
     * 107: user.authInfo
     *
     * @param  string  $authentication
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function authInfo(string $authentication): Response
    {
        return $this->connector->send(
            new AuthInfo($authentication),
        );
    }

}
