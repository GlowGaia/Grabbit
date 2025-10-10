<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Users;

use GlowGaia\Grabbit\Grabbit;
use GlowGaia\Grabbit\Shared\Exceptions\GSIError;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_it_can_retrieve_a_user_by_id()
    {
        /** @var User $user */
        $user = Grabbit::grab(GetUser::byId(3));
        $this->assertEquals('Lanzer', $user->username);
    }

    public function test_it_can_retrieve_a_user_by_username()
    {
        /** @var User $user */
        $user = Grabbit::grab(GetUser::byUsername('Lanzer'));
        $this->assertEquals(3, $user->gaia_id);
    }

    public function test_it_can_retrieve_a_user_by_email()
    {
        /** @var User $user */
        $user = Grabbit::grab(GetUser::byEmail('lanzer@gmail.com'));
        $this->assertEquals('Lanzer', $user->username);
    }

    public function test_it_can_handle_weird_usernames()
    {
        /** @var Collection<User> $users */
        $users = Grabbit::grab([
            GetUser::byUsername('3.14'),
            GetUser::byUsername('?!'),
        ]);
        /** @var User $first_user */
        $first_user = $users->get(0);

        /** @var User $second_user */
        $second_user = $users->get(1);

        $this->assertEquals(87559, $first_user->gaia_id);
        $this->assertEquals(58812, $second_user->gaia_id);
    }

    public function test_it_throws_an_error_on_user_not_found()
    {
        $this->expectException(GSIError::class);

        $nonexistent_user = Grabbit::grab(GetUser::byId(1));
    }
}
