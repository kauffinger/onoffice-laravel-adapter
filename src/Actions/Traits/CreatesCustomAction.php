<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use Kauffinger\OnOfficeApi\Actions\CustomAction;
use Kauffinger\OnOfficeApi\Enums\ActionType;

trait CreatesCustomAction
{
    public function custom(): CustomAction
    {
        return new CustomAction(ActionType::Create);
    }
}
