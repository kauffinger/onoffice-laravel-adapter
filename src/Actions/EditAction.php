<?php

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\EditActions\EditAddressAction;
use Kauffinger\OnOfficeApi\Actions\EditActions\EditEstateAction;
use Kauffinger\OnOfficeApi\Actions\EditActions\EditFileAction;
use Kauffinger\OnOfficeApi\Actions\EditActions\EditSearchCriteriaAction;

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

    public function searchCriteria(int $resourceId): EditSearchCriteriaAction
    {
        return new EditSearchCriteriaAction(resourceId: $resourceId);
    }

    public function file(int $fileId, int $parentId, string $relationType = 'estate'): EditFileAction
    {
        return new EditFileAction(fileId: $fileId, parentId: $parentId, relationType: $relationType);
    }
}
