<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Environment\Requests\GetEnvironment;
use GlowGaia\Grabbit\Environment\Requests\GetUserEnvironment;
use GlowGaia\Grabbit\Environment\Requests\GetUserInhabitants;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class EnvironmentResource extends BaseResource
{
    /**
     * 6500: environment.getEnvironment
     *
     * @param  int  $environment_id
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getEnvironment(int $environment_id): Response
    {
        return $this->connector->send(
            new GetEnvironment($environment_id),
        );
    }

    /**
     * 6510: environment.getUserEnvironment
     *
     * @param  int        $user_environment_id
     * @param  bool|null  $location
     * @param  bool|null  $remove_notification
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getUserEnvironment(
        int $user_environment_id,
        ?bool $location = false,
        ?bool $remove_notification = null,
    ): Response {
        return $this->connector->send(
            new GetUserEnvironment(
                $user_environment_id,
                $location,
                $remove_notification,
            ),
        );
    }

    /**
     * 6511: environment.getUserInhabitants
     *
     * @param  int        $user_environment_id
     * @param  bool|null  $show_item_specifics
     * @param  bool|null  $show_only_intank
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getUserInhabitants(
        int $user_environment_id,
        ?bool $show_item_specifics = false,
        ?bool $show_only_intank = null,
    ): Response {
        return $this->connector->send(
            new getUserInhabitants(
                $user_environment_id,
                $show_item_specifics,
                $show_only_intank,
            ),
        );
    }
}
