<?php

namespace Kauffinger\OnOfficeApi\Enums;

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
