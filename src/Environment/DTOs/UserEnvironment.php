<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\DTOs;

use DateTimeImmutable;
use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;
use Illuminate\Support\Collection;

final class UserEnvironment extends AbstractDTO
{
    public ?GameInfo $game_info;

    /**
     * @param  array<string, mixed>|null  $game_info
     */
    public function __construct(
        public int $id,
        public int $serial,
        /** @var Collection<int, AttributeSetting> $attr_settings */
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
        /** @var Collection<int, InhabRetire|bool> $inhab_retire */
        public Collection $inhab_retire,
        public ?bool $has_quest,
        public ?MessageCenter $message_center,
        ?array $game_info,
        public ?SpecialOffer $special_offer,
    ) {
        $this->game_info = $game_info
            ? UserEnvironment::serializer()->denormalize(
                collect($game_info)->first(),
                GameInfo::class,
            )
            : null;
    }
}
