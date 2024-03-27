<?php
namespace Grabbit\Tests;

use GlowGaia\Grabbit\Grabbit;
use PHPUnit\Framework\TestCase;

class GrabbitTest extends TestCase{
    public function test_user_id_2_returns_admin_user(){
        $response = (new Grabbit(102, [2]))->grab();

        $this->assertSame('admin', $response[0]['username']);
    }
    public function test_multiple_requests_return_expected(){
        $grabbit = Grabbit::make(102, [2]);
        $grabbit->addMethod(102, [3]);

        $response = $grabbit->grab();

        $this->assertSame('admin', $response[0]['username']);
        $this->assertSame('Lanzer', $response[1]['username']);
    }

    public function test_bizarre_usernames_work(){
        $grabbit = Grabbit::make(102, ["?!"]);
        $grabbit->addMethod(102, ["3-14"]); //TODO 3.14

        $response = $grabbit->grab();

        $this->assertSame(58812, $response[0]['gaia_id']);
        $this->assertSame(87559, $response[1]['gaia_id']);
    }
}