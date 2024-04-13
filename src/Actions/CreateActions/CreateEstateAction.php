<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\CreateActions;

use Kauffinger\OnOfficeApi\Contracts\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\Language;
use Kauffinger\OnOfficeApi\Enums\OnOfficeResources\EditResource;
use Kauffinger\OnOfficeApi\Enums\OnOfficeResources\EstateStatus;

/**
 * `Changes information from estate records.`
 */
class CreateEstateAction implements ActionInterface
{
    final public const SPECIAL_FIELDS = ['verkauft', 'reserviert', 'status'];

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  array<string, mixed>  $data  Keys of fields to set and values they should be set to.
     */
    public function set(array $data): self
    {
        $invalidFields = array_intersect(self::SPECIAL_FIELDS, array_keys($data));
        if ($invalidFields !== []) {
            $invalidFieldString = implode(',', $invalidFields);
            throw new \InvalidArgumentException(
                "Special fields '$invalidFieldString' must be changed using the `add`, `modify`, and `delete` methods."
            );
        }
        foreach ($data as $key => $value) {
            $this->actionArray['data'][$key] = $value;
        }

        return $this;
    }

    public function setSold(bool $sold = true): self
    {
        $this->actionArray['data']['verkauft'] = $sold ? 1 : 0;

        return $this;
    }

    public function setReserved(bool $reserved = true): self
    {
        $this->actionArray['data']['reserviert'] = $reserved ? 1 : 0;

        return $this;
    }

    public function setStatus(EstateStatus $status): self
    {
        $this->actionArray['data']['status'] = $status->value;

        return $this;
    }

    /**
     * Language of the object, only relevant for multi-language estates. Specified in ISO format with 3 characters, e.g. DEU, ENG. You cannot query properties in a different language without specifying this parameter. Only the ID is not sufficient! You can only query directly via ID if the property is in the main language.
     */
    public function estateLanguage(Language $estateLanguage)
    {
        $this->actionArray['estatelanguage'] = $estateLanguage->value;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->toArray();

        return [
            'actionid' => ActionType::Create->value,
            'resourceid' => '',
            'resourcetype' => EditResource::Estate->value,
            'parameters' => $parameters,
        ];
    }
}
