<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\GaiaConnector;
use GlowGaia\Grabbit\Shared\Exceptions\GSIRequestException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class ItemTest extends TestCase
{
    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws ItemNotFoundException
     * @throws RequestException
     */
    public function test_it_can_retrieve_an_item_by_id()
    {
        $gaia = new GaiaConnector;
        $request = GetItem::byId(1404);

        $item = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals('Angelic Halo', $item->name);
    }

    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws ItemNotFoundException
     * @throws RequestException
     */
    public function test_it_throws_an_exception_if_item_does_not_exist()
    {
        $gaia = new GaiaConnector;
        $nonexistent_item_request = GetItem::byId(-1);

        $this->expectException(LogicException::class);

        $gaia->send($nonexistent_item_request)->dtoOrFail();
    }

    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws ItemNotFoundException
     * @throws RequestException
     */
    public function test_it_throws_an_exception_for_items_with_no_information()
    {
        $gaia = new GaiaConnector;
        $no_info_item_request = GetItem::byId(1);

        $this->expectException(ItemNotFoundException::class);

        $response = $gaia->send($no_info_item_request);
        $no_info_item_request->createDtoFromResponse($response);
    }

    /**
     * @throws FatalRequestException
     * @throws GSIRequestException
     * @throws ItemNotFoundException
     * @throws RequestException
     */
    public function test_it_works_on_items_without_deviations()
    {
        $gaia = new GaiaConnector;
        $request = GetItem::byId(17746);

        $item = $request->createDtoFromResponse(
            $gaia->send($request)
        );

        $this->assertEquals('Ring: Buddy Call', $item->name);
    }
}
