<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\Grabbit;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function test_it_can_retrieve_an_item_by_id()
    {
        /** @var Item $item */
        $item = Grabbit::grab(GetItem::byId(1404));
        $this->assertEquals('Angelic Halo', $item->name);
    }

    public function test_it_gives_null_item_on_nonexistent_user()
    {
        $nonexistent_item = Grabbit::grab(GetItem::byId(-1));

        $this->assertInstanceOf(NullItem::class, $nonexistent_item);
    }

    public function test_it_returns_null_item_for_items_with_no_information()
    {
        $no_info_item = Grabbit::grab(GetItem::byId(1));

        $this->assertInstanceOf(NullItem::class, $no_info_item);
    }
}
