<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;

class InhabRetire implements DTOInterface
{
    public function __construct(
        public int $serial,
        public int $item_id,
        public int $retire_grant_id,
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            serial: $data['serial'],
            item_id: (int) $data['item_id'],
            retire_grant_id: (int) $data['retire_grant_id'],
        );
    }
}
