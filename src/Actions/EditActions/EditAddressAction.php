<?php

namespace Kauffinger\OnOfficeApi\Actions\EditActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\EditResource;
use Kauffinger\OnOfficeApi\Enums\SpecialAddressField;

/**
 * `Changes information from address records.`
 */
class EditAddressAction implements ActionInterface
{
    public function __construct(
        private readonly int $resourceId,
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  array<string, string>  $map Keys of fields to change and values they should be changed to. `Land` must be ISO 3166-1 alpha-3. To change the contact data of an address record (telephone, fax, email) additional parameters are necessary and are supported through the `add`, `modify`, and `delete` methods.
     */
    public function update(array $map): self
    {
        $invalidFields = array_intersect(SpecialAddressField::getAllCases(), array_keys($map));
        if ($invalidFields !== []) {
            $invalidFieldString = implode(',', $invalidFields);
            throw new \InvalidArgumentException(
                "Special fields '$invalidFieldString' must be changed using the `add`, `modify`, and `delete` methods."
            );
        }

        foreach ($map as $key => $value) {
            $this->actionArray[$key] = $value;
        }

        return $this;
    }

    public function add(SpecialAddressField $field, string $value, bool $default = false): self
    {
        $this->checkIfSpecialFieldAlreadySet($field);

        $this->actionArray[$field->value] = [
            'action' => 'add',
            'newvalue' => $value,
            'default' => $default,
        ];

        return $this;
    }

    public function modify(SpecialAddressField $field, string $valueToChange, string $newValue, bool $default = false): self
    {
        $this->checkIfSpecialFieldAlreadySet($field);

        $this->actionArray[$field->value] = [
            'action' => 'modify',
            'oldvalue' => $valueToChange,
            'newvalue' => $newValue,
            'default' => $default,
        ];

        return $this;
    }

    public function delete(SpecialAddressField $field, string $value): self
    {
        $this->checkIfSpecialFieldAlreadySet($field);

        $this->actionArray[$field->value] = [
            'action' => 'delete',
            'oldvalue' => $value,
        ];

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->toArray();

        return [
            'actionid' => ActionType::Edit->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => EditResource::Address->value,
            'parameters' => $parameters,
        ];
    }

    private function checkIfSpecialFieldAlreadySet(SpecialAddressField $field): void
    {
        if (isset($this->actionArray[$field->value])) {
            throw new \InvalidArgumentException("Special resource '$field->value' can only be set once per action.");
        }
    }
}
