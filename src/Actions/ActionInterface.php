<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions;

interface ActionInterface
{
    public function render(): array;
}
