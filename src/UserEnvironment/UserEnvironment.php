<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTO;
use GlowGaia\Grabbit\Shared\Helpers\RecursiveCollection;
use Illuminate\Support\Collection;

class UserEnvironment extends DTO
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
        public ?GameInfo $game_info,
    ) {}

    public static function fromCollection($data): UserEnvironment
    {
        return new self(
            serial: (int) $data->get('serial'),
            attr_settings: $data->get('attr_settings')->transform(function ($attribute_setting) {
                return AttributeSetting::fromCollection($attribute_setting);
            }),
            name: $data->get('name'),
            user_id: (int) $data->get('user_id'),
            show_in_sig: (bool) $data->get('show_in_sig'),
            show_in_profile: (bool) $data->get('show_in_profile'),
            last_engine_run: DateTimeImmutable::createFromFormat('U', $data->get('last_engine_run')),
            tap_count: (int) $data->get('tap_count'),
            view_count: (int) $data->get('view_count'),
            total_gold_won: (int) $data->get('total_gold_won'),
            env_health: (int) $data->get('env_health'),
            env_bg_id: $data->get('env_bg_id'),
            env_last_grant_time: DateTimeImmutable::createFromFormat('U', $data['env_last_grant_time']),
            inhab_retire: RecursiveCollection::wrap($data->get('inhab_retire'))->transform(function ($inhabitant) {
                if (is_bool($inhabitant)) {
                    return $inhabitant;
                }

                return InhabRetire::fromCollection($inhabitant);
            }),
            game_info: ($data->get('game_info')) ? GameInfo::fromCollection(
                RecursiveCollection::wrap(
                    $data->get('game_info', RecursiveCollection::make())->get(1, RecursiveCollection::make())
                )
            ) : null,
        );
    }
}
