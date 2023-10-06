<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use Kauffinger\OnOfficeApi\Enums\SortOrder;

trait HasPagination
{
    private int $listLimit = 20;

    private int $listOffset = 0;

    private ?array $sortBy;

    public function setListLimit(int $limit)
    {
        $this->listLimit = $limit;

        return $this;
    }

    public function setPage(int $page)
    {
        $this->listOffset = $this->listLimit * ($page - 1);

        return $this;
    }

    /**
     * One of the fields that you query in the data parameter.
     * Either Ascending or Descending.
     */
    public function addSortBy(string $field, SortOrder $order)
    {
        $this->sortBy = [
            ...$this->sortBy ?? [],
            $field => $order->value,
        ];

        return $this;
    }
}
