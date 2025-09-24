<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Tests;

use GlowGaia\Grabbit\Grabbit;
use GlowGaia\Grabbit\Users\GetUser;
use GlowGaia\Grabbit\Users\User;
use PHPUnit\Framework\TestCase;

class GrabbitTest extends TestCase
{
    public function test_it_can_make_a_request()
    {
        /** @var User|array $user */
        $user = Grabbit::grab(GetUser::byId(3));

        $this->assertEquals('Lanzer', $user->username);
    }

    public function test_it_can_make_multiple_requests()
    {
        $users = Grabbit::grab([
            GetUser::byId(2),
            GetUser::byId(3),
        ]);

        $this->assertEquals('admin', $users[0]->username);
        $this->assertEquals('Lanzer', $users[1]->username);
    }
}
