<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasFilter
{
    private ?array $filter = [];

    /**
     * Must be one of the following: `is` or `=`, `>`, `<`, `>=`, `<=`, `!=` or `<>`, `between`, `like`, `not like`, `in`, `not in`
     *
     * @param  string|int|array  $value
     *                                   For some params, this can be an array of values.
     *                                   When using like, you can use `%` as a wildcard.
     */
    public function addFilter(string $operator, string|int|array $value)
    {
        if (isset($this->resourceId)) {
            throw new \InvalidArgumentException('Filter cannot be set when resourceId is set.');
        }
        if (! in_array($operator, ['is', '=', '>', '<', '>=', '<=', '!=', '<>', 'between', 'like', 'not like', 'in', 'not in'])) {
            throw new \InvalidArgumentException('Invalid operator');
        }
        $this->filter = [
            ...$this->filter ?? [],
            [
                'op' => $operator,
                'val' => $value,
            ],
        ];

        return $this;
    }

    /**
     * This method can be used to overwrite the filter using a whole array. Usually, you should use addFilter() instead.
     *
     * The whole filter array, including all filters.
     */
    public function setFilter(array $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): ?array
    {
        return $this->filter;
    }
}
