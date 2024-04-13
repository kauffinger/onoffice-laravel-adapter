<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums\OnOfficeResources;

enum EditResource: string
{
    case Estate = 'estate';
    case Address = 'address';
    case SearchCriteria = 'searchcriteria';
    case Relation = 'relation';
    case Appointment = 'calendar';
    case Task = 'task';
    case TimeTracking = 'timetracking';
    case File = 'file';
}
