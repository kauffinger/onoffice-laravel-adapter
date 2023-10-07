<?php

declare(strict_types=1);

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
