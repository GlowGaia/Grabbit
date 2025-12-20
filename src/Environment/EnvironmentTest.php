<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\GaiaConnector;
use GlowGaia\Grabbit\Shared\Exceptions\GSIRequestException;
use PHPUnit\Framework\TestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class EnvironmentTest extends TestCase
{
    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws RequestException
     */
    public function test_it_can_retrieve_an_environment()
    {
        $gaia = new GaiaConnector;
        $request = GetEnvironment::make();

        /** @var Environment $environment */
        $environment = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $food_attribute = $environment->attributes[0];

        $loamflakes = $food_attribute->flavors[0];

        $this->assertEquals(17, $environment->max_inhabitant_count);

        $this->assertCount(4, $environment->attributes);
        $this->assertEquals('Food', $food_attribute->name);

        $this->assertCount(2, $food_attribute->flavors);
        $this->assertEquals('Loamflakes', $loamflakes->name);
    }
}
