<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\GSIOperation;
use Illuminate\Support\Collection;

class GetInhabitants extends GSIOperation
{
    private bool $item_specifics;

    public function __construct(int $method, ?array $parameters)
    {
        parent::__construct($method, $parameters);

        $this->dto = Inhabitant::class;
        $this->item_specifics = (bool) $parameters[1] ?? false;
    }

    public static function byId(int $id, bool $item_specifics = false, bool $in_environment = false): GetInhabitants
    {
        return new self(6511, [
            $id,
            (int) $item_specifics,
            (int) $in_environment,
        ]);
    }

    /**
     * @return Collection<Inhabitant>
     */
    public function dto(): Collection
    {
        $inhabitants = $this->json();

        $item_specifics = collect($this->item_specifics ? array_pop($inhabitants) : []);

        return collect($inhabitants)->transform(function ($inhabitant) use ($item_specifics) {
            $inhabitant['item_specifics'] = $item_specifics[$inhabitant['item_id']] ?? null;

            return $this->dto::fromArray($inhabitant);
        });
    }
}
