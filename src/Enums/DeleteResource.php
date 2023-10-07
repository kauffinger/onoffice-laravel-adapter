<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum DeleteResource: string
{
    case SearchCriteria = 'searchcriteria';
    case Relation = 'relation';
    case Appointment = 'calendar';
    case File = 'file';
}
