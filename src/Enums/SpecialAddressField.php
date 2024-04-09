<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum SpecialAddressField: string
{
    case Phone = 'phone';
    case PrivatePhone = 'phone_private';
    case BusinessPhone = 'phone_business';
    case MobilePhone = 'mobile';
    case Email = 'email';
    case PrivateEmail = 'email_private';
    case BusinessEmail = 'email_business';
    case Fax = 'fax';
    case PrivateFax = 'fax_private';
    case BusinessFax = 'fax_business';

    public static function getAllCases(): array
    {
        return array_column(self::cases(), 'value');
    }
}
