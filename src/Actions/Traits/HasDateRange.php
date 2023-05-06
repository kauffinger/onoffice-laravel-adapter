<?php

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use Illuminate\Support\Carbon;

/**
 * @var ?string $dateStart
 * @var ?string $dateEnd
 */
trait HasDateRange
{
    private ?string $dateStart;

    private ?string $dateEnd;

    /**
     *  Start date of the time interval for the requested appointments
     */
    public function dateStart(Carbon $date)
    {
        $this->dateStart = $date->format('Y-m-d');

        return $this;
    }

    /**
     *  End date of the time interval for the requested appointments
     */
    public function dateEnd(Carbon $date)
    {
        $this->dateEnd = $date->format('Y-m-d');

        return $this;
    }
}
