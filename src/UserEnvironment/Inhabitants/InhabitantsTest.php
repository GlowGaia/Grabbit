<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Grabbit;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class InhabitantsTest extends TestCase
{
    /**
     * Chuckp2 hasn't logged into Gaia since 2016. As much as I miss him,
     * I hope he doesn't break my tests
     */
    public function test_it_can_retrieve_user_inhabitants()
    {
        /** @var Collection<Inhabitant> $inhabitants */
        $inhabitants = Grabbit::grab(GetInhabitants::byId(7));

        /** @var Inhabitant $inhabitant */
        $inhabitant = $inhabitants->get($inhabitants->keys()->get(1));

        $this->assertCount(261, $inhabitants);
        $this->assertEquals('Steve', $inhabitant->name);
        $this->assertFalse(isset($inhabitant->item_specifics));
    }

    public function test_it_can_retrieve_user_inhabitants_with_item_information()
    {
        /** @var Collection<Inhabitant> $inhabitants */
        $inhabitants = Grabbit::grab(GetInhabitants::byId(7, true));

        /** @var Inhabitant $inhabitant */
        $inhabitant = $inhabitants->first();

        $this->assertTrue(isset($inhabitant->item_specifics));
        $this->assertEquals('Aquarium Banggai Cardinal', $inhabitant->item_specifics->name);
    }
}
