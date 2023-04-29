<?php

namespace Kauffinger\OnOfficeApi\Enums;

enum Resource: string
{
    case Estate = 'estate';
    case Address = 'address';
    case SearchCriteria = 'searchcriteria';
    case AgentsLog = 'agentslog';
    case Relation = 'relation';
    case Appointment = 'calendar';
    case Task = 'task';
    case WorkingList = 'workinglist';
    case User = 'user';
    case UserPhoto = 'userphoto';
    case BasicSettings = 'basicsettings';
    case Imprint = 'impressum';
    case UserRights = 'checkuserrecordsright';
    case RecordsLastSeen = 'recordsLastSeen';
}
