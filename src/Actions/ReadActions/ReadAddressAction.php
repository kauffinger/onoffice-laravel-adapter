<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilterId;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFormattableOutput;
use Kauffinger\OnOfficeApi\Actions\Traits\HasMobileUrl;
use Kauffinger\OnOfficeApi\Actions\Traits\HasOutputLanguage;
use Kauffinger\OnOfficeApi\Actions\Traits\HasPagination;
use Kauffinger\OnOfficeApi\Actions\Traits\HasRecordIds;
use Kauffinger\OnOfficeApi\Actions\Traits\HasResourceId;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\CountryIsoCodeType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

/**
 * `Outputs information from address records.`
 * Use the parameter recordids to specify the desired addresses. Without this parameter, all addresses are output.
 * The parameters filterid and filter can also be used to restrict the selection of addresses. With self-created filters you could output the last changed addresses for example.
 * All fields specified in the enterprise administration are valid here and are passed as elements of an array in the parameter data. Each parameter is returned with the corresponding value of the record.
 * Contact details (telephone, fax, e-mail) are returned like this: „<identifier><typ>__<id>“.
 * In addresses, estates and other modules you can set relations like e.g. tenant, buyer, owner, contact person, estate units etc. These relations are not queried and set via estate or address calls, but this information is queried or set via the API calls “Create, Modify, Delete and Get relations”.
 * If fields of the type “file” are queried, the URL to this file is returned. The URL can only be accessed if you are logged in to the client and in the same browser context.
 * The parameters are followed by several example calls for different applications: reading out address data, reading out the addresses changed in the last 30 days via a filter, and querying the URL for the passport photo.
 * Note: Record number (Datensatznummer) and customer number (Kundennummer) are 2 different fields in addresses. The record number is the ID to be specified for the API.
 * If you want to query all records of a certain period, use the field Aenderung in the parameter filter.
 */
class ReadAddressAction implements ActionInterface
{
    use HasFilter;
    use HasFilterId;
    use HasFormattableOutput;
    use HasMobileUrl;
    use HasOutputLanguage;
    use HasPagination;
    use HasRecordIds;
    use HasResourceId;

    private ?CountryIsoCodeType $countryIsoCodeType = null;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * Works in combination with the field Land (country). The parameter countryIsoCodeType causes the output of the field Land to be displayed in ISO-3166-2 or ISO-3166-3. Valid values are ISO-3166-2 and ISO-3166-3. If the parameter is not set or the value of the parameter invalid, the country is displayed in full text.
     */
    public function setCountryIsoCodeType(CountryIsoCodeType $type)
    {
        $this->countryIsoCodeType = $type;

        return $this;
    }

    /**
     * @param  string[]  $data
     * `ARRAY of fields that you want to read.` *All fields specified in the enterprise administration are valid here.*
     * *Example:*
     * ```php
     * ['phone', 'mobile', 'fax']
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
            ->putIfNotNull('filterId', $this->filterId ?? null)
            ->putIfNotNull('recordIds', $this->recordIds ?? null)
            ->putIfNotNull('filter', $this->filter ?? null)
            ->putIfNotNull('listlimit', $this->listLimit ?? null)
            ->putIfNotNull('listoffset', $this->listOffset ?? null)
            ->putIfNotNull('sortby', $this->sortBy ?? null)
            ->putIfNotNull('formatoutput', $this->formatOutput ?? null)
            ->putIfNotNull('outputlanguage', $this->outputLanguage ?? null)
            ->putIfNotNull('countryIsoCodeType', $this->countryIsoCodeType->value ?? null)
            ->putIfNotNull('addMobileUrl', $this->addMobileUrl ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => ReadResource::Address->value,
            'parameters' => $parameters,
        ];
    }
}
