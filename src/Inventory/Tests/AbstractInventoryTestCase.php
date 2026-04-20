<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Inventory\Tests;

use PHPUnit\Framework\TestCase;
use Saloon\Http\Faking\MockClient;
use Saloon\MockConfig;

class AbstractInventoryTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        MockClient::destroyGlobal();
        MockConfig::setFixturePath('src/Inventory/Tests/Fixtures');
    }
}
