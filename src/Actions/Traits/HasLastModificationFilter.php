<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use Illuminate\Support\Carbon;

/**
 * @var ?string $lastModificationDateStart
 * @var ?string $lastModificationDateStart
 */
trait HasLastModificationFilter
{
    private ?string $lastModificationDateStart;

    private ?string $lastModificationDateEnd;

    /**
     * Earliest date of last edit for requested appointments. Can be used alone or in combination with modifiedend. Will be ignored if used together with datestart and dateend.
     * Use server time zone, this package automatically converts to UTC as needed by onOffice.
     */
    public function lastModificationDateStart(Carbon $date)
    {
        $this->lastModificationDateStart = $date->timezone('UTC')->format('Y-m-d');

        return $this;
    }

    /**
     * End date of the time interval for the requested appointments. Will be ignored if used together with datestart and dateend.
     * Use server time zone, this package automatically converts to UTC as needed by onOffice.
     */
    public function lastModificationDateEnd(Carbon $date)
    {
        $this->lastModificationDateEnd = $date->format('Y-m-d');

        return $this;
    }
}
