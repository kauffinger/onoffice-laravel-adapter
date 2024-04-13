<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\GetActions\GetLinkAction;
use Kauffinger\OnOfficeApi\Enums\GetLinkModule;

class GetAction
{
    public function link(GetLinkModule $fromModule, int $recordId): GetLinkAction
    {
        return new GetLinkAction($fromModule, $recordId);
    }
}
