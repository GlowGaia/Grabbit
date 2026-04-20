<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Common\Helpers;

use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CollectionNormalizer implements DenormalizerInterface, NormalizerInterface
{
    /**
     * @param  array<int|string, mixed>  $context
     * @return Collection<int|string, mixed>
     */
    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): Collection {
        if ($data instanceof Collection) {
            return $data;
        }

        /** @var array<int|string, mixed> $data */
        return Collection::make($data);
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $type === Collection::class
            || is_a(
                $type,
                Collection::class,
                true,
            );
    }

    /**
     * @param  array<int|string, mixed>  $context
     * @return array<int|string, mixed>
     */
    public function normalize(
        mixed $data,
        ?string $format = null,
        array $context = [],
    ): array {
        assert($data instanceof Collection);

        return $data->toArray();
    }

    public function supportsNormalization(
        mixed $data,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $data instanceof Collection;
    }

    /**
     * @return array<class-string, bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [Collection::class => true];
    }
}
