<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\Tests;

use GlowGaia\Grabbit\Common\Connectors\GSIConnector;
use GlowGaia\Grabbit\Environment\DTOs\UserEnvironment;
use GlowGaia\Grabbit\Environment\Exceptions\UserEnvironmentNotFoundException;
use GlowGaia\Grabbit\Environment\Requests\GetUserEnvironment;
use PHPUnit\Framework\Attributes\Test;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

class GetUserEnvironmentTest extends AbstractEnvironmentTestCase
{
    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_can_retrieve_a_user_environment(): void
    {
        $mockClient = new MockClient([
            GetUserEnvironment::class => MockResponse::fixture(
                'get-user-environment',
            ),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->environment()->getUserEnvironment(9116373);

        /** @var UserEnvironment $user_environment */
        $user_environment = $response->dto();

        $this->assertEquals('Tide Of Terror', $user_environment->name);

        $this->assertCount(4, $user_environment->attr_settings);

        $this->assertNotNull($user_environment->game_info);
        $this->assertEquals(
            'ended',
            $user_environment->game_info->state->value,
        );
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    #[Test]
    public function it_fails_when_user_environment_does_not_exist(): void
    {
        $mockClient = new MockClient([
            GetUserEnvironment::class => MockResponse::fixture(
                'do-not-get-user-environment',
            ),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $this->expectException(UserEnvironmentNotFoundException::class);

        // UserEnvironments with an even ID are all nonexistent
        $response = $connector->environment()->getUserEnvironment(2);
    }

}
