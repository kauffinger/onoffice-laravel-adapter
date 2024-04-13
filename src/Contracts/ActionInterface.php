<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Contracts;

interface ActionInterface
{
    public function render(): array;
}
