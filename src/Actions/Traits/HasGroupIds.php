<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use InvalidArgumentException;

trait HasGroupIds
{
    /**
     * @var int[]|null
     */
    private ?array $groups;

    /**
     * group IDs. Specify here the appointments of which groups you want to read out. Works only in combination with the parameters datestart and dateend.
     *
     * @throws InvalidArgumentException
     */
    public function groupIds(int ...$groupIds)
    {
        if (! isset($this->dateStart) || ! isset($this->dateEnd)) {
            throw new \InvalidArgumentException('Datestart and Dateend must be set in order to use groupIds');
        }
        $this->groups = [
            ...$this->groups ?? [],
            ...$groupIds,
        ];

        return $this;
    }
}
