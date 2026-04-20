<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Common\Exceptions;

use GlowGaia\Grabbit\Common\DTOs\Error;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;
use Throwable;

class GSIException extends RequestException
{
    public function __construct(
        Response $response,
        Error $error,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            $response,
            $error->message,
            $error->code,
            $previous,
        );
    }
}
