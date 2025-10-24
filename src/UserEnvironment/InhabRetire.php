<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Contracts\DTO;

class InhabRetire extends DTO
{
    public function __construct(
        public ?int $serial,
        public ?int $item_id,
        public ?int $retire_grant_id,
    ) {}

    public static function fromCollection($data): static
    {
        return new self(
            serial: $data->get('serial'),
            item_id: (int) $data->get('item_id'),
            retire_grant_id: (int) $data->get('retire_grant_id'),
        );
    }
}
