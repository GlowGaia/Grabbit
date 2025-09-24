<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Grabbit;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function test_it_can_retrieve_an_environment()
    {
        /** @var Environment $environment */
        $environment = Grabbit::grab(GetEnvironment::make());

        /** @var Attribute $food_attribute */
        $food_attribute = $environment->attributes->first();

        /** @var Flavor $loamflakes */
        $loamflakes = $food_attribute->flavors->first();

        $this->assertEquals('17', $environment->max_inhabitant_count);

        $this->assertCount(4, $environment->attributes);
        $this->assertEquals('Food', $food_attribute->name);

        $this->assertCount(2, $food_attribute->flavors);
        $this->assertEquals('Loamflakes', $loamflakes->flavor);
    }
}
