<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use Saloon\Http\Response;

class GetUserEnvironment extends GSIRequest
{
    /**
     * @param  int  $id  - User's Environment ID
     * @param  bool  $location  - true is for editor, false is for profile.
     * @param  bool  $hide  - Unsure, but false seems to show more information about the above, while true hides it
     */
    public function __construct(
        public int $id,
        public bool $location = false,
        public bool $hide = true
    ) {}

    public static function byId(int $id, bool $location = false, bool $hide = true): GetUserEnvironment
    {
        return new self($id, $location, $hide);
    }

    /**
     * @throws UserEnvironmentNotFoundException
     */
    public function createDtoFromResponse(Response $response): UserEnvironment
    {
        $data = $this->validateResponse($response);

        if (! isset($data[0][2][$this->id])) {
            throw new UserEnvironmentNotFoundException(
                $response,
                sprintf('User environment with ID %d not found.', $this->id)
            );
        }

        return UserEnvironment::fromArray($data[0][2][$this->id]);
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => [
                6510,
                [
                    $this->id,
                    $this->location,
                    $this->hide,
                ],
            ],
            'X' => time(),
        ];
    }

    protected function defaultHeaders(): array
    {
        return [
            'Cookie' => 'gaia55_sid='.str_repeat('a', 48),
        ];
    }
}
