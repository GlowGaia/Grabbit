<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use DateTimeImmutable;
use Exception;
use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class UserEnvironment implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    /**
     * @param  AttributeSetting[]  $attr_settings
     * @param  array<int, InhabRetire|bool>  $inhab_retire
     */
    public function __construct(
        public int $id,
        public int $serial,
        public array $attr_settings,
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
        public array $inhab_retire,
        public ?GameInfo $game_info,
    ) {}

    /**
     * @param  AttributeSetting[]  $attr_settings
     * @param  array<int, InhabRetire|bool>  $inhab_retire
     */
    public static function make(
        int $id,
        int $serial,
        array $attr_settings,
        ?string $name,
        int $user_id,
        bool $show_in_sig,
        bool $show_in_profile,
        DateTimeImmutable $last_engine_run,
        int $tap_count,
        int $view_count,
        int $total_gold_won,
        int $env_health,
        ?string $env_bg_id,
        DateTimeImmutable $env_last_grant_time,
        array $inhab_retire,
        ?GameInfo $game_info,
    ): static {
        return new self(
            id: $id,
            serial: $serial,
            attr_settings: $attr_settings,
            name: $name,
            user_id: $user_id,
            show_in_sig: $show_in_sig,
            show_in_profile: $show_in_profile,
            last_engine_run: $last_engine_run,
            tap_count: $tap_count,
            view_count: $view_count,
            total_gold_won: $total_gold_won,
            env_health: $env_health,
            env_bg_id: $env_bg_id,
            env_last_grant_time: $env_last_grant_time,
            inhab_retire: $inhab_retire,
            game_info: $game_info,
        );
    }

    public static function fromArray(array $data): static
    {
        $attr_settings = [];
        if (isset($data['attr_settings']) && is_array($data['attr_settings'])) {
            foreach ($data['attr_settings'] as $key => $setting) {
                $attr_settings[$key] = AttributeSetting::fromArray($setting);
            }
        }

        $inhab_retire = [];
        if (isset($data['inhab_retire']) && is_array($data['inhab_retire'])) {
            foreach ($data['inhab_retire'] as $key => $inhabitant) {
                $inhab_retire[$key] = is_bool($inhabitant)
                    ? $inhabitant
                    : InhabRetire::fromArray($inhabitant);
            }
        }

        $game_info = null;
        if (isset($data['game_info'][1]) && is_array($data['game_info'][1])) {
            $game_info = GameInfo::fromArray($data['game_info'][1]);
        }

        try {
            $last_run = new DateTimeImmutable('@'.($data['last_engine_run'] ?? 0));
            $last_grant = new DateTimeImmutable('@'.($data['env_last_grant_time'] ?? 0));
        } catch (Exception) {
            $last_run = $last_grant = new DateTimeImmutable('@0');
        }

        return static::make(
            id: (int) ($data['id'] ?? 0),
            serial: (int) ($data['serial'] ?? 0),
            attr_settings: $attr_settings,
            name: isset($data['name']) ? (string) $data['name'] : null,
            user_id: (int) ($data['user_id'] ?? 0),
            show_in_sig: (bool) (int) ($data['show_in_sig'] ?? 0),
            show_in_profile: (bool) (int) ($data['show_in_profile'] ?? 0),
            last_engine_run: $last_run,
            tap_count: (int) ($data['tap_count'] ?? 0),
            view_count: (int) ($data['view_count'] ?? 0),
            total_gold_won: (int) ($data['total_gold_won'] ?? 0),
            env_health: (int) ($data['env_health'] ?? 0),
            env_bg_id: isset($data['env_bg_id']) ? (string) $data['env_bg_id'] : null,
            env_last_grant_time: $last_grant,
            inhab_retire: $inhab_retire,
            game_info: $game_info,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'serial' => $this->serial,
            'attr_settings' => array_map(fn (AttributeSetting $s) => $s->toArray(), $this->attr_settings),
            'name' => $this->name,
            'user_id' => $this->user_id,
            'show_in_sig' => $this->show_in_sig,
            'show_in_profile' => $this->show_in_profile,
            'last_engine_run' => $this->last_engine_run->format('U'),
            'tap_count' => $this->tap_count,
            'view_count' => $this->view_count,
            'total_gold_won' => $this->total_gold_won,
            'env_health' => $this->env_health,
            'env_bg_id' => $this->env_bg_id,
            'env_last_grant_time' => $this->env_last_grant_time->format('U'),
            'inhab_retire' => array_map(fn ($i) => $i instanceof InhabRetire ? $i->toArray() : $i, $this->inhab_retire),
            'game_info' => $this->game_info?->toArray(),
        ];
    }
}