<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use Saloon\Http\Response;

class GetInhabitants extends GSIRequest
{
    public function __construct(
        public int $id,
        public bool $item_specifics = true,
        public bool $in_environment = false
    ) {}

    public static function byId(int $id, bool $item_specifics = false, bool $in_environment = false): GetInhabitants
    {
        return new self($id, $item_specifics, $in_environment);
    }

    /**
     * @return Inhabitant[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        $data = $this->validateResponse($response);
        $payload = $data[0][2] ?? [];

        $itemSpecificsSource = $payload['item_specifics'] ?? [];

        $inhabitants = [];
        foreach ($payload as $key => $node) {
            if ($key === 'item_specifics' || ! is_array($node)) {
                continue;
            }

            if ($this->item_specifics && isset($node['item_id'])) {
                $itemId = (string) $node['item_id'];
                if (isset($itemSpecificsSource[$itemId])) {
                    $node['item_specifics'] = $itemSpecificsSource[$itemId];
                }
            }

            $inhabitants[] = Inhabitant::fromArray($node);
        }

        return $inhabitants;
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => [
                6511,
                [
                    $this->id,
                    $this->item_specifics,
                    $this->in_environment,
                ],
            ],
            'X' => time(),
        ];
    }
}
