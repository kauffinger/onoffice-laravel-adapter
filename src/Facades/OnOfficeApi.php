<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Facades;

use Illuminate\Support\Facades\Facade;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Kauffinger\OnOfficeApi\OnOfficeApiResponse;

/**
 * @see \Kauffinger\OnOfficeApi\OnOfficeApi
 *
 * @method static OnOfficeApiResponse send(OnOfficeApiRequest $request)
 * @method static OnOfficeApiRequest start()
 * @method static \Kauffinger\OnOfficeApi\OnOfficeApi for(string $token, string $secret)
 */
class OnOfficeApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kauffinger\OnOfficeApi\OnOfficeApi::class;
    }
}
