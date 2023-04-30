<?php

namespace Kauffinger\OnOfficeApi;

use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

class ReadEstatesRequest extends OnOfficeApiRequest
{
    public function __construct(
        private ReadResource $resource = ReadResource::Estate,
        private mixed $fields = [],
        private mixed $filter = [],
        private mixed $sortby = [],
    ) {
        parent::__construct(ActionType::Read);
    }

    protected function defaultBody(): array
    {
        return [
            'resourcetype' => $this->resource->value,
            'identifier' => '',
            'filter' => $this->filter,
            'data' => $this->fields,
            'listlimit' => 500,
            'listoffset' => 0,
            'sortby' => $this->sortby,
        ];
    }
}
