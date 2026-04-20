<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\User\DTOs;

use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;

final class UserInfo extends AbstractDTO
{
    public function __construct(
        public int $gaia_id,
        public string $username,
        public string $avatar,
        public int $user_level,
        public int $server_id, // sushi_server_id
        public int $sushi_id, // sushi_user_id
        public int $session_id, // sushi_session_id
        public int $room_id, // sushi_room_id
        public int $user_active,
        public int $user_pms,
        public int $towns_address,
        public ?int $filter_level = null,
        public ?int $user_posts = null,
        public ?string $avatar_url = null,
        public ?int $account_age = null,
        public ?string $gender = null,
    ) {}

}
