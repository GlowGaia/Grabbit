<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Users;

use GlowGaia\Grabbit\GaiaConnector;
use LogicException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_it_can_retrieve_a_user_by_id()
    {
        $gaia = new GaiaConnector;
        $request = GetUser::byId(3);

        $user = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals('Lanzer', $user->username);
    }

    public function test_it_can_retrieve_a_user_by_username()
    {
        $gaia = new GaiaConnector;
        $request = GetUser::byUsername('Lanzer');

        $user = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals(3, $user->gaia_id);
    }

    public function test_it_can_retrieve_a_user_by_email()
    {
        $gaia = new GaiaConnector;
        $request = GetUser::byEmail('lanzer@gmail.com');

        $user = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals('Lanzer', $user->username);
    }

    public function test_it_can_handle_weird_usernames()
    {
        $gaia = new GaiaConnector;
        $first_user_request = GetUser::byUsername('3.14');
        $second_user_request = GetUser::byUsername('?!');

        $first_user = $first_user_request->createDtoFromResponse(
            $gaia->send($first_user_request)
        );

        $second_user = $second_user_request->createDtoFromResponse(
            $gaia->send($second_user_request)
        );

        $this->assertEquals(87559, $first_user->gaia_id);
        $this->assertEquals(58812, $second_user->gaia_id);
    }

    public function test_it_throws_an_exception_if_user_is_not_found()
    {
        $gaia = new GaiaConnector;
        $nonexistent_user_request = GetUser::byId(1);

        $this->expectException(LogicException::class);

        $gaia->send($nonexistent_user_request)->dtoOrFail();
    }
}
