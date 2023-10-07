<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum UserRightsModule: string
{
    case Folder = 'folder';
    case AgentsLog = 'agentslog';
    case Calendar = 'calendar';
    case Address = 'address';
    case Estate = 'estate';
    case Task = 'task';
    case Project = 'project';
    case Statistic = 'statistic';
    case SearchCriteria = 'searchcriteria';
    case File = 'file';
    case EmailDraft = 'emaildraft';
    case ObjectTracking = 'objecttracking';
    case Smartsite2Root = 'smartsite2root';
    case PdfForms = 'pdfforms';
    case AgentslogMail = 'agentslogmail';
}
