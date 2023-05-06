<?php

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasDateRange;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasGroupIds;
use Kauffinger\OnOfficeApi\Actions\Traits\HasLastModificationFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasRecordIds;
use Kauffinger\OnOfficeApi\Actions\Traits\HasResourceId;
use Kauffinger\OnOfficeApi\Actions\Traits\HasUserIds;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

/**
 * Reads the database fields from an appointment record.
 * If you specify the resource ID of the appointment, the data of the appointment is returned.
 * If no resource ID is specified, the data of the appointments of a specific period can be requested via the parameters datestart and dateend. It will return the appointments of the logged-in user and his groups, when the parameters users and groups aren’t specified.
 * The user rights on appointments set in enterprise are respected. When queried by ID, more information is returned in the response.
 * The maximum number of appointments that can be queried at one time is 500. To avoid this restriction, please query smaller periods of time in which there are less than 500 appointments.
 */
class ReadAppointmentAction implements ActionInterface
{
    use HasFilter;
    use HasDateRange;
    use HasLastModificationFilter;
    use HasUserIds;
    use HasGroupIds;
    use HasRecordIds;
    use HasResourceId;

    private ?bool $showCancelled;

    private ?bool $allUsers;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * Flag if cancelled appointments should be requested.
     */
    public function showCancelled()
    {
        $this->showCancelled = true;

        return $this;
    }

    /**
     * Flag for reading out all data. If set on true, the parameters users and groups will be ignored.
     */
    public function allUsers()
    {
        if (isset($this->users) || isset($this->groups)) {
            throw new \InvalidArgumentException('Parameters users and groups would be ignored. Remove them to use this.');
        }
        $this->allUsers = true;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->putIfNotNull('datestart', $this->dateStart ?? null)
            ->putIfNotNull('dateend', $this->dateEnd ?? null)
            ->putIfNotNull('modifiedstart', $this->lastModificationDateStart ?? null)
            ->putIfNotNull('modifiedend', $this->lastModificationDateEnd ?? null)
            ->putIfNotNull('showcancelled', $this->showCancelled ?? null)
            ->putIfNotNull('users', $this->users ?? null)
            ->putIfNotNull('groups', $this->groups ?? null)
            ->putIfNotNull('allusers', $this->allUsers ?? null)
            ->putIfNotNull('filter', $this->filter ?? null)
            ->putIfNotNull('recordIds', $this->recordIds ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => ReadResource::Appointment->value,
            'parameters' => $parameters,
        ];
    }
}
