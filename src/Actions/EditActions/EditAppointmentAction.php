<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\EditActions;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\AppointmentReminderInterval;
use Kauffinger\OnOfficeApi\Enums\EditResource;

/**
 * `Changes information from address records.`
 */
class EditAddressAction implements ActionInterface
{
    public function __construct(
        private readonly int $resourceId,
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  array<string, string>  $map  Keys of fields to change and values they should be changed to. `Land` must be ISO 3166-1 alpha-3. To change the contact data of an address record (telephone, fax, email) additional parameters are necessary and are supported through the `add`, `modify`, and `delete` methods.
     */
    public function update(array $map): self
    {
        foreach ($map as $key => $value) {
            $this->actionArray['data'][$key] = $value;
        }

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->actionArray['data']['description'] = $description;

        return $this;
    }

    public function setStartDate(Carbon $date): self
    {
        $this->actionArray['data']['start_dt'] = $date->format('Y-m-d H:i:s');

        return $this;
    }

    public function setEndDate(Carbon $date): self
    {
        $this->actionArray['data']['end_dt'] = $date->format('Y-m-d H:i:s');

        return $this;
    }

    public function setKind(string $kind): self
    {
        $this->actionArray['data']['art'] = $kind;

        return $this;
    }

    public function setFullDay(bool $fullDay): self
    {
        $this->actionArray['data']['ganztags'] = $fullDay;

        return $this;
    }

    /**
     * Either set a transit time or a transit time with return time.
     * Only passing $transitTime will set 'transitTime', passing two parameters will set 'transitTimePre' and 'transitTimePost'
     */
    public function setTransitTime(CarbonInterval $transitTime, ?CarbonInterval $returnTime = null): self
    {
        $this->actionArray['data']['allowTransitTime'] = true;

        if (! $returnTime instanceof \Carbon\CarbonInterval) {
            $this->actionArray['data']['transitTime'] = $transitTime;

            return $this;
        }

        $this->actionArray['data']['transitTimePre'] = $transitTime->format('H:i:s');
        $this->actionArray['data']['transitTimePost'] = $returnTime->format('H:i:s');

        return $this;
    }

    public function setNote(string $note): self
    {
        $this->actionArray['data']['note'] = $note;

        return $this;
    }

    public function setCancelled(bool $cancelled): self
    {
        $this->actionArray['data']['abgesagt'] = $cancelled;

        return $this;
    }

    public function setPrivate(bool $private): self
    {
        $this->actionArray['data']['privat'] = $private;

        return $this;
    }

    public function setReminder(AppointmentReminderInterval $interval): self
    {
        $this->actionArray['data']['erinnerung'] = $interval->value;

        return $this;
    }

    public function setOrigin(bool $origin): self
    {
        $this->actionArray['data']['origin'] = $origin;

        return $this;
    }

    /**
     * Ressources of the appointment. All existing ressources are replaced with the given array. The values can be read out under “Extras >> Settings >> Administration >> Singleselect >> Modul: Calendar management, Field: ressources”
     */
    public function setResources(string ...$resources): self
    {
        $this->actionArray['data']['ressources'] = $resources;

        return $this;
    }

    /**
     * The user to be entered as the appointment creator at field “von” (creator). The username can be queried via Get users.
     */
    public function setCreator(string $creator): self
    {
        $this->actionArray['data']['creator'] = $creator;

        return $this;
    }

    public function addRelatedAddressIds(int ...$addressIds): self
    {
        $this->actionArray['relatedAddressIds'] = $addressIds;
        $this->actionArray['replaceAddressIds'] = false;

        return $this;
    }

    public function setRelatedAddressIds(int ...$addressIds): self
    {
        $this->actionArray['relatedAddressIds'] = $addressIds;
        $this->actionArray['replaceAddressIds'] = true;

        return $this;
    }

    //TODO: location, subscribers, reminderTypes

    public function setRelatedEstateIds(int $estateId): self
    {
        $this->actionArray['relatedEstateId'] = $estateId;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->toArray();

        return [
            'actionid' => ActionType::Edit->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => EditResource::Address->value,
            'parameters' => $parameters,
        ];
    }
}
