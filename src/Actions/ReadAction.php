<?php

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadTaskAction;

class ReadAction
{
    public function estate(): ReadEstateAction
    {
        return new ReadEstateAction();
    }

    public function task(): ReadTaskAction
    {
        return new ReadTaskAction();
    }
}
