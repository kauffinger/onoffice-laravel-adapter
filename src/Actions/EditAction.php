<?php

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\EditActions\EditAddressAction;

class EditAction
{
    public function address(int $resourceId): EditAddressAction
    {
        return new EditAddressAction(resourceId: $resourceId);
    }
}
