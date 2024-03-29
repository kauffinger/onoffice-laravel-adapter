<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasRecordIds
{
    /**
     * @var int[]|null
     */
    private ?array $recordIds;

    /**
     * @param  int[]  $recordIds
     */
    public function setRecordIds(array $recordIds)
    {
        $this->recordIds = $recordIds;

        return $this;
    }

    public function addRecordIds(int ...$recordId)
    {
        $this->recordIds = [...$this->recordIds ?? [], ...$recordId];

        return $this;
    }
}
