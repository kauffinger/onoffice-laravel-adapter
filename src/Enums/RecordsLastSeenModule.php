<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum RecordsLastSeenModule: string
{
    case Address = 'address';
    case Estate = 'estate';
    case Task = 'task';
    case Email = 'email';
}
