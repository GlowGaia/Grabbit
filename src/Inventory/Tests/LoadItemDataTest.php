<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Inventory\Tests;

use GlowGaia\Grabbit\Common\Connectors\GSIConnector;
use GlowGaia\Grabbit\Inventory\DTOs\Item;
use GlowGaia\Grabbit\Inventory\Requests\LoadItemData;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

final class LoadItemDataTest extends AbstractInventoryTestCase
{
    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_can_retrieve_an_item_by_id(): void
    {
        $mockClient = new MockClient([
            LoadItemData::class => MockResponse::fixture(
                'load-item-data-single',
            ),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->inventory()->loadItemData(1404);

        /** @var Collection<int, Item> $items */
        $items = $response->dto();
        $item = $items->first();
        $this->assertNotNull($item);

        $this->assertEquals('Angelic Halo', $item->name);
    }

    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_can_retrieve_multiple_items_by_id(): void
    {
        $mockClient = new MockClient([
            LoadItemData::class => MockResponse::fixture(
                'load-item-data-multiple',
            ),
        ]);

        $items = [1404, 17746];

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->inventory()->loadItemData($items);

        /** @var Collection<int, Item> $dto */
        $dto = $response->dto();

        $this->assertEquals($items, $dto->pluck('item_id')->all());
    }

    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_can_retrieve_an_item_with_variations(): void
    {
        $mockClient = new MockClient([
            LoadItemData::class => MockResponse::fixture(
                'load-item-data-single-with-variation',
            ),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->inventory()->loadItemData(10402855);

        /** @var Collection<int, Item> $items */
        $items = $response->dto();
        $item = $items->first();
        $this->assertNotNull($item);

        $this->assertEquals('ii pariah ii\'s katana', $item->name);
        $this->assertCount(5, $item->variation_ids);
    }

    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_can_retrieve_an_item_with_package_item_ids(): void
    {
        $mockClient = new MockClient([
            LoadItemData::class => MockResponse::fixture(
                'load-item-data-single-with-package-item-ids',
            ),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->inventory()->loadItemData(11037075, true);

        /** @var Collection<int, Item> $items */
        $items = $response->dto();
        $item = $items->first();
        $this->assertNotNull($item);

        $this->assertEquals('Super Konpeito Bundle', $item->name);
        $this->assertCount(18, $item->package_item_ids);
    }
}
