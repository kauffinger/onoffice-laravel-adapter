<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

trait HasFormattableOutput
{
    private ?bool $formatOutput;

    public function formatOutput()
    {
        $this->formatOutput = true;

        return $this;
    }
}
