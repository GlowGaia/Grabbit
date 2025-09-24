<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Grabbit;
use PHPUnit\Framework\TestCase;

class UserEnvironmentTest extends TestCase
{
    public function test_it_can_retrieve_a_user_environment()
    {
        /** @var UserEnvironment $userEnvironment */
        $userEnvironment = Grabbit::grab(GetUserEnvironment::byId(9116373));

        $this->assertEquals('Tide Of Terror', $userEnvironment->name);

        $this->assertCount(4, $userEnvironment->attr_settings);
    }
}
