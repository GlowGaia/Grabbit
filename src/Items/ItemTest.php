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
}
