<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Facades;

use Illuminate\Support\Facades\Facade;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Response;

/**
 * @see \Kauffinger\OnOfficeApi\OnOfficeApi
 *
 * @method static Response send(OnOfficeApiRequest $request)
 * @method static OnOfficeApiRequest start()
 */
class OnOfficeApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kauffinger\OnOfficeApi\OnOfficeApi::class;
    }
}
