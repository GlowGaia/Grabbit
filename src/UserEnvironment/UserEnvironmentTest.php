<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\GaiaConnector;
use GlowGaia\Grabbit\Shared\Exceptions\GSIRequestException;
use PHPUnit\Framework\TestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class UserEnvironmentTest extends TestCase
{
    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws RequestException
     * @throws UserEnvironmentNotFoundException
     */
    public function test_it_can_retrieve_a_user_environment()
    {
        $gaia = new GaiaConnector;
        $request = GetUserEnvironment::byId(9116373);

        $user_environment = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals('Tide Of Terror', $user_environment->name);

        $this->assertCount(4, $user_environment->attr_settings);
    }
}
