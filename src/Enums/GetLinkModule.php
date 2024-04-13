<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum GetLinkModule: string
{
    case Address = 'address';
    case Estate = 'estate';
    case AgentsLog = 'agentslog';
}
