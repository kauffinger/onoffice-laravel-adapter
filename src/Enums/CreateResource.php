<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum CreateResource: string implements OnOfficeResource
{
    case Estate = 'estate';
    case Address = 'address';
    case SearchCriteria = 'searchcriteria';
    case AgentsLog = 'agentslog';
    case Relation = 'relation';
    case Appointment = 'calendar';
    case Task = 'task';
    case WorkingList = 'workinglist';
}
