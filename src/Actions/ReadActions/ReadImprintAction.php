<?php

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasResourceId;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\Language;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

/**
 * Reads the imprint in enterprise (Extras >> Settings >> Basic settings). If the user is a member of an office group, the imprint of the office group is retrieved (Extras >> Settings >> Groups >> Tab basic data).
 * The user ID can be specified as the resource ID. The imprint of this user is output. If no resource ID is specified, the imprint of the calling user is output.
 */
class ReadImprintAction implements ActionInterface
{
    use HasResourceId;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  string[]  $data
     * The fields you want to query. If data is not set, all fields will be returned. The following fields can be queried: title, firstname, lastname, firma, postcode, city, street, housenumber, state, country, phone, mobil, fax, email, homepage, vertretungsberechtigter, berufsaufsichtsbehoerde, handelsregister, handelsregisterNr, ustId, bank, iban, bic, chamber.
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

    /**
     * Default = user language. Language in format ISO-3166-1, e.g. DEU, ENG. If language is set, the fields “title” (Anrede) and “country” are returned in the specified language.
     */
    public function language(Language $language): self
    {
        $this->actionArray['language'] = $language->value;

        return $this;
    }

    /**
     * Default = false. If set on true, the field “country” will return the country name. If set on false, the field “country” will return the 3 letter ISO-3166-1 country code.
     */
    public function formatOutput(): self
    {
        $this->actionArray['formatoutput'] = true;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => '',
            'resourcetype' => ReadResource::Imprint->value,
            'parameters' => $parameters,
        ];
    }
}
