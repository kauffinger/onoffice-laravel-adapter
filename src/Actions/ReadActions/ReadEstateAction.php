<?php

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilterId;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFormattableOutput;
use Kauffinger\OnOfficeApi\Actions\Traits\HasGeoRangeSearch;
use Kauffinger\OnOfficeApi\Actions\Traits\HasMobileUrl;
use Kauffinger\OnOfficeApi\Actions\Traits\HasMultiLanguageEstates;
use Kauffinger\OnOfficeApi\Actions\Traits\HasPagination;

class ReadEstateAction implements ActionInterface
{
    use HasFilter;
    use HasFilterId;
    use HasPagination;
    use HasFormattableOutput;
    use HasMultiLanguageEstates;
    use HasGeoRangeSearch;
    use HasMobileUrl;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  array<string>  $data
     * `ARRAY of fields that you want to read.` *All fields specified in the enterprise administration are valid here.*
     * *Example:*
     * ```php
     * ['Id', 'kaufpreis', 'lage']
     * ```
     * If you want to read out the marketing status of an estate, you need you include verkauft and reserviert in the parameter data.
     * In the response verkauft = 1 defines the marketing status “Sold” or “Rented”, depeding on the marketing method.
     * reserviert = 1 stands for the marketing status “Reserved”.  verkauft = 0 and reserviert = 0 represent the marketing status “Open”.
     *
     * The special field multiParkingLot (Stellplätze Multiparking) can now also be queried and is listed as an array in the response.
     */
    public function setData(array $data): self
    {
        $this->actionArray['data'] = $data;

        return $this;
    }

    /**
     * @param  string[]  $fields
     * Alternative way to set data, see setData()
     */
    public function fieldsToRead(string ...$fields): self
    {
        $this->actionArray['data'] = [...$fields];

        return $this;
    }

    public function render(): array
    {
        return collect($this->actionArray)
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
    }
}
