<?php

namespace Kauffinger\OnOfficeApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kauffinger\OnOfficeApi\OnOfficeApi
 */
class OnOfficeApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kauffinger\OnOfficeApi\OnOfficeApi::class;
    }
}
