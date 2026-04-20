<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Inventory\Requests;

use GlowGaia\Grabbit\Common\Requests\AbstractRequest;
use GlowGaia\Grabbit\Common\Responses\GSIResponse;
use GlowGaia\Grabbit\Inventory\DTOs\Item;
use Illuminate\Support\Collection;
use JsonException;
use Saloon\Http\Response;

/**
 * Loads item information for given item ids
 *
 * @extends AbstractRequest<Item>
 */
final class LoadItemData extends AbstractRequest
{
    public int $code = 712;

    public string $name = 'inventory.loadItemData';

    /**
     * @param  int|int[]  $ids
     */
    public function __construct(
        array|int $ids,
        ?bool $package_item_ids = null,
    ) {
        $ids = (array) $ids;

        $this->parameters[] = implode(',', array_map(strval(...), $ids));
        $this->parameters[] = $package_item_ids;
    }

    /**
     * @return Collection<int, Item>
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        assert($response instanceof GSIResponse);

        /** @var array<int, array<string, mixed>> $data */
        $data = $response->data();

        /** @var Collection<int, Item> $mapped */
        $mapped = Collection::make($data)->map(
            fn(array $item)
                => $this->serializer()->denormalize(
                $item,
                Item::class,
            ),
        );

        return $mapped;
    }

    protected function dto(): string
    {
        return Item::class;
    }
}
