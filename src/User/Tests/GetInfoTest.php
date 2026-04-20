<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\User\Tests;

use GlowGaia\Grabbit\Common\Connectors\GSIConnector;
use GlowGaia\Grabbit\User\DTOs\UserInfo;
use GlowGaia\Grabbit\User\Requests\GetInfo;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

final class GetInfoTest extends AbstractUserTestCase
{
    /**
     * @throws FatalRequestException | JsonException | RequestException
     */
    #[Test]
    public function it_can_retrieve_a_user_by_id(): void
    {
        $mockClient = new MockClient([
            GetInfo::class => MockResponse::fixture('get-info-by-username'),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->send(
            new GetInfo(3),
        );

        /** @var UserInfo $user */
        $user = $response->dto();

        $this->assertEquals('Lanzer', $user->username);
    }

    /**
     * @throws FatalRequestException | JsonException | RequestException
     */
    #[Test]
    public function it_can_retrieve_a_user_by_username(): void
    {
        $mockClient = new MockClient([
            GetInfo::class => MockResponse::fixture('get-info-by-username'),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->user()->getInfo('Lanzer');

        /** @var UserInfo $user */
        $user = $response->dto();

        $this->assertEquals(3, $user->gaia_id);
    }

    /**
     * @throws FatalRequestException | JsonException | RequestException
     */
    #[Test]
    public function it_can_retrieve_a_user_by_email_address(): void
    {
        $mockClient = new MockClient([
            GetInfo::class => MockResponse::fixture(
                'get-info-by-email-address',
            ),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->user()->getInfo('{REDACTED}');

        /** @var UserInfo $user */
        $user = $response->dto();

        $this->assertEquals('Lanzer', $user->username);
    }

    /**
     * @throws FatalRequestException | JsonException | RequestException
     */
    #[Test]
    public function it_can_handle_weird_usernames(): void
    {
        $first_client = new MockClient([
            GetInfo::class => MockResponse::fixture(
                'get-info-weird-name-decimals',
            ),
        ]);
        $second_client = new MockClient([
            GetInfo::class => MockResponse::fixture(
                'get-info-weird-name-punctuation',
            ),
        ]);

        $connector = new GSIConnector();

        $connector->withMockClient($first_client);
        $first_response = $connector->user()->getInfo('3.14');

        $connector->withMockClient($second_client);
        $second_response = $connector->user()->getInfo('?!');

        /** @var UserInfo $first_user */
        $first_user = $first_response->dto();
        /** @var UserInfo $second_user */
        $second_user = $second_response->dto();

        $this->assertEquals(87559, $first_user->gaia_id);
        $this->assertEquals(58812, $second_user->gaia_id);
    }
}
