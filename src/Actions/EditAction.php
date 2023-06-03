<?php

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\EditActions\EditAddressAction;
use Kauffinger\OnOfficeApi\Actions\EditActions\EditEstateAction;

class EditAction
{
    public function address(int $resourceId): EditAddressAction
    {
        return new EditAddressAction(resourceId: $resourceId);
    }

    public function estate(int $resourceId): EditEstateAction
    {
        return new EditEstateAction(resourceId: $resourceId);
    }
}
