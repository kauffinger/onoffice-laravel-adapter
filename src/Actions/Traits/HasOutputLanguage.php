<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use InvalidArgumentException;
use Kauffinger\OnOfficeApi\Enums\Language;

trait HasOutputLanguage
{
    private ?string $outputLanguage;

    /**
     * @param  Language  $outputLanguage
     * Output language. E.g. the contents of the single- and multi-select fields are output in the specified language. Parameter formatoutput must be set to true.
     */
    public function outputInLanguage(Language $outputLanguage)
    {
        if (! isset($this->formatOutput) || ! $this->formatOutput) {
            throw new InvalidArgumentException('Parameter formatoutput must be set to true.');
        }
        $this->outputLanguage = $outputLanguage->value;

        return $this;
    }
}
