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
     * @param  string  $field
     * One of the fields that you query in the data parameter.
     * @param  SortOrder  $order
     * Either Ascending or Descending.
     * @return void
     */
    public function addSortBy(string $field, SortOrder $order)
    {
        $this->sortBy = [
            ...$this->sortBy ?? [],
            'field' => $field,
            'order' => $order->value,
        ];

        return $this;
    }
}
