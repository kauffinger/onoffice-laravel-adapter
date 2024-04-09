<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\CreateActions\CreateAddressAction;
use Kauffinger\OnOfficeApi\Enums\SpecialAddressField;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::create()->address();
    expect($instance::class)->toBe(CreateAddressAction::class);
});

it('will render a suitable action array', function () {
    $action = new CreateAddressAction();
    $actionArray = $action
        ->set(
            [
                'Vorname' => 'Peter',
                'Name' => 'Lustig',
                'Strasse' => 'Hauptst. 2',
                'Land' => 'DEU',
                'Geburtsdatum' => '2017-01-31 12:00:00',
            ]
        )
        ->add(SpecialAddressField::Email, 'max.mustermann982@beispiel.de', true)
        ->modify(SpecialAddressField::Phone, '+49 11111111', '+49 22222222')
        ->delete(SpecialAddressField::Fax, '123123123')
        ->render();

    expect($actionArray['parameters'])
        ->toHaveKeys(
            [
                'Vorname',
                'Name',
                'Strasse',
                'Land',
                'Geburtsdatum',
                SpecialAddressField::Email->value,
                SpecialAddressField::Phone->value,
                SpecialAddressField::Fax->value,
            ]
        )
        ->and($actionArray['parameters'][SpecialAddressField::Email->value])
        ->toMatchArray(
            [
                'action' => 'add',
                'newvalue' => 'max.mustermann982@beispiel.de',
                'default' => true,
            ]
        )
        ->and($actionArray['parameters'][SpecialAddressField::Phone->value])
        ->toMatchArray(
            [
                'action' => 'modify',
                'oldvalue' => '+49 11111111',
                'newvalue' => '+49 22222222',
                'default' => false,
            ]
        )
        ->and($actionArray['parameters'][SpecialAddressField::Fax->value])
        ->toMatchArray(
            [
                'action' => 'delete',
                'oldvalue' => '123123123',
            ]
        );

});

it('will not allow illegal arguments in update', function () {
    $invalidKeys = array_fill_keys(SpecialAddressField::getAllCases(), 0);
    (new CreateAddressAction())
        ->set($invalidKeys);
})->throws(InvalidArgumentException::class);

it('will send a successful request', function () {
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::create()
            ->address()
            ->set(
                [
                    'Vorname' => 'Peter',
                    'Name' => 'Lustig',
                    'Strasse' => 'Hauptst. 2',
                    'Land' => 'DEU',
                    'Geburtsdatum' => '2017-01-31 12:00:00',
                ]
            )
    );

    Saloon::fake([
        MockResponse::make([]),
    ]);

    $response = OnOfficeApi::send($request);
    expect($response->ok())->toBeTrue();
});
