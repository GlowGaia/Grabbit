<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\GaiaConnector;
use PHPUnit\Framework\TestCase;

class InhabitantsTest extends TestCase
{
    /**
     * Chuckp2 hasn't logged into Gaia since 2016. As much as I miss him,
     * I hope he doesn't break my tests
     */
    public function test_it_can_retrieve_user_inhabitants()
    {
        $gaia = new GaiaConnector;
        $request = GetInhabitants::byId(7);

        $inhabitants = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $inhabitant = $inhabitants->get($inhabitants->keys()->get(1));

        $this->assertCount(261, $inhabitants);
        $this->assertEquals('Steve', $inhabitant->name);
        $this->assertFalse(isset($inhabitant->item_specifics));
    }

    public function test_it_can_retrieve_user_inhabitants_with_item_information()
    {
        $gaia = new GaiaConnector;
        $request = GetInhabitants::byId(7, true);

        $inhabitants = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $inhabitant = $inhabitants->first();

        $this->assertTrue(isset($inhabitant->item_specifics));
        $this->assertEquals('Aquarium Banggai Cardinal', $inhabitant->item_specifics->name);
    }
}
