<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;

class Inhabitant implements DTOInterface
{
    public function __construct(
        public string $name,
        public int $serial,
        public int $inhab_health,
        public ?DateTimeImmutable $inhab_incept,
        public ?DateTimeImmutable $inhab_expires,
        public ?DateTimeImmutable $inhab_cryo,
        public bool $in_env,
        public int $item_id,
        public int $lifespan,
        public ?ItemSpecifics $item_specifics
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            name: $data['name'] ?? '',
            serial: (int) $data['serial'],
            inhab_health: (int) $data['inhab_health'],
            inhab_incept: (int) $data['inhab_incept'] ? DateTimeImmutable::createFromFormat('U', $data['inhab_incept']) : null,
            inhab_expires: (int) $data['inhab_expires'] ? DateTimeImmutable::createFromFormat('U', $data['inhab_expires']) : null,
            inhab_cryo: (int) $data['inhab_cryo'] ? DateTimeImmutable::createFromFormat('U', $data['inhab_cryo']) : null,
            in_env: (bool) $data['in_env'],
            item_id: (int) $data['item_id'],
            lifespan: (int) $data['lifespan'],
            item_specifics: $data['item_specifics'] ?? null ? ItemSpecifics::fromArray($data['item_specifics']) : null,
        );
    }
}
