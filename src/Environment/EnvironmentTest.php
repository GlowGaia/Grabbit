<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\GaiaConnector;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function test_it_can_retrieve_an_environment()
    {
        $gaia = new GaiaConnector;
        $request = GetEnvironment::make();

        $environment = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $food_attribute = $environment->attributes->first();

        $loamflakes = $food_attribute->flavors->first();

        $this->assertEquals('17', $environment->max_inhabitant_count);

        $this->assertCount(4, $environment->attributes);
        $this->assertEquals('Food', $food_attribute->name);

        $this->assertCount(2, $food_attribute->flavors);
        $this->assertEquals('Loamflakes', $loamflakes->flavor);
    }
}
