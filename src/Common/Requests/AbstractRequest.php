<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Common\Requests;

use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;
use GlowGaia\Grabbit\Common\Helpers\CollectionNormalizer;
use GlowGaia\Grabbit\Common\Responses\GSIResponse;
use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasFormBody;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @template T of AbstractDTO
 */
abstract class AbstractRequest extends Request implements HasBody
{
    use HasFormBody;

    public string $name;
    /** @var array<int, mixed> $parameters */
    public array $parameters = [];

    /** @var class-string<Response>|null */
    protected ?string $response = GSIResponse::class;
    protected int $code;
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return 'json.php';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return [
            'm' => [
                $this->code,
                $this->parameters,
            ],
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        assert($response instanceof GSIResponse);

        return $this->denormalize($response->data(), $this->dto());
    }

    /**
     * @param  array<string,mixed>  $data
     * @return T
     */
    protected function denormalize(
        array $data,
        ?string $class = null,
    ): AbstractDTO {
        /** @var T */
        return $this->serializer()->denormalize($data, $class ?? $this->dto());
    }

    protected function serializer(): Serializer
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

    /** @return class-string<T> */
    abstract protected function dto(): string;

    /**
     * @return array<string, mixed>
     * @throws JsonException
     */
    public function data(Response $response): array
    {
        assert($response instanceof GSIResponse);

        return $response->data();
    }
}
