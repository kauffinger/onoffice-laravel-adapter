<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasRecordIds;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;
use Kauffinger\OnOfficeApi\Enums\UserRightsModule;

/**
 * Read user rights
 * Reads out the user rights. Specify the type of right (action), module, userid and an array of recordIds. The response delivers a filtered array of recordIds, on which the user has read rights.
 */
class ReadUserRightAction implements ActionInterface
{
    use HasRecordIds;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * Action
     */
    public function actionType(ActionType $type): self
    {
        $this->actionArray['action'] = $type->value;

        return $this;
    }

    /**
     * Module
     */
    public function module(UserRightsModule $module): self
    {
        $this->actionArray['module'] = $module->value;

        return $this;
    }

    /**
     * userId
     */
    public function userId(int $userId): self
    {
        $this->actionArray['userId'] = $userId;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->putIfNotNull('recordIds', $this->recordIds ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => '',
            'resourcetype' => ReadResource::UserRights->value,
            'parameters' => $parameters,
        ];
    }
}
