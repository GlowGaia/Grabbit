<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\Tests;

use GlowGaia\Grabbit\Common\Connectors\GSIConnector;
use GlowGaia\Grabbit\Environment\DTOs\Inhabitant;
use GlowGaia\Grabbit\Environment\Requests\GetUserInhabitants;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

class GetUserInhabitantsTest extends AbstractEnvironmentTestCase
{
    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_can_retrieve_user_inhabitants(): void
    {
        $mockClient = new MockClient([
            GetUserInhabitants::class => MockResponse::fixture(
                'get-user-inhabitants',
            ),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector
            ->Environment()
            ->getUserInhabitants(9116373, true);

        /** @var Collection<int|string, Inhabitant> $inhabitants */
        $inhabitants = $response->dto();

        /** @var Inhabitant $inhabitant */
        $inhabitant = $inhabitants->get('3665858024');

        $this->assertCount(20, $inhabitants);

        $this->assertEquals('TestC', $inhabitant->name);

        $this->assertNotNull($inhabitant->item_specifics);
        $this->assertEquals(
            'Aquarium Lazor Fish',
            $inhabitant->item_specifics->name,
        );
    }

}
