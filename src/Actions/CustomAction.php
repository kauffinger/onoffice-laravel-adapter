<?php

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Contracts\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;

class CustomAction implements ActionInterface
{
    private string $resourceId;

    private string $resourceType;

    private array $parameters = [];

    public function __construct(private readonly ActionType $actionType)
    {
    }

    public static function make(ActionType $actionType): CustomAction
    {
        return new CustomAction($actionType);
    }

    public function setResourceId(string $resourceId): CustomAction
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    public function setResourceType(string $resourceType): CustomAction
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    public function setParameters(array $parameters): CustomAction
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function render(): array
    {
        return [
            'actionid' => $this->actionType->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => $this->resourceType ?? '',
            'parameters' => $this->parameters ?? [],
        ];
    }
}
