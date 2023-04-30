<?php

namespace Kauffinger\OnOfficeApi;

use Kauffinger\OnOfficeApi\Enums\ActionType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class OnOfficeApiRequest extends Request implements HasBody
{
    use HasJsonBody;

    public function __construct(private ActionType $action)
    {
    }

    public function resolveEndpoint(): string
    {
        return '';
    }

    public function resolveMethod(): string
    {
        return 'POST';
    }
}
