<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use Kauffinger\OnOfficeApi\Enums\Language;

trait HasGeoRangeSearch
{
    private ?array $geoRangeSearch;

    public function geoRangeSearch(
        Language $country,
        int $radius,
        ?string $zip,
    ) {
        $this->geoRangeSearch = [
            'country' => $country->value,
            'radius' => ''.$radius,
        ];
        if ($zip) {
            $this->geoRangeSearch['zip'] = $zip;
        }

        return $this;
    }

    public function geoRangeSearchByCoordinates(
        string $latitude,
        string $longitude,
        int $radius,
    ) {
        $this->geoRangeSearch = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'radius' => ''.$radius,
        ];

        return $this;
    }
}
