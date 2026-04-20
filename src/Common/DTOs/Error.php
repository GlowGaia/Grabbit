<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Common\DTOs;

final class Error extends AbstractDTO
{
    public readonly int $code;
    public readonly string $message;

    /**
     * @param  array{0: int, 1: string}  $data
     */
    public function __construct(array $data)
    {
        [$this->code, $this->message] = $data;
    }
}
