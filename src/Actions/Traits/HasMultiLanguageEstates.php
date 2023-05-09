<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use Kauffinger\OnOfficeApi\Enums\Language;

trait HasMultiLanguageEstates
{
    private ?string $estateLanguage;

    private ?bool $addEstateLanguage;

    private ?bool $addEstateMainLangId;

    private ?string $outputLanguage;

    /**
     * @param  Language  $estateLanguage
     * Language of the object, only relevant for multi-language estates. Specified in ISO format with 3 characters, e.g. DEU, ENG. You cannot query properties in a different language without specifying this parameter. Only the ID is not sufficient! You can only query directly via ID if the property is in the main language.
     */
    public function estateLanguage(Language $estateLanguage)
    {
        $this->estateLanguage = $estateLanguage->value;

        return $this;
    }

    /**
     * Adds estate language to the response. If set to true, in the result language is set to the A3 abbreviation of the language if it is a multilingual estate, or an empty string if the estate is in the default language.
     */
    public function addEstateLanguageToOutput()
    {
        $this->addEstateLanguage = true;

        return $this;
    }

    /**
     * Adds the estate ID of the estate in the main language to the response.
     */
    public function addEstateMainLangIdToOutput()
    {
        $this->addEstateMainLangId = true;

        return $this;
    }
}
