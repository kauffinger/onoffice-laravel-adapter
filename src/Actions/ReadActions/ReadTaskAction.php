<?php

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasMobileUrl;
use Kauffinger\OnOfficeApi\Actions\Traits\HasPagination;
use Kauffinger\OnOfficeApi\Actions\Traits\HasRelatedAddressId;
use Kauffinger\OnOfficeApi\Actions\Traits\HasRelatedEstateId;
use Kauffinger\OnOfficeApi\Actions\Traits\HasRelatedProjectId;
use Kauffinger\OnOfficeApi\Actions\Traits\HasResourceId;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

class ReadTaskAction implements ActionInterface
{
    use HasFilter;
    use HasMobileUrl;
    use HasPagination;
    use HasRelatedAddressId;
    use HasRelatedEstateId;
    use HasRelatedProjectId;
    use HasResourceId;

    private ?bool $responsibilityByGroup = null;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * Flag, if a group is responsible for the task.
     *
     * @return $this  */
    public function setResponsibilityByGroup()
    {
        $this->responsibilityByGroup = true;

        return $this;
    }

    /**
     * @param  string[]  $data
     * `ARRAY of fields that you want to read.`
     * *List of available fields:*
     * ```
     * Eintragsdatum, modified, von, Deadline, Prio, Aufgabe, Verantwortung, Art, Status, Betreff, Bearbeiter, Beginnt_am, Aufwand_Soll_NUM, Einheit_Aufwand_Soll, Aufwand_Zusatz_NUM, Einheit_Aufwand_Zusatz, erledigt, publicDescription, Stand, Deadline_strikt, Deadline_Zeit, Beginnt_um, Austragsdatum, Erinnerung, Erinnerungsdatum, Erinnerungsdatum_Zeit, Privat, Verantwortung_Gruppe, Kommentar
     * ```
     */
    public function setData(array $data): self
    {
        $this->actionArray['data'] = $data;

        return $this;
    }

    /**
     * Alternative way to set data, see setData()
     */
    public function fieldsToRead(string ...$fields): self
    {
        $this->actionArray['data'] = [...$fields];

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->putIfNotNull('filter', $this->filter ?? null)
            ->putIfNotNull('listlimit', $this->listLimit ?? null)
            ->putIfNotNull('listoffset', $this->listOffset ?? null)
            ->putIfNotNull('sortby', $this->sortBy ?? null)
            ->putIfNotNull('relatedAddressId', $this->relatedAddressId ?? null)
            ->putIfNotNull('relatedEstateId', $this->relatedEstateId ?? null)
            ->putIfNotNull('relatedProjectIds', $this->relatedProjectId ?? null)
            ->putIfNotNull('responsibilityByGroup', $this->responsibilityByGroup ?? null)
            ->putIfNotNull('addMobileUrl', $this->addMobileUrl ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => ReadResource::Task->value,
            'parameters' => $parameters,
        ];
    }
}
