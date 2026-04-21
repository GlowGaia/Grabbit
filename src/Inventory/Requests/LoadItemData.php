<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Inventory\Requests;

use GlowGaia\Grabbit\Common\Helpers\CollectionNormalizer;
use GlowGaia\Grabbit\Common\Requests\AbstractRequest;
use GlowGaia\Grabbit\Common\Responses\GSIResponse;
use GlowGaia\Grabbit\Inventory\DTOs\Item;
use Illuminate\Support\Collection;
use JsonException;
use Saloon\Http\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    protected function serializer(): Serializer
    {
        return new Serializer([
            new DateTimeNormalizer([
                DateTimeNormalizer::FORMAT_KEY => 'Y-m-d',
            ]),
            new CollectionNormalizer(),
            new BackedEnumNormalizer(),
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ], [new JsonEncoder()]);
    }
}
