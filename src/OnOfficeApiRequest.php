<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi;

use Illuminate\Support\Str;
use Kauffinger\OnOfficeApi\Contracts\ActionInterface;
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
                    [...$action->render(), 'identifier' => $this->generateActionIdentifier($action)],
                ],
            ]);

        return $this;
    }

    public function withAction(ActionInterface $action): OnOfficeApiRequest
    {
        return $this->addAction($action);
    }

    public static function with(ActionInterface $action): OnOfficeApiRequest
    {
        return (new OnOfficeApiRequest)->addAction($action);
    }

    private function generateActionIdentifier(ActionInterface $action): string
    {
        return Str::uuid()->toString();
    }
}
