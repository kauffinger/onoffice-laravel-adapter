<?php

declare(strict_types=1);

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
