<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\GaiaConnector;
use GlowGaia\Grabbit\Shared\Exceptions\GSIRequestException;
use PHPUnit\Framework\TestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class InhabitantsTest extends TestCase
{
    /**
     * Chuckp2 hasn't logged into Gaia since 2016. As much as I miss him,
     * I hope he doesn't break my tests
     */
    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws RequestException
     */
    public function test_it_can_retrieve_user_inhabitants()
    {
        $gaia = new GaiaConnector;
        $request = GetInhabitants::byId(7);

        $inhabitants = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $inhabitant = $inhabitants[1];

        $this->assertCount(261, $inhabitants);
        $this->assertEquals('Steve', $inhabitant->name);
        $this->assertNull($inhabitant->item_specifics);
    }

    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws RequestException
     */
    public function test_it_can_retrieve_user_inhabitants_with_item_information()
    {
        $gaia = new GaiaConnector;
        $request = GetInhabitants::byId(7, true);

        $inhabitants = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $inhabitant = $inhabitants[0];

        $this->assertNotNull($inhabitant->item_specifics);
        $this->assertEquals('Aquarium Banggai Cardinal', $inhabitant->item_specifics->name);
    }
}
