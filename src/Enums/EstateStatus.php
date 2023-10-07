<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum EstateStatus: string
{
    case Active = '1';
    case Pending = '2';
    case Archive = '0';
}
