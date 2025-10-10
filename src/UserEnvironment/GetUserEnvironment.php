<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\GSIOperation;
use Saloon\Http\Response;

class GetUserEnvironment extends GSIOperation
{
    private int $id;

    public function __construct(int $method, ?array $parameters)
    {
        parent::__construct($method, $parameters);

        $this->id = $parameters[0];
        $this->dto = UserEnvironment::class;
        $this->null_dto = NullUserEnvironment::class;
    }

    /**
     * @param  int  $id  - User's Environment ID
     * @param  bool  $location  - true is for editor, false is for profile. (Regarding "message in a bottle" quest, inhab_retire key, etc.)
     * @param  bool  $hide  - Unsure, but false seems to show more information about the above, while true hides it
     */
    public static function byId(int $id, bool $location = false, bool $hide = true): GetUserEnvironment
    {
        return new self(6510, [
            $id,
            (int) $location,
            (int) $hide,
        ]);
    }

    public function setResponse(Response $response, int $index): void
    {
        $this->response = $response->json()[$index][2][$this->id];
    }
}
