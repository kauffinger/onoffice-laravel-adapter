<?php

namespace Kauffinger\OnOfficeApi\Enums;

enum ActionType: string
{
    case Read = 'urn:onoffice-de-ns:smart:2.5:smartml:action:read';
    case Get = 'urn:onoffice-de-ns:smart:2.5:smartml:action:get';
    case Create = 'urn:onoffice-de-ns:smart:2.5:smartml:action:create';
    case Edit = 'urn:onoffice-de-ns:smart:2.5:smartml:action:modify';
    case Do = 'urn:onoffice-de-ns:smart:2.5:smartml:action:do';

    public function getAvailableResourceTypes(): array
    {
        return match ($this) {
            self::Create => CreateResource::cases(),
            self::Get => GetResource::cases(),
            self::Read => ReadResource::cases(),
            self::Edit => EditResource::cases(),
            self::Do => DoResource::cases(),
        };
    }
}
