<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions;

class Action
{
    public static function create(): CreateAction
    {
        return new CreateAction();
    }

    public static function delete(): DeleteAction
    {
        return new DeleteAction();
    }

    public static function do(): DoAction
    {
        return new DoAction();
    }

    public static function edit(): EditAction
    {
        return new EditAction();
    }

    public static function get(): GetAction
    {
        return new GetAction();
    }

    public static function modify(): ModifyAction
    {
        return new ModifyAction();
    }

    public static function read(): ReadAction
    {
        return new ReadAction();
    }
}
