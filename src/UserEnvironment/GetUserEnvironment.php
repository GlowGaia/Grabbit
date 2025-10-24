<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use GlowGaia\Grabbit\Shared\Helpers\RecursiveCollection;
use Saloon\Http\Response;

class GetUserEnvironment extends GSIRequest
{
    /**
     * @param  int  $id  - User's Environment ID
     * @param  bool  $location  - true is for editor, false is for profile. (Regarding "message in a bottle" quest, inhab_retire key, etc.)
     * @param  bool  $hide  - Unsure, but false seems to show more information about the above, while true hides it
     */
    public function __construct(public int $id, public bool $location = false, public bool $hide = true) {}

    public static function byId(int $id, bool $location = false, bool $hide = true): GetUserEnvironment
    {
        return new self($id, $location, $hide);
    }

    public function hasRequestSucceeded(Response $response): bool
    {
        return $response->json()[0][1] && isset($response->json()[0][2][$this->id]);
    }

    public function createDtoFromResponse(Response $response): UserEnvironment
    {
        return UserEnvironment::fromCollection($this->recursive($response));
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

    protected function recursive(Response $response): RecursiveCollection
    {
        return RecursiveCollection::recursive($response->collect()[0][2][$this->id]);
    }
}
