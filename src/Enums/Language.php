<?php

namespace Kauffinger\OnOfficeApi\Enums;

/**
 * The codes used py onOffice for identifying languages. These seem not to follow a specific standard. Thus, please add a PR if one is missing.
 */
enum Language: string
{
    case German = 'DEU';
    case English = 'ENG';
    case Italian = 'ITA';
}
