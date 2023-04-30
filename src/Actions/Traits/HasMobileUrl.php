<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasMobileUrl
{
    private ?bool $addMobileUrl;

    public function addMobileUrl()
    {
        $this->addMobileUrl = true;

        return $this;
    }
}
