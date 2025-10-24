<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Users;

use GlowGaia\Grabbit\Shared\Contracts\DTO;

class User extends DTO
{
    public function __construct(
        public ?int $gaia_id,
        public ?string $username,
        public ?string $avatar,
        public ?int $user_level,
        public ?int $filter_level,
        public ?int $server_id,
        public ?int $sushi_id,
        public ?int $session_id,
        public ?int $room_id,
        public ?int $user_active,
        public ?int $user_pms,
        public ?int $user_posts,
        public ?int $towns_address,
        public ?string $avatar_url,
        public ?int $account_age,
        public ?string $gender,
    ) {}

    public static function fromCollection($data): User
    {
        return new self(
            gaia_id: $data->get('gaia_id'),
            username: $data->get('username'),
            avatar: $data->get('avatar'),
            user_level: $data->get('user_level'),
            filter_level: $data->get('filter_level'),
            server_id: $data->get('server_id'),
            sushi_id: $data->get('sushi_id'),
            session_id: $data->get('session_id'),
            room_id: $data->get('room_id'),
            user_active: $data->get('user_active'),
            user_pms: $data->get('user_pms'),
            user_posts: $data->get('user_posts'),
            towns_address: $data->get('towns_address'),
            avatar_url: $data->get('avatar_url'),
            account_age: $data->get('account_age'),
            gender: $data->get('gender'),
        );
    }
}
