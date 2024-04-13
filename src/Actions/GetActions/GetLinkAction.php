<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\GetActions;

use InvalidArgumentException;
use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\AgentsLogLinkType;
use Kauffinger\OnOfficeApi\Enums\GetLinkModule;
use Kauffinger\OnOfficeApi\Enums\GetResource;

class GetLinkAction implements ActionInterface
{
    public function __construct(
        private readonly GetLinkModule $module,
        private readonly int           $recordId,
        private array                  $actionArray = [],
    ) {
        $this->actionArray['recordId'] = $this->recordId;
    }

    /**
     * Set the type of the link if you read from resourceType AgentsLog
     *
     * @throws InvalidArgumentException
     */
    public function setType(AgentsLogLinkType $type): static
    {
        if ($this->module !== GetLinkModule::AgentsLog) {
            throw new \InvalidArgumentException('Type is only allowed to be set for AgentsLog');
        }

        $this->actionArray['type'] = $type->value;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->toArray();

        return [
            'actionid' => ActionType::Get->value,
            'resourceid' => $this->module->value,
            'resourcetype' => GetResource::Link->value,
            'parameters' => $parameters,
        ];
    }
}
