<?php

namespace Kauffinger\OnOfficeApi;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Repositories\Body\JsonBodyRepository;
use Saloon\Traits\Body\HasJsonBody;

class OnOfficeApiRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct()
    {
        $this->body = new JsonBodyRepository();
    }

    public function resolveEndpoint(): string
    {
        return '';
    }

    protected function defaultBody(): array
    {
        return [];
    }

    public function addAction(ActionInterface $action): OnOfficeApiRequest
    {
        $currentBody = $this->body->all();
        $this->body->add(
            'request',
            [
                'actions' => [
                    ...$currentBody['request']['actions'] ?? [],
                    $action->render(),
                ],
            ]);

        return $this;
    }
}
