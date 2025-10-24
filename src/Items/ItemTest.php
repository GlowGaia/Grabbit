<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\GaiaConnector;
use LogicException;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function test_it_can_retrieve_an_item_by_id()
    {
        $gaia = new GaiaConnector;
        $request = GetItem::byId(1404);

        $item = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals('Angelic Halo', $item->name);
    }

    public function test_it_throws_an_exception_if_item_does_not_exist()
    {
        $gaia = new GaiaConnector;
        $nonexistent_item_request = GetItem::byId(-1);

        $this->expectException(LogicException::class);

        $gaia->send($nonexistent_item_request)->dtoOrFail();
    }

    public function test_it_throws_an_exception_for_items_with_no_information()
    {
        $gaia = new GaiaConnector;
        $no_info_item_request = GetItem::byId(1);

        $this->expectException(LogicException::class);

        $gaia->send($no_info_item_request)->dtoOrFail();
    }

    public function test_it_works_on_items_without_deviations()
    {
        $gaia = new GaiaConnector;
        $request = GetItem::byId(17746);

        $item = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals('Ring: Buddy Call', $item->name);
    }
}
