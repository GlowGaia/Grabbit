<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\Tests;

use GlowGaia\Grabbit\Common\Connectors\GSIConnector;
use GlowGaia\Grabbit\Environment\DTOs\Environment;
use GlowGaia\Grabbit\Environment\Requests\GetEnvironment;
use PHPUnit\Framework\Attributes\Test;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

final class GetEnvironmentTest extends AbstractEnvironmentTestCase
{
    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_can_retrieve_an_environment(): void
    {
        $mockClient = new MockClient([
            GetEnvironment::class => MockResponse::fixture('get-environment'),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->environment()->getEnvironment(1);

        /** @var Environment $environment */
        $environment = $response->dto();

        $food_attribute = $environment->attributes->first();
        $this->assertNotNull($food_attribute);

        $loamflakes = $food_attribute->flavors->first();
        $this->assertNotNull($loamflakes);

        $this->assertEquals(17, $environment->max_inhabitant_count);

        $this->assertCount(4, $environment->attributes);
        $this->assertEquals('Food', $food_attribute->name);

        $this->assertCount(2, $food_attribute->flavors);
        $this->assertEquals('Loamflakes', $loamflakes->name);
    }
}
