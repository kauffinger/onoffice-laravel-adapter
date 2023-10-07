<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\Traits;

use InvalidArgumentException;

trait HasUserIds
{
    /**
     * @var int[]|null
     */
    private ?array $users;

    /**
     * User IDs. Specify here the appointments of which users you want to read out. Works only in combination with the parameters datestart and dateend.
     *
     *
     * @throws InvalidArgumentException
     */
    public function userIds(int ...$userIds)
    {
        if (! isset($this->dateStart) || ! isset($this->dateEnd)) {
            throw new \InvalidArgumentException('Datestart and Dateend must be set in order to use userIds');
        }
        $this->users = [
            ...$this->users ?? [],
            ...$userIds,
        ];

        return $this;
    }
}
