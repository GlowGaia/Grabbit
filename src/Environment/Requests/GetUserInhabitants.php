<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\Requests;

use GlowGaia\Grabbit\Common\Requests\AbstractRequest;
use GlowGaia\Grabbit\Common\Responses\GSIResponse;
use GlowGaia\Grabbit\Environment\DTOs\Inhabitant;
use Illuminate\Support\Collection;
use JsonException;
use Saloon\Http\Response;

/**
 * Retrieve a list of all user inhabitants (fish)
 *
 * @extends AbstractRequest<Inhabitant>
 */
class GetUserInhabitants extends AbstractRequest
{
    public int $code = 6511;

    public string $name = 'environment.getUserInhabitants';

    public function __construct(
        public int $user_environment_id,
        public ?bool $show_item_specifics = false,
        public ?bool $show_only_intank = null,
    ) {
        $this->parameters = [
            $this->user_environment_id,
            $this->show_item_specifics,
            $this->show_only_intank,
        ];
    }

    /**
     * Instead of creating a DTO directly, we create a Collection of Inhabitant
     * DTOs. Due to some API weirdness, we also take the item_specifics key out
     * of the main response, and then add it to each inhabitant so that the
     * information is always available. (This endpoint design is bonkers to me)
     *
     * @return Collection<int|string, Inhabitant>
     * @throws JsonException
     * @todo Consider changing this behavior upon feedback and personal
     *       testing. Consumers may want to strip out the item_specifics key,
     *       add those entries to a database, and then work with each
     *       inhabitant
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        assert($response instanceof GSIResponse);

        /** @var array<int|string, mixed> $response_data */
        $response_data = $response->data();

        $data = Collection::make($response_data);

        /** @var array<int|string, mixed> $item_specifics */
        $item_specifics = $data->pull('item_specifics') ?? [];

        $specifics = Collection::make($item_specifics);

        return $data->filter(fn($item) => is_array($item))->map(
            function (mixed $item) use ($specifics) {
                /** @var array<string, mixed> $item */
                /** @var int|string $item_id */
                $item_id = $item['item_id'];
                $item['item_specifics'] = $specifics->get($item_id);

                /** @var Inhabitant */
                return $this->serializer()->denormalize(
                    $item,
                    Inhabitant::class,
                );
            },
        );
    }

    protected function dto(): string
    {
        return Inhabitant::class;
    }
}
