<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Common\Responses;

use JsonException;
use Saloon\Http\Response;

class GSIResponse extends Response
{
    /**
     * @throws JsonException
     */
    public function hasNoData(): bool
    {
        return !$this->hasData();
    }

    /**
     * @throws JsonException
     */
    public function hasData(): bool
    {
        return !empty($this->data());
    }

    /**
     * @return array<string, mixed>
     * @throws JsonException
     */
    public function data(): array
    {
        /** @var array<string, mixed> $data */
        $data = (array) $this->json('0.2');

        return $data;
    }

    /**
     * @throws JsonException
     */
    public function gsiFailed(): bool
    {
        return !$this->gsiSuccess();
    }

    /**
     * @throws JsonException
     */
    public function gsiSuccess(): bool
    {
        return $this->json('0.1') === true;
    }

}
