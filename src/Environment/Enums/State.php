<?php

declare(strict_types=1);

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

namespace GlowGaia\Grabbit\Environment\Enums;

enum State: string
{
    case Open = 'open';
    case Active = 'active';
    case Closed = 'closed';
    case Ended = 'ended';

}
