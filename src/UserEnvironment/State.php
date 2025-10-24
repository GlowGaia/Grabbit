<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

enum State: string
{
    case Open = 'open';
    case Active = 'active';
    case Closed = 'closed';
    case Ended = 'ended';
    case Inactive = '';
}
