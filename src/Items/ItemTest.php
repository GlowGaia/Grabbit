<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\Grabbit;
use GlowGaia\Grabbit\Shared\Exceptions\GSIError;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function test_it_can_retrieve_an_item_by_id()
    {
        /** @var Item $item */
        $item = Grabbit::grab(GetItem::byId(1404));
        $this->assertEquals('Angelic Halo', $item->name);
    }

    public function test_it_will_throw_an_error_when_retrieving_nonexistent_item()
    {
        $this->expectException(GSIError::class);

        $nonexistent_item = Grabbit::grab(GetItem::byId(-1));
    }

    public function test_it_can_handle_items_with_no_data()
    {
        $this->expectException(GSIError::class);

        $no_info_item = Grabbit::grab(GetItem::byId(1));
    }
}
