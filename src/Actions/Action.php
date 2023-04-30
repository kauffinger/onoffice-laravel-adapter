<?php

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadTaskAction;
use Kauffinger\OnOfficeApi\Enums\CreateResource;
use Kauffinger\OnOfficeApi\Enums\DeleteResource;
use Kauffinger\OnOfficeApi\Enums\DoResource;
use Kauffinger\OnOfficeApi\Enums\EditResource;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

class Action
{
    public static function create(CreateResource $resource)
    {

    }

    public static function delete(DeleteResource $resource)
    {

    }

    public static function do(DoResource $resource)
    {

    }

    public static function edit(EditResource $resource)
    {

    }

    public static function read(ReadResource $resource): ActionInterface
    {
        return match ($resource) {
            ReadResource::Estate => new ReadEstateAction(),
            ReadResource::Task => new ReadTaskAction(),
        };
    }
}
