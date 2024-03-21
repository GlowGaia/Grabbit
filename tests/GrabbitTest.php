<?php
namespace Grabbit\Tests;

use GlowGaia\Grabbit\Grabbit;
use PHPUnit\Framework\TestCase;

class GrabbitTest extends TestCase{
    public function test_user_id_2_returns_admin_user(){
        $grabbit = new Grabbit();
        $response = $grabbit->it(102, [2])->grab();

        $this->assertSame('admin', $response[0]['username']);
    }
}