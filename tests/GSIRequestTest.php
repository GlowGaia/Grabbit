<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Tests;

use GlowGaia\Grabbit\GaiaConnector;
use GlowGaia\Grabbit\GSIRequest;
use GlowGaia\Grabbit\Shared\GSIOperation;
use JsonException;
use PHPUnit\Framework\TestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class GSIRequestTest extends TestCase
{
    /**
     * @throws RequestException|JsonException|FatalRequestException
     */
    public function test_it_can_make_a_single_request()
    {
        $connector = new Gaiaconnector;
        $request = new GSIRequest(collect([
            new GSIOperation(102, [3]),
        ]));

        $response = $connector->send($request);
        $responseJson = $response->json();
        $this->assertEquals(200, $response->status());
        $this->assertIsArray($responseJson);
        $this->assertEquals('Lanzer', $responseJson[0][2]['username']);
    }

    /**
     * @throws RequestException|JsonException|FatalRequestException
     */
    public function test_it_can_make_multiple_requests()
    {
        $connector = new Gaiaconnector;
        $request = new GSIRequest(collect([
            new GSIOperation(102, [2]),
            new GSIOperation(102, [3]),
        ]));

        $response = $connector->send($request);
        $responseJson = $response->json();

        $this->assertEquals(200, $response->status());
        $this->assertIsArray($responseJson);

        $this->assertEquals('admin', $responseJson[0][2]['username']);
        $this->assertEquals('Lanzer', $responseJson[1][2]['username']);
    }
}
