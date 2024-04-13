<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums\OnOfficeResources;

use Kauffinger\OnOfficeApi\Contracts\OnOfficeResource;

enum ReadResource: string implements OnOfficeResource
{
    case Estate = 'estate';
    case Address = 'address';
    case AgentsLog = 'agentslog';
    case Appointment = 'calendar';
    case Task = 'task';
    case User = 'user';
    case UserPhoto = 'userphoto';
    case BasicSettings = 'basicsettings';
    case Imprint = 'impressum';
    case UserRights = 'checkuserrecordsright';
    case RecordsLastSeen = 'recordsLastSeen';
}
