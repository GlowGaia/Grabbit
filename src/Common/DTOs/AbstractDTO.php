<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Common\DTOs;

use GlowGaia\Grabbit\Common\Helpers\CollectionNormalizer;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonException;
use JsonSerializable;
use Saloon\Traits\Makeable;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @implements Arrayable<string, mixed>
 */
abstract class AbstractDTO implements Arrayable, Jsonable, JsonSerializable
{
    use Makeable;

    protected static function serializer(): Serializer
    {
        return new Serializer([
            new CollectionNormalizer(),
            new BackedEnumNormalizer(),
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
            new DateTimeNormalizer([
                DateTimeNormalizer::FORMAT_KEY => 'U',
            ]),
        ], [new JsonEncoder()]);
    }

    /**
     * @throws JsonException
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options | JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        /** @var array<string, mixed> $vars */
        $vars = get_object_vars($this);

        return $vars;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
