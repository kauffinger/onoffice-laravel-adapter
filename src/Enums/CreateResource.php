<?php

namespace Kauffinger\OnOfficeApi\Enums;

enum CreateResource: string implements ResourceEnum
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
