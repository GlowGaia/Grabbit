<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\Shared\Exceptions\GSIRequestException;
use Saloon\Http\Response;

class ItemNotFoundException extends GSIRequestException
{
    public function __construct(Response $response, int $id)
    {
        parent::__construct(
            $response,
            sprintf('Item with ID %d was not found or contains no data.', $id)
        );
    }
}
