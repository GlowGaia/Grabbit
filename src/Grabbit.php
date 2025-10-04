<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit;

use Closure;
use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;
use GlowGaia\Grabbit\Shared\GSIOperation;
use Illuminate\Support\Collection;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class Grabbit
{
    public Collection $operations;

    public function __construct(array|GSIOperation $operations = [])
    {
        if ($operations instanceof GSIOperation) {
            $operations = [$operations];
        }

        $this->operations = collect($operations);
    }

    public static function grab(array|GSIOperation $operations = []): Closure|DTOInterface|Collection
    {
        /** @var Collection<DTOInterface> $response */
        $response = (new self($operations))->send()->dto();
        if ($response->count() === 1) {
            /** @return DTOInterface */
            return $response->first();
        }

        return $response;
    }

    public static function make(array|GSIOperation $operations = []): Grabbit
    {
        return new self($operations);
    }

    public function it(array $operations = []): Grabbit
    {
        $this->operations = collect($operations);

        return $this;
    }

    public function send(): Grabbit
    {
        $connector = new GaiaConnector;
        $request = new GSIRequest(collect());

        $this->operations->each(function ($operation) use ($request) {
            $operation->request = $request;
            $request->operations->push($operation);
        });

        try {
            $response = $connector->send($request);
            $this->operations->each(function ($operation, $index) use ($response) {
                $operation->response = $response->json()[$index];
            });
        } catch (FatalRequestException|JsonException|RequestException $e) {
            error_log($e->getMessage());
        }

        return $this;
    }

    public function json(): Collection
    {
        return $this->operations->map(function (GSIOperation $operation) {
            return $operation->json();
        });
    }

    public function dto(): Collection
    {
        return $this->operations->map(function (GSIOperation $operation) {
            return $operation->dto();
        });
    }
}
