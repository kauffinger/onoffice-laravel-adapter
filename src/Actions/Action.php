<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions;

class Action
{
    public static function read(): ReadAction
    {
        return new ReadAction();
    }

    public static function edit(): EditAction
    {
        return new EditAction();
    }

    public static function create(): CreateAction
    {
        return new CreateAction();
    }

    public static function get(): GetAction
    {
        return new GetAction();
    }
}
