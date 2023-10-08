<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum AppointmentReminderInterval: string
{
    case ZeroMinutes = '0 minutes';
    case FifteenMinutes = '15 minutes';
    case ThirtyMinutes = '30 minutes';
    case OneHour = '1 hours';
    case TwoHours = '2 hours';
    case ThreeHours = '3 hours';
    case OneDay = '1 days';
    case TwoDays = '2 days';
    case ThreeDays = '3 days';
    case OneWeek = '1 weeks';
    case ThreeWeeks = '3 weeks';
}
