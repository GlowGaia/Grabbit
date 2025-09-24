<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Users;

use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;

class User implements DTOInterface
{
    public function __construct(
        public int $gaia_id,
        public string $username,
        public string $avatar,
        public int $user_level,
        public int $filter_level,
        public int $server_id,
        public int $sushi_id,
        public int $session_id,
        public int $room_id,
        public int $user_active,
        public int $user_pms,
        public int $user_posts,
        public int $towns_address,
        public string $avatar_url,
        public int $account_age,
        public string $gender,
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            gaia_id: $data['gaia_id'],
            username: $data['username'],
            avatar: $data['avatar'],
            user_level: $data['user_level'],
            filter_level: $data['filter_level'],
            server_id: $data['server_id'],
            sushi_id: $data['sushi_id'],
            session_id: $data['session_id'],
            room_id: $data['room_id'],
            user_active: $data['user_active'],
            user_pms: $data['user_pms'],
            user_posts: $data['user_posts'],
            towns_address: $data['towns_address'],
            avatar_url: $data['avatar_url'],
            account_age: $data['account_age'],
            gender: $data['gender'],
        );
    }
}
