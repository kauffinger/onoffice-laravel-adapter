<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasRelatedAddressId
{
    private ?int $relatedAddressId;

    public function setRelatedAddressId(int $relatedAddressId)
    {
        $this->relatedAddressId = $relatedAddressId;

        return $this;
    }
}
