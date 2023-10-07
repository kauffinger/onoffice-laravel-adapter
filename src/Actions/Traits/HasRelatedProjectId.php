<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasRelatedProjectId
{
    private ?int $relatedProjectId;

    public function setRelatedProjectId(int $relatedProjectId)
    {
        $this->relatedProjectId = $relatedProjectId;

        return $this;
    }
}
