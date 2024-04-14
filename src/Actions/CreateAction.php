<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\CreateActions\CreateAddressAction;
use Kauffinger\OnOfficeApi\Actions\CreateActions\CreateEstateAction;
use Kauffinger\OnOfficeApi\Actions\Traits\CreatesCustomAction;

class CreateAction
{
    use CreatesCustomAction;

    public function estate(): CreateEstateAction
    {
        return new CreateEstateAction();
    }

    public function address(): CreateAddressAction
    {
        return new CreateAddressAction();
    }
}
