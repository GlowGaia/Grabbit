<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;
use Illuminate\Support\Collection;

class UserEnvironment implements DTOInterface
{
    public function __construct(
        public int $serial,
        public Collection $attr_settings,
        public ?string $name,
        public int $user_id,
        public bool $show_in_sig,
        public bool $show_in_profile,
        public DateTimeImmutable $last_engine_run,
        public int $tap_count,
        public int $view_count,
        public int $total_gold_won,
        public int $env_health,
        public ?string $env_bg_id,
        public DateTimeImmutable $env_last_grant_time,
        public Collection $inhab_retire,
        public GameInfo|NullGameInfo $game_info,
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            serial: (int) $data['serial'],
            attr_settings: collect($data['attr_settings'])->transform(function ($attribute_setting) {
                return AttributeSetting::fromArray($attribute_setting);
            }),
            name: $data['name'],
            user_id: (int) $data['user_id'],
            show_in_sig: (bool) $data['show_in_sig'],
            show_in_profile: (bool) $data['show_in_profile'],
            last_engine_run: DateTimeImmutable::createFromFormat('U', $data['last_engine_run']),
            tap_count: (int) $data['tap_count'],
            view_count: (int) $data['view_count'],
            total_gold_won: (int) $data['total_gold_won'],
            env_health: (int) $data['env_health'],
            env_bg_id: $data['env_bg_id'],
            env_last_grant_time: DateTimeImmutable::createFromFormat('U', $data['env_last_grant_time']),
            inhab_retire: collect($data['inhab_retire'] ?: [])->map(function ($inhabitant) {
                return InhabRetire::fromArray($inhabitant);
            }),
            game_info: GameInfo::fromArray($data['game_info'][1] ?? null),
        );
    }
}
