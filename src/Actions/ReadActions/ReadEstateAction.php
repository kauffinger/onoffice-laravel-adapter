<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilterId;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFormattableOutput;
use Kauffinger\OnOfficeApi\Actions\Traits\HasGeoRangeSearch;
use Kauffinger\OnOfficeApi\Actions\Traits\HasMobileUrl;
use Kauffinger\OnOfficeApi\Actions\Traits\HasMultiLanguageEstates;
use Kauffinger\OnOfficeApi\Actions\Traits\HasOutputLanguage;
use Kauffinger\OnOfficeApi\Actions\Traits\HasPagination;
use Kauffinger\OnOfficeApi\Actions\Traits\HasResourceId;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

class ReadEstateAction implements ActionInterface
{
    use HasFilter;
    use HasFilterId;
    use HasFormattableOutput;
    use HasGeoRangeSearch;
    use HasMobileUrl;
    use HasMultiLanguageEstates;
    use HasOutputLanguage;
    use HasPagination;
    use HasResourceId;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  string[]  $data  array of fields that you want to read e.g. ['Id', 'kaufpreis', 'lage']
     *                          If you want to read out the marketing status of an estate, you need you include verkauft and reserviert in the parameter data.
     *                          In response, verkauft = 1 defines the marketing status “Sold” or “Rented”, depeding on the marketing method.
     *                          reserviert = 1 stands for the marketing status “Reserved”.  verkauft = 0 and reserviert = 0 represent the marketing status “Open”.
     *
     * The special field multiParkingLot (Stellplätze Multiparking) can now also be queried and is listed as an array in the response.
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
            ->putIfNotNull('filterId', $this->filterId ?? null)
            ->putIfNotNull('filter', $this->filter ?? null)
            ->putIfNotNull('listlimit', $this->listLimit ?? null)
            ->putIfNotNull('listoffset', $this->listOffset ?? null)
            ->putIfNotNull('sortby', $this->sortBy ?? null)
            ->putIfNotNull('formatoutput', $this->formatOutput ?? null)
            ->putIfNotNull('estatelanguage', $this->estateLanguage ?? null)
            ->putIfNotNull('outputlanguage', $this->outputLanguage ?? null)
            ->putIfNotNull('addestatelanguage', $this->addEstateLanguage ?? null)
            ->putIfNotNull('addMainLangId', $this->addEstateMainLangId ?? null)
            ->putIfNotNull('georangesearch', $this->geoRangeSearch ?? null)
            ->putIfNotNull('addMobileUrl', $this->addMobileUrl ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => ReadResource::Estate->value,
            'parameters' => $parameters,
        ];
    }
}
