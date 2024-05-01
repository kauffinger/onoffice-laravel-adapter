<?php

namespace Kauffinger\OnOfficeApi;

use Illuminate\Support\Collection;
use Saloon\Http\Response;

class OnOfficeApiResponse extends Response
{
    /**
     * Get the results from all actions sent with the request.
     *
     * @throws \JsonException
     */
    public function results(): array
    {
        return $this->json('response.results');
    }

    /**
     * Get the results as a collection from all actions sent with the request.
     *
     * @throws \JsonException
     */
    public function collectedResults(): Collection
    {
        return collect($this->results());
    }

    /**
     * Get all records from an action sent with the request.
     * This is useful when, for example, sending a ReadAddress action.
     *
     * @throws \JsonException
     */
    public function elements(int $actionIndex = 0): array
    {
        $data = $this->getData($actionIndex);

        return data_get($data, 'records.*.elements', []);
    }

    /**
     * Get the data array of all results from all actions sent with the request.
     * When you set an index, you will get the data array of the result at that
     * index.
     *
     * @throws \JsonException
     */
    public function getData(?int $index = null): array
    {
        $data = data_get($this->results(), '*.data', []);

        if ($index !== null) {
            return $data[$index];
        }

        return $data;
    }

    /**
     * Get the collected data of all results from all actions sent with the request.
     * When you set an index, you will get the data array of the result at that
     * index.
     *
     * @throws \JsonException
     */
    public function getCollectedData(?int $index = null): Collection
    {
        return collect($this->getData($index));
    }

    /**
     * @throws \JsonException
     */
    public function status(): int
    {
        return (int) $this->json('status.code');
    }

    /**
     * As the onOffice API can take any amount of Actions of which each can be cacheable
     * or not, we need to loop over the whole response to determine if it is cacheable.
     *
     * @throws \JsonException
     */
    public function cacheable(): bool
    {
        $results = $this->collectedResults();

        return $results->isNotEmpty()
            && $results->filter(fn ($result) => $result['cacheable'] === false)
                ->isEmpty();
    }
}
