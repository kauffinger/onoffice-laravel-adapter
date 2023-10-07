<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\EditActions\EditAddressAction;
use Kauffinger\OnOfficeApi\Enums\SpecialAddressField;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('can be retrieved from Action base class', function () {
    $instance = Action::edit()->address(0);
    expect($instance::class)->toBe(EditAddressAction::class);
});

it('will render a suitable action array', function () {
    $action = new EditAddressAction(0);
    $actionArray = $action
        ->update(
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

    expect($actionArray['resourceid'])->toBe(0);

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
        );

    expect($actionArray['parameters'][SpecialAddressField::Email->value])
        ->toMatchArray(
            [
                'action' => 'add',
                'newvalue' => 'max.mustermann982@beispiel.de',
                'default' => true,
            ]
        );

    expect($actionArray['parameters'][SpecialAddressField::Phone->value])
        ->toMatchArray(
            [
                'action' => 'modify',
                'oldvalue' => '+49 11111111',
                'newvalue' => '+49 22222222',
                'default' => false,
            ]
        );

    expect($actionArray['parameters'][SpecialAddressField::Fax->value])
        ->toMatchArray(
            [
                'action' => 'delete',
                'oldvalue' => '123123123',
            ]
        );
});

it('will not allow illegal arguments in update', function () {
    $invalidKeys = array_fill_keys(SpecialAddressField::getAllCases(), 0);
    (new EditAddressAction(0))
        ->update($invalidKeys);
})->throws(InvalidArgumentException::class);

it('will send a successful request', function () {
    $mockClient = new MockClient([
        OnOfficeApiRequest::class => MockResponse::fixture('edit/EditAddressAction'),
    ]);
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $api->withMockClient($mockClient);
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::edit()
            ->address(4545)
            ->update(
                [
                    'Vorname' => 'Peter',
                    'Name' => 'Lustig',
                    'Strasse' => 'Hauptst. 2',
                    'Land' => 'DEU',
                    'Geburtsdatum' => '2017-01-31 12:00:00',
                ]
            )
    );

    $response = $api->send($request);
    expect($response->collect()->get('response')['results'][0]['status']['errorcode'])->toBe(0);
});
