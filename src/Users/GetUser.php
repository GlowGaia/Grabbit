<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Users;

use GlowGaia\Grabbit\Shared\GSIOperation;

class GetUser extends GSIOperation
{
    public function __construct(int $method, ?array $parameters)
    {
        parent::__construct($method, $parameters);

        $this->dto = User::class;
        $this->null_dto = NUllUser::class;
    }

    public static function byId(int $id): GetUser
    {
        return new self(102, [$id]);
    }

    public static function byUsername(string $username): GetUser
    {
        if (is_numeric($username) && str_contains($username, '.')) {
            // 3.14 becomes 3-14
            $username = str_replace('.', '-', $username);
        }

        return new self(102, [$username]);
    }

    public static function byEmail(string $email): GetUser
    {
        return new self(102, [$email]);
    }

    public static function bySessionId(string $session): GetUser
    {
        return new self(107, [$session]);
    }
}
