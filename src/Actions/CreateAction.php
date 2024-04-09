<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\CreateActions\CreateAddressAction;
use Kauffinger\OnOfficeApi\Actions\CreateActions\CreateEstateAction;

class CreateAction
{
    public function estate(): CreateEstateAction
    {
        return new CreateEstateAction();
    }

    public function address(): CreateAddressAction
    {
        return new CreateAddressAction();
    }
}
