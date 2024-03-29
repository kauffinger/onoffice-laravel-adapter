<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasResourceId
{
    private ?int $resourceId;

    public function setResourceId(int $resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }
}
