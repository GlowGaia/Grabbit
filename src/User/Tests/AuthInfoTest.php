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
use GlowGaia\Grabbit\User\Requests\AuthInfo;
use PHPUnit\Framework\Attributes\Test;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

final class AuthInfoTest extends AbstractUserTestCase
{
    /**
     * @throws FatalRequestException | RequestException
     */
    #[Test]
    public function it_retrieves_authenticated_user_info(): void
    {
        $mockClient = new MockClient([
            AuthInfo::class => MockResponse::fixture('auth-info'),
        ]);

        $connector = new GSIConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->user()->authInfo('{REDACTED}');

        /** @var UserInfo $user */
        $user = $response->dto();

        $this->assertEquals(37285493, $user->gaia_id);
        $this->assertEquals('Sight Ninja', $user->username);
    }

}
