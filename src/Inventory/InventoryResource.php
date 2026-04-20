<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Inventory;

use GlowGaia\Grabbit\Inventory\Requests\LoadItemData;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class InventoryResource extends BaseResource
{
    /**
     * 712: inventory.loadItemData
     *
     * @param  int|int[]  $ids
     * @param  bool|null  $package_item_ids
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function loadItemData(
        array|int $ids,
        ?bool $package_item_ids = null,
    ): Response {
        return $this->connector->send(
            new LoadItemData($ids, $package_item_ids),
        );
    }
}
