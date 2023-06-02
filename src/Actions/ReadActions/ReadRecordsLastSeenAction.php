<?php

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;
use Kauffinger\OnOfficeApi\Enums\RecordsLastSeenModule;

/**
 * **Read records last seen**
 * This API call can be used to query the number of recently viewed records. In enterprise this is the view “Last opened datasets” via the star. Currently the call only returns the number of records under “cntabsolute”, the records array is always empty. The call might be extended later. The maximum number of records is 1000, as in enterprise, where the number of records displayed is reduced to the 1000 most recent records every night per module. As with other read calls, restrictions can be made via the filter parameter.
 */
class ReadRecordsLastSeenAction implements ActionInterface
{
    use HasFilter;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * Module
     */
    public function module(RecordsLastSeenModule $module): self
    {
        $this->actionArray['module'] = $module->value;

        return $this;
    }

    /**
     * userId
     */
    public function userId(int $userId): self
    {
        $this->actionArray['user'] = $userId;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->put('listlimit', 0)
            ->putIfNotNull('filter', $this->filter ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => '',
            'resourcetype' => ReadResource::RecordsLastSeen->value,
            'parameters' => $parameters,
        ];
    }
}
