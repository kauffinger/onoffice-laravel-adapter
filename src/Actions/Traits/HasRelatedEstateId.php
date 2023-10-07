<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasRelatedEstateId
{
    private ?int $relatedEstateId;

    public function setRelatedEstateId(int $relatedEstateId)
    {
        $this->relatedEstateId = $relatedEstateId;

        return $this;
    }
}
