<?php

namespace Kauffinger\OnOfficeApi\Enums;

enum Resource: string
{
    case SearchCriteria = 'searchcriteria';
    case Relation = 'relation';
    case Appointment = 'calendar';
    case File = 'file';
}
