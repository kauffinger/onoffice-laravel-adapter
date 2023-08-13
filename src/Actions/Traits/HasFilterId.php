<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasFilterId
{
    private ?int $filterId;

    public function setFilterId(int $filterId)
    {
        $this->filterId = $filterId;

        return $this;
    }

    public function getFilterId(): ?int
    {
        return $this->filterId;
    }
}
