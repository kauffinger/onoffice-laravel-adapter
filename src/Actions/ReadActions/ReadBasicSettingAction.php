<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

/**
 * Read out the basic settings in enterprise (Extras->Settings->Basic settings). For now, only the category “Characteristics/CI” on the tab “Basic Data” is returned and a few other settings.
 */
class ReadBasicSettingAction implements ActionInterface
{
    public function __construct(
        private readonly array $actionArray = [
            'data' => [
                'basicData' => [
                    'logo',
                    'color',
                    'color2',
                    'textcolorMail',
                    'claim',
                ],
                'permissions' => ['/onOfficeApp/timetracking/enabled'],
                'team' => ['about'],
            ],
        ],
    ) {

    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => '',
            'resourcetype' => ReadResource::BasicSettings->value,
            'parameters' => $parameters,
        ];
    }
}
