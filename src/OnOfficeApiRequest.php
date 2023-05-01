<?php

namespace Kauffinger\OnOfficeApi;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class OnOfficeApiRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(private ActionType $action)
    {
    }

    public function resolveEndpoint(): string
    {
        return '';
    }

    public function addAction(ActionInterface $action): void
    {
        $this->body->add('request', $action->render());
    }
}
