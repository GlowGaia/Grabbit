<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Users;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class User implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

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

    public static function make(
        ?int $gaia_id,
        ?string $username,
        ?string $avatar,
        ?int $user_level,
        ?int $filter_level,
        ?int $server_id,
        ?int $sushi_id,
        ?int $session_id,
        ?int $room_id,
        ?int $user_active,
        ?int $user_pms,
        ?int $user_posts,
        ?int $towns_address,
        ?string $avatar_url,
        ?int $account_age,
        ?string $gender,
    ): static {
        return new self(
            gaia_id: $gaia_id,
            username: $username,
            avatar: $avatar,
            user_level: $user_level,
            filter_level: $filter_level,
            server_id: $server_id,
            sushi_id: $sushi_id,
            session_id: $session_id,
            room_id: $room_id,
            user_active: $user_active,
            user_pms: $user_pms,
            user_posts: $user_posts,
            towns_address: $towns_address,
            avatar_url: $avatar_url,
            account_age: $account_age,
            gender: $gender,
        );
    }

    public static function fromArray(array $data): static
    {
        $payload = $data[0][2] ?? [];

        return static::make(
            gaia_id: isset($payload['gaia_id']) ? (int) $payload['gaia_id'] : null,
            username: isset($payload['username']) ? (string) $payload['username'] : null,
            avatar: isset($payload['avatar']) ? (string) $payload['avatar'] : null,
            user_level: isset($payload['user_level']) ? (int) $payload['user_level'] : null,
            filter_level: isset($payload['filter_level']) ? (int) $payload['filter_level'] : null,
            server_id: isset($payload['server_id']) ? (int) $payload['server_id'] : null,
            sushi_id: isset($payload['sushi_id']) ? (int) $payload['sushi_id'] : null,
            session_id: isset($payload['session_id']) ? (int) $payload['session_id'] : null,
            room_id: isset($payload['room_id']) ? (int) $payload['room_id'] : null,
            user_active: isset($payload['user_active']) ? (int) $payload['user_active'] : null,
            user_pms: isset($payload['user_pms']) ? (int) $payload['user_pms'] : null,
            user_posts: isset($payload['user_posts']) ? (int) $payload['user_posts'] : null,
            towns_address: isset($payload['towns_address']) ? (int) $payload['towns_address'] : null,
            avatar_url: isset($payload['avatar_url']) ? (string) $payload['avatar_url'] : null,
            account_age: isset($payload['account_age']) ? (int) $payload['account_age'] : null,
            gender: isset($payload['gender']) ? (string) $payload['gender'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'gaia_id' => $this->gaia_id,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'user_level' => $this->user_level,
            'filter_level' => $this->filter_level,
            'server_id' => $this->server_id,
            'sushi_id' => $this->sushi_id,
            'session_id' => $this->session_id,
            'room_id' => $this->room_id,
            'user_active' => $this->user_active,
            'user_pms' => $this->user_pms,
            'user_posts' => $this->user_posts,
            'towns_address' => $this->towns_address,
            'avatar_url' => $this->avatar_url,
            'account_age' => $this->account_age,
            'gender' => $this->gender,
        ];
    }
}
