<?php

namespace Kauffinger\OnOfficeApi\Actions\EditActions;

use Carbon\Carbon;
use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\EditResource;

/**
 * `Changes information from estate records.`
 */
class EditSearchCriteriaAction implements ActionInterface
{
    const SPECIAL_FIELDS = ['advisor', 'sys_expirydate'];

    public function __construct(
        private int $resourceId,
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  array<string, mixed>  $data Keys of fields to change and values they should be changed to.
     */
    public function update(array $data): self
    {
        $invalidFields = array_intersect(self::SPECIAL_FIELDS, array_keys($data));
        if (! empty($invalidFields)) {
            $invalidFieldString = implode(',', $invalidFields);
            throw new \InvalidArgumentException(
                "Special fields '$invalidFieldString' must be changed using the `add`, `modify`, and `delete` methods."
            );
        }
        foreach ($data as $key => $value) {
            $this->actionArray['data'][$key] = $value;
        }

        return $this;
    }

    /**
     * Sets the advisor of the search criterion. The ID of the user must be specified, which can be retrieved via Get users. If omitted, the currently logged in user will be set as the advisor.
     */
    public function setAdvisor(int $userId): self
    {
        $this->actionArray['data']['advisor'] = $userId;

        return $this;
    }

    public function setActive(bool $active = true): self
    {
        $this->actionArray['data']['sys_status'] = $active ? 1 : 0;

        return $this;
    }

    public function setInactive(bool $active = false): self
    {
        $this->actionArray['data']['sys_status'] = $active ? 1 : 0;

        return $this;
    }

    public function setSysExpiryDate(Carbon $expiryDate)
    {
        $this->actionArray['data']['sys_expirydate'] = $expiryDate->format('Y-m-d');

        return $this;
    }

    public function render(): array
    {

        return [
            'actionid' => ActionType::Edit->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => EditResource::SearchCriteria->value,
            'parameters' => $this->actionArray,
        ];
    }
}
