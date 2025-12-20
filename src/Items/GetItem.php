<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use Saloon\Http\Response;

class GetItem extends GSIRequest
{
    public function __construct(public int $id) {}

    public static function byId(int $id): self
    {
        return new self($id);
    }

    public function createDtoFromResponse(Response $response): Item
    {
        $data = $this->validateResponse($response);

        if (! isset($data[0][2][0]['item_id'])) {
            throw new ItemNotFoundException($response, $this->id);
        }

        return Item::fromArray($data);
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => [
                712,
                [
                    $this->id,
                ],
            ],
            'X' => time(),
        ];
    }
}
