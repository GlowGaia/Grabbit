<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use GlowGaia\Grabbit\Shared\Helpers\RecursiveCollection;
use Saloon\Http\Response;

class GetInhabitants extends GSIRequest
{
    /**
     * @param  int  $id  - User Environment ID
     * @param  bool  $item_specifics  - Adds a key to the array that lists item information for each inhabitant item_id
     * @param  bool  $in_environment  - Filter inhabitants to only the ones currently in the user's environment
     */
    public function __construct(
        public int $id,
        public bool $item_specifics = true,
        public bool $in_environment = false
    ) {}

    public static function byId(int $id, bool $item_specifics = false, bool $in_environment = false): GetInhabitants
    {
        return new self($id, $item_specifics, $in_environment);
    }

    /**
     * @return RecursiveCollection<Inhabitant>
     */
    public function createDtoFromResponse(Response $response): RecursiveCollection
    {
        $item_specifics = $this->recursive($response)->get('item_specifics');

        return $this->recursive($response)->except('item_specifics')->transform(function ($inhabitant) use ($item_specifics) {
            if ($item_specifics) {
                $inhabitant = $inhabitant->put('item_specifics', $item_specifics->get($inhabitant->get('item_id')));
            }

            return Inhabitant::fromCollection($inhabitant);
        });
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => [
                6511,
                [
                    $this->id,
                    $this->item_specifics,
                    $this->in_environment,
                ],
            ],
            'X' => time(),
        ];
    }
}
