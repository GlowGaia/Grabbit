<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Users;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use Saloon\Http\Response;

class GetUser extends GSIRequest
{
    public function __construct(public int|string $identifier, public int $GSI_method = 102) {}

    public static function byId(int $id): self
    {
        return new self($id);
    }

    public static function byUsername(string $username): self
    {
        if (is_numeric($username) && str_contains($username, '.')) {
            // 3.14 becomes 3-14
            $username = str_replace('.', '-', $username);
        }

        return new self($username);
    }

    public static function byEmail(string $email): self
    {
        return new self($email);
    }

    public static function bySessionId(string $session): self
    {
        return new self($session, 107);
    }

    public function createDtoFromResponse(Response $response): User
    {
        return User::fromCollection($this->recursive($response));
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => [
                $this->GSI_method,
                [
                    $this->identifier,
                ],
            ],
            'X' => time(),
        ];
    }
}
